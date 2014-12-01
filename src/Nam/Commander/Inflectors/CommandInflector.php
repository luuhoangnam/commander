<?php

namespace Nam\Commander\Inflectors;

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
     * @param $command
     *
     * @return string
     *
     */
    public function getCommandHandler($command);

    /**
     * @param $command
     *
     * @return mixed
     */
    public function getCommandValidator($command);
}
