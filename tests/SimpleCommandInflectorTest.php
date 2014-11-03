<?php

use Nam\Commander\BaseCommand;
use Nam\Commander\Inflectors\CommandInflector;
use Nam\Commander\Inflectors\SimpleCommandInflector;
use TestCommands\Commands\Abz\BarCommand;
use TestCommands\Commands\Abz\FooCommand;


/**
 * SimpleCommandInflectorTest Test Case
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 *
 */

/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
class SimpleCommandInflectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var BaseCommand
     */
    private $command;
    /**
     * @var CommandInflector
     */
    private $inflector;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     */
    protected function setUp()
    {
        $this->command = new FooCommand;
        $this->inflector = new SimpleCommandInflector;;
    }

    public function test_get_command_handler_class()
    {
        // act
        $result = $this->inflector->getCommandHandler($this->command);

        // assert
        $this->assertEquals("TestCommands\\Handlers\\Abz\\FooCommandHandler", $result);
    }

    public function test_get_command_validator_class()
    {
        // act
        $result = $this->inflector->getCommandValidator($this->command);

        // assert
        $this->assertEquals("TestCommands\\Validators\\Abz\\FooCommandValidator", $result);
    }

    /**
     * @expectedException \Nam\Commander\Exceptions\HandlerNotRegisteredException
     */
    public function test_it_should_throw_exception_when_handler_class_does_not_exist()
    {
        // prepare
        $this->command = new BarCommand;

        // act
        $this->inflector->getCommandHandler($this->command);
    }

    /**
     * @expectedException \Nam\Commander\Exceptions\ValidatorNotRegisteredException
     */
    public function test_it_should_throw_exception_when_validator_class_does_not_exist()
    {
        // prepare
        $this->command = new BarCommand;

        // act
        $this->inflector->getCommandValidator($this->command);
    }
}