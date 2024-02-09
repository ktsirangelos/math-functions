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
    $this->assertEquals([2, 3], $this->operation->calcDivisors(6));
    $this->assertEquals([2, 4], $this->operation->calcDivisors(-8));
    $this->assertEquals([2, 4999], $this->operation->calcDivisors(9998));
    $this->assertEquals([2, 4999], $this->operation->calcDivisors(-9998));

    // Edge Cases
    $this->expectException(MathInputException::class);
    $this->operation->calcDivisors(0);

    $this->expectException(MathInputException::class);
    $this->operation->calcDivisors(1);

    $this->expectException(MathInputException::class);
    $this->operation->calcDivisors(-10000);

    $this->expectException(MathInputException::class);
    $this->operation->calcDivisors(10000);

    $this->expectException(MathInputException::class);
    $this->operation->calcDivisors(-10001);

    $this->expectException(MathInputException::class);
    $this->operation->calcDivisors(10001);

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

    // $this->expectException(MathInputException::class);
    // $this->operation->calcDivisors(NAN);

    // $this->expectException(MathInputException::class);
    // $this->operation->calcDivisors([1, 2, 3]); // Array
  }

  // ... Tests for calcFactorial, calcPrimeNumbers, etc. ...
}
