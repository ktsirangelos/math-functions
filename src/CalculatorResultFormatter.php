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
   * @throws FormatterInputException If the input array is empty.
   */
  public function toXML(string $numbersType, array $numbers): string
  {
    if (empty($numbers)) {
      throw new FormatterInputException('Input array cannot be empty');
    }

    $dom = new \DOMDocument('1.0', 'UTF-8');

    $root = $dom->createElement($numbersType);
    $root->setAttribute('amount', count($numbers));
    $dom->appendChild($root);

    $resultNode = $dom->createElement('result');
    $root->appendChild($resultNode);

    foreach ($numbers as $number) {
      $numberNode = $dom->createElement('number', $number);
      $resultNode->appendChild($numberNode);
    }

    return $dom->saveXML();
  }
}
