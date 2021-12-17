<?php

namespace DONE\Survey2;

include(realpath("./Exceptions/InvalidInputException.php"));
include(realpath("./Exceptions/DigitCountOverflowException.php"));

use DONE\Survey2\Exceptions\DigitCountOverflowException;
use DONE\Survey2\Exceptions\InvalidInputException;


trait Singletonizer
{
    /**
     * is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from WhateverClass::ConstructorMethod() instead
     */
    private function __construct()
    {
    }

    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone()
    {
    }

    /**
     * prevent from being unserialized (which would create a second instance of it)
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
}

/*
 *  Class for emulating basic calculator the way that math would take a piss on it :)
 *  but the focus on this task was what is extremly not usual !!!, as first I started 
 *  coding a real basic calculator...stay focus was the goal of this issue :) 
 *
 */
final class Calculator
{

    private const values = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];

    private const operations = ['plus', 'minus', 'times', 'dividedBy'];

    private $valueStack = 0;

    private $operation =  'plus';
    private $operationOverride = false;
    private $value = '';

    use Singletonizer;

    /*
     * Instance of Calcuator
     * 
     */
    private static $instance = null;

    /*
     * The Singleton creator method of Calculator
     *
     * @return Calculator
     */
    public static function init() : Calculator
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        self::$instance->valueStack = 0;
        self::$instance->operation =  'plus';
        self::$instance->operationOverride = false;
        self::$instance->valueString = '';

        return self::$instance;        
    }

    // you can define 2 (two) more methods

    /*
     * Method for getters
     *
     * @return Calculator
     */
    public function __get(string $name) : Calculator
    {
        if (!in_array($name, self::values) && !in_array($name, self::operations))
        {
            throw new InvalidInputException;
        }
        else {
            $valueKey = array_search($name, self::values);
            if ($valueKey === false)
            {
                if (!self::$instance->operationOverride)
                {
                    switch (self::$instance->operation)
                    {
                        case 'plus':
                            self::$instance->valueStack = self::$instance->valueStack 
                            + 
                            ((int) self::$instance->valueString);
                            break;
                        case 'minus':
                            self::$instance->valueStack = self::$instance->valueStack 
                            - 
                            ((int) self::$instance->valueString);
                            break;
                        case 'times':
                            self::$instance->valueStack = self::$instance->valueStack 
                            * 
                            ((int) self::$instance->valueString);
                            break;
                        case 'dividedBy':
                            if (((int) self::$instance->valueString) === 0)
                                throw new DivisionByZeroException();
                            self::$instance->valueStack = self::$instance->valueStack
                            / 
                            ((int) self::$instance->valueString);
                            break;
                    }
                }
                if (strlen(intval(self::$instance->valueStack). '') > 9) {
                    throw new DigitCountOverflowException;
                }
                self::$instance->operation = $name;
                self::$instance->operationOverride = true;
                self::$instance->valueString = '';
            }
            else {
                self::$instance->operationOverride = false;
                if (strlen(self::$instance->valueString) > 9)
                    throw new DigitCountOverflowException;
                self::$instance->valueString .= $valueKey;
            }
        }
        return self::$instance;
    }

    /*
     * If we call the Singleton's property Method, that should return the 
     * calculated value
     *
     * @return int
     */
    public function __call(string $name, array $arguments) : int
    {
        $operation = self::$instance->operation;
        return (int) (in_array($name, self::operations) ? self::$instance->$operation->valueStack : self::$instance->$name->$operation->valueStack);
    }
}
