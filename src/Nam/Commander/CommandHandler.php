<?php

namespace Nam\Commander;

use Nam\Commander\Exceptions\InvalidCommandException;

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
