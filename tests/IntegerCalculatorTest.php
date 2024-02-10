<?php

use PHPUnit\Framework\TestCase;
use MathFunctions\IntegerCalculator;
use MathFunctions\MathInputException;

class IntegercalculatorsTest extends TestCase
{
  private $calculator;

  protected function setUp(): void
  {
    $this->calculator = new IntegerCalculator();
  }

  public function testCalcDivisors()
  {
    // Valid Integer Inputs
    $this->assertEquals([-3, -2, 2, 3], $this->calculator->calcDivisors(6));
    $this->assertEquals([-4, -2, 2, 4], $this->calculator->calcDivisors(-8));
    $this->assertEquals([-4999, -2, 2, 4999], $this->calculator->calcDivisors(9998));
    $this->assertEquals([-4999, -2, 2, 4999], $this->calculator->calcDivisors(-9998));

    // Edge Cases
    $this->expectException(MathInputException::class);
    $this->calculator->calcDivisors(0);

    $this->expectException(MathInputException::class);
    $this->calculator->calcDivisors(1);

    $this->expectException(MathInputException::class);
    $this->calculator->calcDivisors(-10000);

    $this->expectException(MathInputException::class);
    $this->calculator->calcDivisors(10000);


    // Prime Numbers
    $this->expectException(MathInputException::class);
    $this->calculator->calcDivisors(11);

    // Composite Odd Numbers
    $this->expectException(MathInputException::class);
    $this->calculator->calcDivisors(27);

    // Non-Integer Cases
    $this->expectException(MathInputException::class);
    $this->calculator->calcDivisors('hello');

    $this->expectException(MathInputException::class);
    $this->calculator->calcDivisors(12.65);
  }
}
