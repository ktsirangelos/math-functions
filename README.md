# MathFunctions

The MathFunctions package provides a set of classes for performing various integer-based mathematical operations. It includes functionalities for calculating divisors, factorials, and identifying prime numbers within an array of integers. Additionally, it offers XML formatting for presenting calculation results.

## Table of Contents

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Running Unit Tests](#running-unit-tests)
4. [Usage](#usage)
5. [Exceptions](#exceptions)
6. [Contributing](#contributing)
7. [License](#license)

## Requirements

- [PHP](https://www.php.net/) 8.2 or higher
- [Composer](https://getcomposer.org/) (for installation)

## Installation

```bash
$ composer require ktsirangelos/math-functions
```

## Running Unit Tests

To run the unit tests for this library:

1. Clone the GitHub repository

```bash
$ git clone https://github.com/ktsirangelos/math-functions.git
```

2. Install dependencies

```bash
$ cd math-functions
$ composer install
```

3. Execute the tests

```bash
$ ./vendor/bin/phpunit tests
```

## Usage

### Calculating Divisors

To calculate the positive and negative divisors of an integer (excluding 1 and itself), use the `calcDivisors()` method:

```php
use MathFunctions\IntegerCalculator;

$integerCalculator = new IntegerCalculator();
// Example usage with integer 12
$divisors = $integerCalculator->calcDivisors(12);
// Expected Output: [-6, -4, -3, -2, 2, 3, 4, 6]
```

### Calculating Factorials

To calculate the factorial of an integer, use the `calcFactorial()` method:

```php
use MathFunctions\IntegerCalculator;

$integerCalculator = new IntegerCalculator();
// Example usage with integer 5
$factorial = $integerCalculator->calcFactorial(5);
// Expected Output: 120
```

### Identifying Prime Numbers

To find prime numbers within an array of integers and receive the results in XML format, use the `calcPrimeNumbers()` method:

```php
use MathFunctions\IntegerCalculator;

$integerCalculator = new IntegerCalculator();
// Example usage with an array of integers
$primeNumbersXML = $integerCalculator->calcPrimeNumbers([2, 3, 4, 5, 6, 7]);
// Expected Output (XML string):
// <primeNumbers amount="4">
//   <result>
//     <number>2</number>
//     <number>3</number>
//     <number>5</number>
//     <number>7</number>
//   </result>
// </primeNumbers>
```

### Formatting Calculation Results

You can format calculation results into an XML string using the `toXML` method:

```php
use MathFunctions\Utilities\ResultFormatter;

$resultFormatter = new ResultFormatter();
// Example usage with an array of even numbers
$xmlResult = $resultFormatter->toXML('evenNumbers', [2, 4, 6, 8]);
// Expected Output (XML string):
// <evenNumbers amount="4">
//   <result>
//     <number>2</number>
//     <number>4</number>
//     <number>6</number>
//     <number>8</number>
//   </result>
// </evenNumbers>
```

## Exceptions

The functions may throw exceptions for invalid inputs. Ensure to catch and handle these exceptions appropriately in your code.

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, feel free to open an issue or submit a pull request.

## License

This package is licensed under the MIT License. See the [LICENSE](./LICENSE) file for details.
