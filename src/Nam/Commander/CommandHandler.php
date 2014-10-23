<?php

namespace Nam\Commander;


/**
 * Class RegisterUserCommandHandler
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Core\Commands
 *
 */
interface CommandHandler
{
    /**
     * @param BaseCommand $command
     *
     * @throws InvalidCommandException
     * @return mixed
     */
    public function handle(BaseCommand $command);
}