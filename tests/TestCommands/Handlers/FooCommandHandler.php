<?php


namespace TestCommands\Handlers;

use Nam\Commander\BaseCommand;
use Nam\Commander\CommandHandler;
use Nam\Commander\InvalidCommandException;
use Nam\Commander\User;


/**
 * Class FooCommandHandler
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package TestCommands\Handlers
 *
 */
class FooCommandHandler implements CommandHandler {

    /**
     * @param BaseCommand $command
     *
     * @throws InvalidCommandException
     * @return User
     */
    public function handle(BaseCommand $command)
    {
        // TODO: Implement handle() method.
    }
}