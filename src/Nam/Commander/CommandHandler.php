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
     * @param $command
     *
     * @return mixed
     */
    public function handle($command);
}
