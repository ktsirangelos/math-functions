<?php

namespace MathFunctions;

class MathResultFormatter
{
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
