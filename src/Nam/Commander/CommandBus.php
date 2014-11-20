<?php


namespace Nam\Commander;


/**
 * Class SimpleCommandBus
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Core\Commands
 *
 */
interface CommandBus
{
    /**
     * Execute a command
     *
     * @param $command
     *
     * @return mixed
     */
    public function execute($command);
}
