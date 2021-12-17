# Calculator
Your task is to create a class that implements a simple calculator with fluent syntax.

    Calculator::init();

that has sets of properties and method of values and operations that can be accessed/called.

#### Rules:
*  Values are zero, one, two, three, four, five, six, seven, eight and nine.
*  Operations are plus, minus, times, dividedBy.
*  Accessing a property of value and/or operation should be stackable to infinity,
*  Accessing a value more than once will make the input value stacked (see example for more information),
*  Accessing an operation more than once will overwrite the previous operation (see example for more information),
*  Call to a value or operation should resolve to a primitive integer (round down to the nearest integer, if necessary) and returns the most recent calculation value.
*  Accessing a property or call to a method other than values and operations should throw InvalidInputException (you don't have to re-declare the exception class, it's been done for you).
*  class Calculator cannot have more than 3 (three) methods including init().
*  Maximum input and calculation value is 9 digit, if user try to input more than 9 digit or some calculation returns a value longer than 9 digit, throw a DigitCountOverflowException (you don't have to re-declare the exception class, it's been done for you).
*  If a number is divided by zero, throw a DivisionByZeroException (you don't have to re-declare the exception class, it's been done for you).
#### Examples:
    Calculator::init()->one();                  // should return 1
    Calculator::init()->one->zero();            // should return 10
    Calculator::init()->one->plus->two();       // should return 3 (1 + 2)
    Calculator::init()->one->two->three->four->five->six->seven->eight->nine->zero();
    // should throw DigitCountOverflowException since the input is more than 9 digit (1,234,567,890)
    Calculator::init()->nine->nine->nine->nine->nine->nine->nine->nine->nine->plus->one();
    // should throw DigitCountOverflowException since the calculation will result more than 9 digit (999,999,999 + 1 = 1,000,000,000)
    Calculator::init()->one->plus->minus->two();
    // returns -1 (operation "plus" is overwriten by "minus")
    Calculator::init()->one->add->two();
    // should throw InvalidInputException since there is no value/operation named "add"
    Calculator::init()->one->plus->two->dividedBy->three->times->one->zero->minus->three->plus->eight();
        /* should return 15
        * input: 1 + 2 / 3 * 10 - 3 + 8
        * calculation steps:
        * 1 + 2 = 3
        * 3 / 3 = 1
        * 1 * 10 = 10
        * 10 - 3 = 7
        * 7 + 8 = 15
        */

## Run unit tests:
>./vendor/bin/phpunit --bootstrap ./vendor/autoload.php ./tests/SuveryTest.php