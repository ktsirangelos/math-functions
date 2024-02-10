<?php

declare(strict_types=1);

namespace MathFunctions\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use MathFunctions\CalculatorResultFormatter;

class CalculatorResultFormatterTest extends TestCase
{
  public static function xmlOutputDataProvider(): array
  {
    return [
      ['addition', [2, 3, 5], '<addition amount="3"><result><number>2</number><number>3</number><number>5</number></result></addition>'],
      ['subtraction', [10, 5], '<subtraction amount="2"><result><number>10</number><number>5</number></result></subtraction>'],
      ['multiplication', [4, 0, 6], '<multiplication amount="3"><result><number>4</number><number>0</number><number>6</number></result></multiplication>'],
    ];
  }

  #[DataProvider('xmlOutputDataProvider')]
  public function testToXML($operationType, $numbers, $expectedXML)
  {
    $formatter = new CalculatorResultFormatter();
    $result = $formatter->toXML($operationType, $numbers);

    $this->assertXmlStringEqualsXmlString($expectedXML, $result);
  }

  public function testToXMLWithEmptyInput()
  {
    $formatter = new CalculatorResultFormatter();
    $result = $formatter->toXML('division', []);

    $this->assertXmlStringEqualsXmlString('<division amount="0"><result/></division>', $result);
  }
}
