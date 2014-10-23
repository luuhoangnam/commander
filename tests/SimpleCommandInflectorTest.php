<?php

use TestCommands\BarCommand;
use TestCommands\FooCommand;
use Nam\Commander\Inflectors\SimpleCommandInflector;


/**
 * SimpleCommandInflectorTest Test Case
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 *
 */

/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
class SimpleCommandInflectorTest extends PHPUnit_Framework_TestCase
{
    public function test_get_command_handler_class()
    {
        // prepare
        $command = new FooCommand;
        $inflector = new SimpleCommandInflector;

        // act
        $result = $inflector->getCommandHandler($command);

        // assert
        $this->assertEquals("TestCommands\\Handlers\\FooCommandHandler", $result);
    }

    /**
     * @expectedException \Nam\Commander\Exceptions\HandlerNotRegisteredException
     */
    public function test_it_should_throw_exception_when_handler_class_does_not_exist()
    {
        // prepare
        $command = new BarCommand;
        $inflector = new SimpleCommandInflector;

        // act
        $inflector->getCommandHandler($command);

        // assert

    }
}