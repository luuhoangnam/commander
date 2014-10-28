<?php

use Nam\Commander\Console\CommandGenerator;
use Nam\Commander\Console\CommandInput;


/**
 * CommandGeneratorTest Test Case
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 *
 */

/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
class CommandGeneratorTest extends PHPUnit_Framework_TestCase
{
    public function test_make()
    {
        // prepare
        $input = new FooCommandInput('foo', 'bar', 'baz');
        $template = 'foo';
        $destination = 'bar';
        $stub = 'baz';

        $fs = Mockery::mock('Illuminate\Filesystem\Filesystem');
        $getMethod = $fs->shouldReceive('get')->once()->with($template);
        $putMethod = $fs->shouldReceive('put')->once()->with($destination, $stub);

        $mustache = Mockery::mock('Mustache_Engine');
        $renderMethod = $mustache->shouldReceive('render')->once()->andReturn($stub);

        $generator = new CommandGenerator($fs, $mustache);

        // act
        $generator->make($input, $template, $destination);

        // assert
        $getMethod->verify();
        $putMethod->verify();
        $renderMethod->verify();
    }
}

/**
 * Class FooCommandInput
 */

/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
class FooCommandInput extends CommandInput
{

}
