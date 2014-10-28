<?php


namespace TestCommands\Validators;

use Nam\Commander\BaseCommand;
use Nam\Commander\CommandValidator;


/**
 * Class FooCommandValidator
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package TestCommands\Validators
 *
 */
class FooCommandValidator implements CommandValidator
{
    /**
     * @param BaseCommand $command
     *
     * @return mixed|void
     */
    public function validate(BaseCommand $command)
    {
        // No-op
    }
}