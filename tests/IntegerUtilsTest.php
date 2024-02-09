<?php

use MathFunctions\IntegerUtils;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/IntegerUtils.php';

class IntegerUtilsTest extends TestCase
{
  private $solution;

  protected function setUp(): void
  {
    $this->solution = new IntegerUtils();
  }

  public function testCalcDivisors()
  {
    // Valid Integer Inputs
    $this->assertEquals([2, 3], $this->solution->calcDivisors(6));
    $this->assertEquals([2, 4], $this->solution->calcDivisors(-8));
    $this->assertEquals([2, 4999], $this->solution->calcDivisors(9998));
    $this->assertEquals([2, 4999], $this->solution->calcDivisors(-9998));

    // Edge Cases
    $this->expectException(InvalidArgumentException::class);
    $this->solution->calcDivisors(0);

    $this->expectException(InvalidArgumentException::class);
    $this->solution->calcDivisors(1);

    $this->expectException(InvalidArgumentException::class);
    $this->solution->calcDivisors(-10000);

    $this->expectException(InvalidArgumentException::class);
    $this->solution->calcDivisors(10000);

    $this->expectException(InvalidArgumentException::class);
    $this->solution->calcDivisors(-10001);

    $this->expectException(InvalidArgumentException::class);
    $this->solution->calcDivisors(10001);

    // Prime Numbers
    $this->expectException(InvalidArgumentException::class);
    $this->solution->calcDivisors(11);

    // Composite Odd Numbers
    $this->expectException(InvalidArgumentException::class);
    $this->solution->calcDivisors(27);

    // Non-Integer Cases
    $this->expectException(InvalidArgumentException::class);
    $this->solution->calcDivisors('hello');

    $this->expectException(InvalidArgumentException::class);
    $this->solution->calcDivisors(12.65);

    // $this->expectException(InvalidArgumentException::class);
    // $this->solution->calcDivisors(NAN);

    // $this->expectException(InvalidArgumentException::class);
    // $this->solution->calcDivisors([1, 2, 3]); // Array
  }

  // ... Tests for calcFactorial, calcPrimeNumbers, etc. ...
}
