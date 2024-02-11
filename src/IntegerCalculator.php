<?php

declare(strict_types=1);

namespace MathFunctions;

use MathFunctions\Exceptions\CalculatorInputException;
use MathFunctions\Utilities\ResultFormatter;

/**
 * A class providing various integer-based mathematical operations.
 */
class IntegerCalculator
{
  const MAX_ALLOWED_INTEGER = 10000;
  const MIN_ALLOWED_INTEGER = -10000;
  const MAX_FACTORIAL_RANGE = 12;
  const MAX_ARRAY_SIZE = 500;
  const FACTORIALS = [
    0 => 1,
    1 => 1,
    2 => 2,
    3 => 6,
    4 => 24,
    5 => 120,
    6 => 720,
    7 => 5040,
    8 => 40320,
    9 => 362880,
    10 => 3628800,
    11 => 39916800,
    12 => 479001600
  ];

  /**
   * Calculates the positive and negative divisors of an integer (excluding 1 and itself).
   *
   * Explanation:
   * 1. **Input Validation:**
   *    - Throws exceptions if the input is:
   *       * 0 (division by zero is undefined)
   *       * 1 or -1 (these numbers have no divisors other than 1 and themselves)
   *       * Outside a predefined range (`MIN_ALLOWED_INTEGER`, `MAX_ALLOWED_INTEGER`) to 
   *         prevent performance issues and memory overflow.
   *       * A prime number (prime numbers have no divisors other than 1 and themselves)
   * 2. **Efficient Calculation:**
   *    - Computes the absolute value of the input for easier operations.
   *    - Calculates the square root of the absolute input.
   *    - Iterates only up to the square root of the input. For every divisor found below the 
   *      square root, the complementary divisor (input / divisor) is also calculated, eliminating 
   *      redundant checks.
   * 3. **Handling Square Roots:**
   *    - If 'i' is the square root of the input integer, it's only added once to the divisor list 
   *      to avoid duplication.
   * 4. **Sorting:**
   *    - Sorts the found divisors in ascending order for organized output.  
   *
   * @param int $integer The integer to find divisors for.
   * @return int[] An array of divisors.
   * @throws CalculatorInputException If the input is invalid.
   */
  public function calcDivisors(int $integer): array
  {
    if ($integer == 0) {
      throw new CalculatorInputException("Input must not be zero");
    }
    if ($integer == 1 || $integer == -1) {
      throw new CalculatorInputException("Input must not be one or negative one");
    }
    if ($integer < self::MIN_ALLOWED_INTEGER || $integer > self::MAX_ALLOWED_INTEGER) {
      throw new CalculatorInputException(
        "Input must be between " . self::MIN_ALLOWED_INTEGER . " and " . self::MAX_ALLOWED_INTEGER
      );
    }

    if ($this->isPrime(abs($integer))) {
      throw new CalculatorInputException("Prime numbers are not allowed.");
    }

    $divisors = [];
    $absInteger = abs($integer);
    $sqrtInteger = sqrt($absInteger);

    for ($i = 2; $i <= $sqrtInteger; $i++) {
      if ($absInteger % $i == 0) {
        array_push($divisors, $i, -$i);

        if ($i != $sqrtInteger) {
          $complDivisor = $absInteger / $i;
          array_push($divisors, $complDivisor, -$complDivisor);
        }
      }
    }

    sort($divisors);

    return $divisors;
  }

  /**
   * Calculates the factorial of an integer. Factorial is the product of all positive integers 
   * less than or equal to a given number. (e.g., the factorial of 5 is 5 * 4 * 3 * 2 * 1)
   *
   * Explanation:
   * 1. **Input Validation:**
   *    - Throws an exception if the input integer is:
   *       * Negative (factorials are undefined for negative numbers).
   *       * Greater than a predefined maximum (`MAX_FACTORIAL_RANGE`) to prevent computationally 
   *         expensive and potentially inaccurate calculations for very large factorials.
   * 2. **Precalculated Factorials:**
   *    - The function likely employs a precalculated lookup table (`FACTORIALS`) to quickly 
   *      retrieve the factorial values within the supported range. This significantly optimizes 
   *      the calculation compared to an iterative or recursive approach.
   *
   * @param int $integer The integer to calculate the factorial of.
   * @return int The factorial of the number.
   * @throws CalculatorInputException If the input is invalid.
   */
  public function calcFactorial(int $integer): int
  {
    if ($integer < 0 || $integer > self::MAX_FACTORIAL_RANGE) {
      throw new CalculatorInputException("Input must be between 0 and " . self::MAX_FACTORIAL_RANGE);
    }
    return self::FACTORIALS[$integer];
  }

  /**
   * Finds prime numbers within an array of integers and returns them in XML format.
   *
   * Explanation:
   * 1. **Input Validation:**
   *    - Throws an exception if the input array is empty.
   *    - Restricts the maximum size of the input array (`MAX_ARRAY_SIZE`) to prevent performance 
   *      issues and potential memory overflow.
   *    - Ensures all elements in the array are integers.
   *    - Limits the magnitude of individual integers (`MAX_ALLOWED_INTEGER`) for performance 
   *      and memory management.
   * 2. **Prime Number Identification:**
   *    - Iterates through the input array.
   *    - Uses the `isPrime` function to determine if each number is prime.
   *    - Stores prime numbers in the `$primeNumbers` array.
   * 3. **XML Formatting:**
   *    - Employs the `ResultFormatter` class (assumed to be an external formatter) to convert the 
   *      `$primeNumbers` array into an XML string with the root element 'primeNumbers'.
   *    - The XML string includes an 'amount' attribute indicating the count of prime numbers found.
   *
   * @param int[] $integerArray An array of integers.
   * @return string An XML string containing the prime numbers with an 'amount' attribute.
   * @throws CalculatorInputException If the input is invalid.
   */
  public function calcPrimeNumbers(array $numberArray): string
  {
    if (empty($numberArray)) {
      throw new CalculatorInputException('Input array cannot be empty');
    }
    if (count($numberArray) > self::MAX_ARRAY_SIZE) {
      throw new CalculatorInputException("Array cannot exceed " . self::MAX_ARRAY_SIZE . " elements");
    }
    foreach ($numberArray as $number) {
      if (!is_int($number)) {
        throw new CalculatorInputException("All elements in the array must be integers");
      }
      if (abs($number) > self::MAX_ALLOWED_INTEGER) {
        throw new CalculatorInputException(
          "Individual integers cannot exceed +/- " . self::MAX_ALLOWED_INTEGER
        );
      }
    }

    $primeNumbers = [];

    foreach ($numberArray as $number) {
      if ($this->isPrime($number)) {
        $primeNumbers[] = $number;
      }
    }

    return (new ResultFormatter())->toXML('primeNumbers', $primeNumbers);
  }

  /**
   * Determines whether an integer is a prime number. A prime number is a natural number
   * greater than 1 that is divisible only by itself and 1. This function uses an optimized
   * approach for increased efficiency. 
   *
   * Explanation:
   * 1. **Base Cases:**
   *    - Handles numbers less than or equal to 1 (not prime).
   *    - Handles 2 and 3 (known primes).
   * 2. **Divisibility by 2 and 3:** 
   *    - Quickly eliminates any integer divisible by 2 or 3.
   * 3. **Optimized Loop:**
   *    - The loop starts from 5 and increments by 6 in each iteration. This is because all 
   *      prime numbers greater than 3 can be represented in the form 6k ± 1 (where k is an integer).
   *    - Only iterates up to the square root of the input integer. If a number has a divisor 
   *      greater than its square root, it must also have a divisor smaller than its square root.
   * 4. **Checking Divisibility:**
   *    - For each value 'i' in the loop, it checks if the input integer is divisible by 'i' or 
   *      'i + 2' (covering both 6k - 1 and 6k + 1 possibilities). If divisible, the number is not prime. 
   *
   * @param int $integer The integer to check for primality.
   * @return bool True if the number is prime, false otherwise.
   */
  private function isPrime(int $integer): bool
  {
    if ($integer <= 1) return false;
    if ($integer <= 3) return true;
    if ($integer % 2 == 0 || $integer % 3 == 0) return false;

    $sqrtInteger = sqrt($integer);

    for ($i = 5; $i <= $sqrtInteger; $i += 6) {
      if ($integer % $i == 0 || $integer % ($i + 2) == 0) {
        return false;
      }
    }

    return true;
  }
}
