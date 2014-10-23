<?php

use Nam\Commander\SimpleCommandInflector;


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
        $handler = $inflector->getCommandHandler($command);

        // assert
        $this->assertEquals('\Handlers\FooCommandHandler', $handler);
    }
}

/**
 * Class FooCommand
 */
/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
/** @noinspection PhpUndefinedClassInspection */
class FooCommand extends Nam\Commander\BaseCommand
{

}
