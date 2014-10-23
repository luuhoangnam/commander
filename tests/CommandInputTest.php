<?php

use Nam\Commander\Console\CommandInput;


/**
 * CommandInputTest Test Case
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 *
 */
class CommandInputTest extends PHPUnit_Framework_TestCase
{
    public function test_get_arguments()
    {
        // prepare
        $properties = [ 'one', 'two', 'three' ];
        $input = new CommandInput('foo', 'bar', $properties);

        // act
        $args = $input->arguments();

        // assert
        $this->assertEquals('foo', $input->name);
        $this->assertEquals('bar', $input->namespace);
        $this->assertEquals($properties, $input->properties);
        $this->assertEquals('$one, $two, $three', $args);
    }
}
