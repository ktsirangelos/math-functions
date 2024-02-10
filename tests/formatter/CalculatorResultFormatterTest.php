<?php

declare(strict_types=1);

namespace MathFunctions\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use MathFunctions\CalculatorResultFormatter;
use MathFunctions\FormatterInputException;

class CalculatorResultFormatterTest extends TestCase
{
  private $formatter;

  protected function setUp(): void
  {
    $this->formatter = new CalculatorResultFormatter();
  }

  public static function xmlOutputDataProvider(): array
  {
    return [
      ['primeNumbers', [2, 3, 5], '<primeNumbers amount="3"><result><number>2</number><number>3</number><number>5</number></result></primeNumbers>'],
      ['evenNumbers', [6, 8], '<evenNumbers amount="2"><result><number>6</number><number>8</number></result></evenNumbers>'],
      ['negativeNumbers', [-4, -7, -9], '<negativeNumbers amount="3"><result><number>-4</number><number>-7</number><number>-9</number></result></negativeNumbers>'],
    ];
  }

  #[DataProvider('xmlOutputDataProvider')]
  public function testToXML($numbersType, $numbers, $expectedXML): void
  {
    $result = $this->formatter->toXML($numbersType, $numbers);
    $this->assertXmlStringEqualsXmlString($expectedXML, $result);
  }

  public function testToXMLWithEmptyInput(): void
  {

    $this->expectException(FormatterInputException::class);
    $this->formatter->toXML('emptyArray', []);
  }
}
