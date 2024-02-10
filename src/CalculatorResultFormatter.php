<?php

namespace MathFunctions;

/**
 * Provides XML formatting functionality for mathematical results.
 */
class CalculatorResultFormatter
{
  /**
   * Formats mathematical calculation results into an XML string.
   *
   * @param string $operationType The type of mathematical operation performed (e.g., "addition", "subtraction").
   * @param array $numbers        An array of numbers used in the calculation.
   *
   * @return string The formatted XML string representing the calculation result.
   */
  public function toXML(string $operationType, array $numbers): string
  {
    $xml = new \SimpleXMLElement('<' . $operationType . '/>');
    $xml->addAttribute('amount', count($numbers));
    $result = $xml->addChild('result');

    foreach ($numbers as $number) {
      $result->addChild('number', $number);
    }

    return $xml->asXML();
  }
}
