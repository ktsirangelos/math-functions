<?php

use PHPUnit\Framework\TestCase;
use MathFunctions\IntegerCalculator;
use MathFunctions\CalculatorInputException;
use MathFunctions\FormatterInputException;

class IntegerCalculatorTest extends TestCase
{
  private $calculator;

  protected function setUp(): void
  {
    $this->calculator = new IntegerCalculator();
  }

  public function testCalcDivisors(): void
  {
    // Valid Integer Inputs
    $this->assertEquals([-3, -2, 2, 3], $this->calculator->calcDivisors(6));
    $this->assertEquals([-4, -2, 2, 4], $this->calculator->calcDivisors(-8));
    $this->assertEquals([-4999, -2, 2, 4999], $this->calculator->calcDivisors(9998));
    $this->assertEquals([-4999, -2, 2, 4999], $this->calculator->calcDivisors(-9998));

    // Edge Cases
    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcDivisors(0);

    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcDivisors(1);

    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcDivisors(-10000);

    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcDivisors(10000);


    // Prime Numbers
    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcDivisors(11);

    // Composite Odd Numbers
    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcDivisors(27);

    // Non-Integer Cases
    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcDivisors('hello');

    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcDivisors(12.65);
  }

  public function testCalcFactorial(): void
  {
    // Valid Values
    $this->assertEquals(1, $this->calculator->calcFactorial(0));
    $this->assertEquals(120, $this->calculator->calcFactorial(5));
    $this->assertEquals(3628800, $this->calculator->calcFactorial(10));

    // Invalid Values
    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcFactorial(-3);

    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcFactorial(15);

    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcFactorial("hello");
  }

  // Test with empty array
  public function testEmptyArray(): void
  {
    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcPrimeNumbers([]);
  }

  // Test with valid prime numbers
  public function testValidPrimeNumbers(): void
  {
    $result = $this->calculator->calcPrimeNumbers([2, 5, 11, 17]);
    $expected = '<?xml version="1.0" encoding="UTF-8"?>
                    <primeNumbers amount="4">
                      <result>
                        <number>2</number>
                        <number>5</number>
                        <number>11</number>
                        <number>17</number>
                      </result>
                    </primeNumbers>';
    $this->assertXmlStringEqualsXmlString($expected, $result);
  }


  // Test with non-prime numbers
  public function testWithNonPrimeNumbers(): void
  {
    $this->expectException(FormatterInputException::class);
    $this->calculator->calcPrimeNumbers([4, 6, 15, 20]);
  }

  // Test with mixed numbers
  public function testMixedNumbers(): void
  {
    $result = $this->calculator->calcPrimeNumbers([2, 9, 13, 30]);
    $expected = '<?xml version="1.0" encoding="UTF-8"?>
                    <primeNumbers amount="2">
                      <result>
                        <number>2</number>
                        <number>13</number>
                      </result>
                    </primeNumbers>';
    $this->assertXmlStringEqualsXmlString($expected, $result);
  }


  // Test with array exceeding 500 elements
  public function testArraySizeException()
  {
    $largeArray = range(1, 501);
    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcPrimeNumbers($largeArray);
  }

  // Test with non-integers
  public function testNonIntegerException()
  {
    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcPrimeNumbers([2, 3.14, 7]);
  }

  // Test with integers exceeding +/- 10000
  public function testIntegerRangeException()
  {
    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcPrimeNumbers([2, 5, 10001]);
  }
}
