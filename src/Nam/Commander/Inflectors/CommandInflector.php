<?php


namespace Nam\Commander\Inflectors;

use Nam\Commander\BaseCommand;

/**
 * Interface CommandInflector
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Core\Commands
 *
 */
interface CommandInflector
{
    /**
     * @param BaseCommand $command
     *
     * @return string
     *
     */
    public function getCommandHandler(BaseCommand $command);
}