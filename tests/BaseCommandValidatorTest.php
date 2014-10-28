<?php


/**
 * BaseCommandValidatorTest Test Case
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 *
 */

/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
class BaseCommandValidatorTest extends PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        Mockery::close();
    }

    public function test_add_rule()
    {
        // prepare
        $factory = Mockery::mock('Illuminate\Validation\Factory');
        $validator = new BarValidator($factory);

        // act
        $validator->addRule('foo', 'email');
        $validator->addRule('foo', 'between:8,32');

        // assert
        $rules = $validator->getRules();
        $this->assertEquals([ 'foo' => 'required|email|between:8,32' ], $rules);
    }
}

/**
 * Class BarValidator
 */

/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
class BarValidator extends \Nam\Commander\BaseCommandValidator
{
    protected $rules = [
        'foo' => 'required',
    ];

    /**
     * @param \Nam\Commander\BaseCommand $command
     *
     * @return mixed
     */
    public function validate(\Nam\Commander\BaseCommand $command)
    {
        // TODO: Implement validate() method.
    }
}