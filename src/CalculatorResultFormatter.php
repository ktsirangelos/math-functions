<?php

namespace MathFunctions;

use MathFunctions\FormatterInputException;

/**
 * Provides XML formatting functionality for mathematical results.
 */
class CalculatorResultFormatter
{
  /**
   * Formats mathematical calculation results into an XML string.
   *
   * @param string $numbersType The type of numbers to be placed in the parent element (e.g. "primeNumbers").
   * @param array $numbers An array of numbers to be placed in the child elements.
   *
   * @return string The formatted XML string representing the calculation result.
   */
  public function toXML(string $numbersType, array $numbers): string
  {
    if (empty($numbers)) {
      throw new FormatterInputException('Input array cannot be empty');
    }

    $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><' . $numbersType . '/>');

    $xml->addAttribute('amount', count($numbers));
    $result = $xml->addChild('result');

    foreach ($numbers as $number) {
      $result->addChild('number', $number);
    }

    return $xml->asXML();
  }
}
