<?php

namespace MathFunctions;

class IntegerUtils
{
  /**
   * Calculates the divisors of an integer (excluding 1 and itself).
   *
   * @param int $integer The integer to find divisors for.
   * @return int[] An array of divisors.
   * @throws InvalidArgumentException If the input is not an integer, is zero, is one, is
   *         outside the range -10000 to 10000, or is a prime number.
   */
  public function calcDivisors(int $integer): array
  {
    if (!is_int($integer)) {
      throw new \InvalidArgumentException("Input must be an integer");
    }
    if ($integer == 0) {
      throw new \InvalidArgumentException("Input must not be zero");
    }
    if ($integer == 1) {
      throw new \InvalidArgumentException("Input must not be one");
    }
    if ($integer < -10000 || $integer > 10000) {
      throw new \InvalidArgumentException("Input must be between -10000 and 10000.");
    }
    if ($this->isPrime(abs($integer))) {
      throw new \InvalidArgumentException("Prime numbers are not allowed.");
    }

    $divisors = [];
    $absInteger = abs($integer);
    $sqrtInteger = sqrt($absInteger);

    for ($i = 2; $i <= $sqrtInteger; $i++) {
      if ($absInteger % $i == 0) {
        array_push($divisors, $i);
        if ($i != $sqrtInteger) {
          array_push($divisors, $absInteger / $i);
        }
      }
    }

    sort($divisors);
    return $divisors;
  }

  /**
   * Calculates the factorial of a number.
   *
   * @param int $integer The number to calculate the factorial of.
   * @return int The factorial of the number.
   * @throws InvalidArgumentException If the input is not an integer or is outside the range 0 to 12.
   */
  public function calcFactorial(int $integer): int
  {
    if (!is_int($integer)) {
      throw new \InvalidArgumentException("Input must be an integer");
    }
    if ($integer < 0 || $integer > 12) {
      throw new \InvalidArgumentException("Input must be between 0 and 12");
    }
    $factorials = [1, 1, 2, 6, 24, 120, 720, 5040, 40320, 362880, 3628800, 39916800, 479001600];
    return $factorials[$integer];
  }

  /**
   * Finds prime numbers within an array of integers and returns them in XML format.
   *
   * @param int[] $integerArray An array of integers.
   * @return string An XML string containing the prime numbers with an 'amount' attribute.
   * @throws InvalidArgumentException If the input is not an array, is empty, contains non-integer elements,
   *         exceeds 500 elements, or individual integers exceed +/- 10000.
   */
  public function calcPrimeNumbers(array $integerArray): string
  {
    if (!is_array($integerArray)) {
      throw new \InvalidArgumentException("Input must be an array");
    }
    if (count($integerArray) < 1) {
      return '<primeNumbers amount="0"><result/></primeNumbers>';
    }
    if (count($integerArray) > 500) {
      throw new \InvalidArgumentException("Array cannot exceed 500 elements");
    }
    foreach ($integerArray as $integer) {
      if (!is_int($integer)) {
        throw new \InvalidArgumentException("All elements in the array must be integers");
      }
      if (abs($integer) > 10000) {
        throw new \InvalidArgumentException("Individual integers cannot exceed +/- 10000");
      }
    }

    $primeNumbers = [];
    foreach ($integerArray as $integer) {
      if ($this->isPrime($integer)) {
        $primeNumbers[] = $integer;
      }
    }

    $xml = new \SimpleXMLElement('<primeNumbers/>');
    $xml->addAttribute('amount', count($primeNumbers));
    $result = $xml->addChild('result');
    foreach ($primeNumbers as $prime) {
      $result->addChild('number', $prime);
    }
    return $xml->asXML();
  }

  /**
   * Determines whether a number is a prime number.
   *
   * @param int $integer The number to check.
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
