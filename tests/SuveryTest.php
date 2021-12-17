<?php

namespace DONE\Tests\Survey2;

include(realpath("./src/Calculator.php"));

use DONE\Survey2\Exceptions\DigitCountOverflowException;
use DONE\Survey2\Exceptions\InvalidInputException;

use DONE\Survey2\Calculator;
use PHPUnit\Framework\TestCase;

class SuveryTest extends TestCase
{
    public function testBasicValueTests()
    {
        $this->assertSame(Calculator::init()->zero(), 0);
        $this->assertSame(Calculator::init()->one(), 1);
        $this->assertSame(Calculator::init()->two(), 2);
        $this->assertSame(Calculator::init()->three(), 3);
        $this->assertSame(Calculator::init()->four(), 4);
        $this->assertSame(Calculator::init()->five(), 5);
        $this->assertSame(Calculator::init()->six(), 6);
        $this->assertSame(Calculator::init()->seven(), 7);
        $this->assertSame(Calculator::init()->eight(), 8);
        $this->assertSame(Calculator::init()->nine(), 9);
        $this->assertSame(Calculator::init()->one->zero(), 10);
        $this->assertSame(Calculator::init()->minus->three->zero(), -30);
        $this->assertSame(Calculator::init()->nine->nine->nine->nine->nine->nine->nine->nine->nine(), 999999999);
    }
    public function testBasicOperationTests()
    {
        $this->assertSame(Calculator::init()->two->one->plus->three(), 24);
        $this->assertSame(Calculator::init()->one->minus->three(), -2);
        $this->assertSame(Calculator::init()->two->times->four->five(), 90);
        $this->assertSame(Calculator::init()->three->three->dividedBy->six(), 5);
        $this->assertSame(Calculator::init()->two->one->plus->three->times(), 24);
        $this->assertSame(Calculator::init()->one->minus->three->times(), -2);
        $this->assertSame(Calculator::init()->two->times->four->five->minus(), 90);
        $this->assertSame(Calculator::init()->three->three->dividedBy->six->dividedBy(), 5);
        $this->assertSame(Calculator::init()->two->one->plus->dividedBy->three(), 7);
        $this->assertSame(Calculator::init()->one->zero->times->minus->three->three(), -23);
        $this->assertSame(Calculator::init()->two->times->minus->four->five->seven(), -455);
    }
    public function testMoreThanOneOperations()
    {
        $this->assertSame(55, Calculator::init()->one->zero->plus->seven->plus->four->plus->one->plus->zero->plus->two->plus->nine->plus->five->plus->eight->plus->six->plus->three());
        $this->assertSame(-35, Calculator::init()->five->minus->one->minus->nine->minus->two->minus->eight->minus->seven->minus->three->minus->one->zero->minus->zero());
        $this->assertSame(362880, Calculator::init()->seven->times->three->times->two->times->nine->times->one->times->eight->times->four->times->six->times->five());
        $this->assertSame(0, Calculator::init()->one->zero->dividedBy->one->dividedBy->two->dividedBy->five->dividedBy->six->dividedBy->seven->dividedBy->four());
        $this->assertSame(4, Calculator::init()->zero->plus->three->plus->one());
        $this->assertSame(14, Calculator::init()->one->minus->one->zero->dividedBy->nine->plus->three->times->seven());
        $this->assertSame(15, Calculator::init()->one->plus->two->dividedBy->three->times->one->zero->minus->three->plus->eight());
        $this->assertSame(1, Calculator::init()->three->dividedBy->six->times->one->zero->plus->three->minus->seven());
    }
    public function testShouldThrowInvalidInputException1()
    {
        $this->expectException(InvalidInputException::class);
        Calculator::init()->limit();
    }
    public function testShouldThrowInvalidInputException2()
    {
        $this->expectException(InvalidInputException::class);
        Calculator::init()->power();
    }
    public function testShouldThrowInvalidInputException3()
    {
        $this->expectException(InvalidInputException::class);
        Calculator::init()->sin();
    }
    public function testShouldThrowInvalidInputException4()
    {
        $this->expectException(InvalidInputException::class);
        Calculator::init()->cos();
    }
    public function testShouldThrowDigitCountOverflowException1()
    {
        $this->expectException(DigitCountOverflowException::class);
        Calculator::init()->one->two->three->four->five->six->seven->eight->nine->zero();
    }
    public function testShouldThrowDigitCountOverflowException2()
    {
        $this->expectException(DigitCountOverflowException::class);
        Calculator::init()->one->two->three->four->five->six->seven->eight->nine->times->one->two();
    }
    public function testShouldThrowDigitCountOverflowException3()
    {
        $this->expectException(DigitCountOverflowException::class);
        Calculator::init()->nine->nine->nine->nine->nine->nine->nine->nine->nine->plus->one();
    }
    public function testShouldThrowDigitCountOverflowException4()
    {
        $this->expectException(DigitCountOverflowException::class);
        Calculator::init()->one->zero->zero->zero->zero->zero->times->one->zero->zero->zero->zero->zero();
    }
}
