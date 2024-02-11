<?php

declare(strict_types=1);

namespace MathFunctions\Tests\Unit\Calculator;

use PHPUnit\Framework\TestCase;
use MathFunctions\IntegerCalculator;
use MathFunctions\Exceptions\CalculatorInputException;
use MathFunctions\Exceptions\FormatterInputException;
use PHPUnit\Framework\Attributes\DataProvider;

class IntegerCalculatorTest extends TestCase
{
  private $calculator;

  protected function setUp(): void
  {
    $this->calculator = new IntegerCalculator();
  }

  public static function calcDivisorsValidDataProvider(): array
  {
    return [
      [6, [-3, -2, 2, 3]],
      [-8, [-4, -2, 2, 4]],
      [9998, [-4999, -2, 2, 4999]],
      [-9998, [-4999, -2, 2, 4999]]
    ];
  }

  #[DataProvider('calcDivisorsValidDataProvider')]
  public function testCalcDivisorsValidInput($integer, $expectedDivisors): void
  {
    $result = $this->calculator->calcDivisors($integer);
    $this->assertEquals($result, $expectedDivisors);
  }

  public static function calcDivisorsInvalidDataProvider(): array
  {
    return [
      [0, 1, -10000, 10000, 11, 27, 12.65, 'string']
    ];
  }

  #[DataProvider('calcDivisorsInvalidDataProvider')]
  public function testCalcDivisorsInvalidInput($invalidInput): void
  {
    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcDivisors($invalidInput);
  }

  public static function calcFactorialValidDataProvider(): array
  {
    return [
      [0, 1],
      [5, 120],
      [10, 3628800],
    ];
  }

  #[DataProvider('calcFactorialValidDataProvider')]
  public function testCalcFactorialValidInput($integer, $expectedFactorial): void
  {
    $result = $this->calculator->calcFactorial($integer);
    $this->assertEquals($result, $expectedFactorial);
  }

  public static function calcFactorialInvalidDataProvider(): array
  {
    return [
      [-3, 15, "string"]
    ];
  }

  #[DataProvider('calcFactorialInvalidDataProvider')]
  public function testCalcFactorialInvalidInput($invalidInput): void
  {
    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcFactorial($invalidInput);
  }

  public static function calcPrimeNumbersValidDataProvider(): array
  {
    return [
      [
        [2, 5, 11, 17],
        '<?xml version="1.0" encoding="UTF-8"?>
                    <primeNumbers amount="4">
                      <result>
                        <number>2</number>
                        <number>5</number>
                        <number>11</number>
                        <number>17</number>
                      </result>
                    </primeNumbers>'
      ],
      [
        [2, 9, 13, 30],
        '<?xml version="1.0" encoding="UTF-8"?>
                    <primeNumbers amount="2">
                      <result>
                        <number>2</number>
                        <number>13</number>
                      </result>
                    </primeNumbers>'
      ],
    ];
  }

  #[DataProvider('calcPrimeNumbersValidDataProvider')]
  public function testCalcPrimeNumbersValidInput($integerArray, $xmlDoc): void
  {
    $result = $this->calculator->calcPrimeNumbers($integerArray);
    $this->assertXmlStringEqualsXmlString($result, $xmlDoc);
  }

  public static function calcPrimeNumbersInvalidDataProvider(): array
  {
    return [
      [range(1, 501)],
      [[2, 3.14, 7]],
      [[2, 5, 10001]],
      [[]]
    ];
  }

  #[DataProvider('calcPrimeNumbersInvalidDataProvider')]
  public function testCalcPrimeNumbersInvalidInput($invalidInput): void
  {
    $this->expectException(CalculatorInputException::class);
    $this->calculator->calcPrimeNumbers($invalidInput);
  }

  public function testCalcPrimeNumbersWithNonPrimeNumbers(): void
  {
    $this->expectException(FormatterInputException::class);
    $this->calculator->calcPrimeNumbers([4, 6, 15, 20]);
  }
}
