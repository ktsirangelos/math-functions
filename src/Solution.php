<?php

namespace MathFunctions;

class IntegerUtils
{
  /**
   * Calculates the divisors of an integer (excluding 1 and itself).
   *
   * @param int $num The integer to find divisors for.
   * @return int[] An array of divisors.
   * @throws InvalidArgumentException If the input is not an integer, is zero, is one, is
   *                 outside the range -10000 to 10000, or is a prime number.
   */
  public function calcDivisors(int $num): array
  {
    if (!is_int($num)) {
      throw new \InvalidArgumentException("Input must be an integer");
    }
    if ($num == 0) {
      throw new \InvalidArgumentException("Input must not be zero");
    }
    if ($num == 1) {
      throw new \InvalidArgumentException("Input must not be one");
    }
    if ($num < -10000 || $num > 10000) {
      throw new \InvalidArgumentException("Input must be between -10000 and 10000.");
    }
    if ($this->isPrime(abs($num))) {
      throw new \InvalidArgumentException("Prime numbers are not allowed.");
    }

    $divisors = array();
    $num = abs($num);
    for ($i = 2; $i <= sqrt($num); $i++) {
      if ($num % $i == 0) {
        array_push($divisors, $i);
        array_push($divisors, $num / $i);
      }
    }
    sort($divisors);
    return $divisors;
  }

  /**
   * Calculates the factorial of a number.
   *
   * @param int $num The number to calculate the factorial of.
   * @return int The factorial of the number.
   * @throws InvalidArgumentException If the input is not an integer or is outside the range 0 to 12.
   */
  public function calcFactorial(int $num): int
  {
    if (!is_int($num)) {
      throw new \InvalidArgumentException("Input must be an integer");
    }
    if ($num < 0 || $num > 12) {
      throw new \InvalidArgumentException("Input must be between 0 and 12");
    }
    $factorials = [1, 1, 2, 6, 24, 120, 720, 5040, 40320, 362880, 3628800, 39916800, 479001600];
    return $factorials[$num];
  }

  /**
   * Finds prime numbers within an array of integers and returns them in XML format.
   *
   * @param int[] $integersArray An array of integers.
   * @return string An XML string containing the prime numbers with an 'amount' attribute.
   * @throws InvalidArgumentException If the input is not an array, is empty, contains non-integer elements,
   *                 exceeds 500 elements, or if individual integers exceed +/- 10000.
   */
  public function calcPrimeNumbers(array $integersArray): string
  {
    if (!is_array($integersArray)) {
      throw new \InvalidArgumentException("Input must be an array");
    }
    if (count($integersArray) < 1) {
      return '<primeNumbers amount="0"><result/></primeNumbers>';
    }
    if (count($integersArray) > 500) {
      throw new \InvalidArgumentException("Array cannot exceed 500 elements");
    }
    foreach ($integersArray as $num) {
      if (!is_int($num)) {
        throw new \InvalidArgumentException("All elements in the array must be integers");
      }
      if (abs($num) > 10000) {
        throw new \InvalidArgumentException("Individual integers cannot exceed +/- 10000");
      }
    }

    $primeNumbers = [];
    foreach ($integersArray as $num) {
      if ($this->isPrime($num)) {
        $primeNumbers[] = $num;
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
   *  Determines whether a number is a prime number.
   *
   * @param int $number The number to check.
   * @return bool True if the number is prime, false otherwise.
   */
  private function isPrime(int $number): bool
  {
    if ($number <= 1) return false;
    if ($number <= 3) return true;
    if ($number % 2 == 0 || $number % 3 == 0) return false;

    $sqrtNumber = sqrt($number);
    for ($i = 5; $i <= $sqrtNumber; $i += 6) {
      if ($number % $i == 0 || $number % ($i + 2) == 0) {
        return false;
      }
    }
    return true;
  }
}
