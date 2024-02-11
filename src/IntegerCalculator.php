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
  const MIN_ALLOWED_INTEGER = - (self::MAX_ALLOWED_INTEGER);
  const MAX_FACTORIAL_RANGE = 12;
  const MAX_ARRAY_SIZE = 500;

  /* Precalculated Factorials */
  /* As the input can only be between 0 and 12, calcFactorial employs a precalculated lookup table */
  /* to quickly retrieve the factorial values within the supported range. This significantly optimizes  */
  /* the calculation compared to an iterative or recursive approach. */
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
   * @param int $integer The integer to find divisors for.
   * @return int[] An array of divisors.
   * @throws InvalidArgumentException If the input is not an integer.
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
   * Calculates the factorial of a number.
   *
   * @param int $number The number to calculate the factorial of.
   * @return int The factorial of the number.
   * @throws InvalidArgumentException If the input is not an integer.
   * @throws CalculatorInputException If the input is invalid.
   */
  public function calcFactorial(int $number): int
  {
    if ($number < 0 || $number > self::MAX_FACTORIAL_RANGE) {
      throw new CalculatorInputException("Input must be between 0 and " . self::MAX_FACTORIAL_RANGE);
    }
    return self::FACTORIALS[$number];

    // Alternative dynamic approach
    //
    // if ($number == 0) {
    //  return 1;
    // }
    //
    // $result = 1;
    // for ($i = 2; $i <= $number; $i++) {
    //  $result *= $i;
    // }
    //
    // return $result;

  }

  /**
   * Finds prime numbers within an array of integers and returns them in XML format.
   *
   * @param int[] $integerArray An array of integers.
   * @return string An XML string containing the prime numbers with an 'amount' attribute.
   * @throws CalculatorInputException If the input is invalid.
   */
  public function calcPrimeNumbers(array $integerArray): string
  {
    if (empty($integerArray)) {
      throw new CalculatorInputException('Input array cannot be empty');
    }
    if (count($integerArray) > self::MAX_ARRAY_SIZE) {
      throw new CalculatorInputException("Array cannot exceed " . self::MAX_ARRAY_SIZE . " elements");
    }
    foreach ($integerArray as $integer) {
      if (!is_int($integer)) {
        throw new CalculatorInputException("All elements in the array must be integers");
      }
      if (abs($integer) > self::MAX_ALLOWED_INTEGER) {
        throw new CalculatorInputException(
          "Individual integers cannot exceed +/- " . self::MAX_ALLOWED_INTEGER
        );
      }
    }

    $primeNumbers = [];

    foreach ($integerArray as $number) {
      if ($this->isPrime($number)) {
        $primeNumbers[] = $number;
      }
    }

    return (new ResultFormatter())->toXML('primeNumbers', $primeNumbers);
  }

  /**
   * Determines whether an integer is a prime number.
   *
   * @param int $integer The integer to check for primality.
   * @return bool True if the number is prime, false otherwise.
   * @throws InvalidArgumentException If the input is invalid.
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
