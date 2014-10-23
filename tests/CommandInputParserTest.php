<?php

use Nam\Commander\Console\CommandInputParser;


/**
 * CommandInputParserTest Test Case
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 *
 */
class CommandInputParserTest extends PHPUnit_Framework_TestCase
{
    public function test_parse()
    {
        // prepare
        $parser = new CommandInputParser;

        // act
        $input = $parser->parse('Foo/Bar/Baz', 'one, two, three');

        // assert
        $this->assertInstanceOf('Nam\Commander\Console\CommandInput', $input);
        $this->assertEquals('Baz', $input->name);
        $this->assertEquals('Foo\Bar', $input->namespace);
        $this->assertEquals([ 'one', 'two', 'three' ], $input->properties);
    }
}
