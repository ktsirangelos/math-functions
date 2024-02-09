<?php

use PHPUnit\Framework\TestCase;
use MathFunctions\IntegerOperations;
use MathFunctions\MathInputException;

class IntegerOperationsTest extends TestCase
{
  private $operation;

  protected function setUp(): void
  {
    $this->operation = new IntegerOperations();
  }

  public function testCalcDivisors()
  {
    // Valid Integer Inputs
    $this->assertEquals([-3, -2, 2, 3], $this->operation->calcDivisors(6));
    $this->assertEquals([-4, -2, 2, 4], $this->operation->calcDivisors(-8));
    $this->assertEquals([-4999, -2, 2, 4999], $this->operation->calcDivisors(9998));
    $this->assertEquals([-4999, -2, 2, 4999], $this->operation->calcDivisors(-9998));

    // Edge Cases
    $this->expectException(MathInputException::class);
    $this->operation->calcDivisors(0);

    $this->expectException(MathInputException::class);
    $this->operation->calcDivisors(1);

    $this->expectException(MathInputException::class);
    $this->operation->calcDivisors(-10000);

    $this->expectException(MathInputException::class);
    $this->operation->calcDivisors(10000);


    // Prime Numbers
    $this->expectException(MathInputException::class);
    $this->operation->calcDivisors(11);

    // Composite Odd Numbers
    $this->expectException(MathInputException::class);
    $this->operation->calcDivisors(27);

    // Non-Integer Cases
    $this->expectException(MathInputException::class);
    $this->operation->calcDivisors('hello');

    $this->expectException(MathInputException::class);
    $this->operation->calcDivisors(12.65);
  }
}
