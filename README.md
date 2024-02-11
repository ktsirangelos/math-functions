# MathFunctions

The MathFunctions package provides a set of classes for performing various integer-based mathematical operations. It includes functionalities for calculating divisors, factorials, and identifying prime numbers within an array of integers. Additionally, it offers XML formatting for presenting calculation results.

## Table of Contents

1. [Installation](#installation)
2. [Usage](#usage)
3. [Exceptions](#exceptions)
4. [Requirements](#requirements)
5. [Contributing](#contributing)
6. [License](#license)

## Installation

You can install the MathFunctions package via [Composer](https://getcomposer.org/):

```bash
composer require ktsirangelos/math-functions
```

## Usage

### Calculating Divisors

To calculate the positive and negative divisors of an integer (excluding 1 and itself), use the calcDivisors() method:

```php
use MathFunctions\IntegerCalculator;

$integerCalculator = new IntegerCalculator();
// Example usage with integer 12
$divisors = $integerCalculator->calcDivisors(12);
// Expected Output: [-6, -4, -3, -2, 2, 3, 4, 6]
```

#### Mathematical Explanation

- Initialization

  `divisors = []`: Creates an empty array to store the discovered divisors.\
  `absInteger = abs($integer)`: Stores the absolute value of the input integer, allowing the algorithm to work with both positive and negative numbers.\
  `sqrtInteger = sqrt($absInteger)`: Calculates the square root of the absolute integer. This is used for optimization, as explained below.

- Iteration and Divisor Search

  The for loop iterates from `i = 2` up to the `sqrtInteger`: Why iterate up to the square root? If a number `a` is a divisor of `n`, then `n / a` is also a divisor. Additionally, one of these divisors (`a` or `n / a`) will always be less than or equal to the square root of `n`.

- Divisibility Check

  `if ($absInteger % $i == 0)`: This checks if the current loop counter `i` divides the `absInteger` without a remainder. If so, we have found a divisor pair.
  `array_push($divisors, $i, -$i)`: Both `i` and its negative counterpart `-i` are added to the divisors array.

- Handling the Complementary Divisor

  `if ($i != $sqrtinteger)`: this condition prevents duplicate processing in cases where the integer is a perfect square root.
  `$compldivisor = $absinteger / $i`: calculates the larger complementary divisor by dividing the `absinteger` by `i`.
  `array_push($divisors, $compldivisor, -$compldivisor)`: both the complementary divisor and its negative counterpart are pushed into the divisors array.

### Calculating Factorials

To calculate the factorial of an integer, use the calcFactorial() method:

```php
use MathFunctions\IntegerCalculator;

$integerCalculator = new IntegerCalculator();
// Example usage with integer 5
$factorial = $integerCalculator->calcFactorial(5);
// Expected Output: 120
```

### Identifying Prime Numbers

To find prime numbers within an array of integers and receive the results in XML format, use the calcPrimeNumbers() method:

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

#### Mathematical Explanation (of the private method isPrime)

- Base Cases

  `if ($integer <= 1)`: Numbers less than or equal to 1 are not prime by definition.\
  `if ($integer <= 3)`: The numbers 2 and 3 are prime.

- Eliminating Multiples of 2 and 3:

  `if ($integer % 2 == 0 || $integer % 3 == 0)`: Any number divisible by 2 or 3 is not prime. This check quickly eliminates a large proportion of non-prime numbers.

- Optimized Testing

  `$sqrtInteger = sqrt($integer)`: Calculates the square root of the input integer. This is important because if a number has a divisor, one of the divisors must be less than or equal to its square root.

  `for ($i = 5; $i <= $sqrtInteger; $i += 6)`: This loop starts with `i = 5` since all primes greater than `3` are of the form `(6k ± 1)`, where `k` is any integer. It increments `i` by `6` in each iteration, effectively checking divisibility by `(6k - 1)` and `(6k + 1)` in a single pass.

- Divisibility Tests

  `if ($integer % $i == 0 || $integer % ($i + 2) == 0)`: The algorithm tests for divisibility by numbers of the form `(6k ± 1)`. If the integer is divisible by any of these, it is not a prime number.

### Formatting Calculation Results

You can format calculation results into an XML string using the ResultFormatter class:

```php
use MathFunctions\Utilities\ResultFormatter;

$resultFormatter = new ResultFormatter();
// Example usage with an array of even numbers
$xmlResult = $resultFormatter->toXML('evenNumbers', [2, 4, 6, 8]);
// Expected Output (XML string):
// <evenNnumbers amount="4">
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

## Requirements

- PHP 8.2 or higher
- Composer (for installation)

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, feel free to open an issue or submit a pull request.

## License

This package is licensed under the MIT License. See the [LICENSE](./LICENSE) file for details.
