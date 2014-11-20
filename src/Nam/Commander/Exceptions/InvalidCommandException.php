<?php


namespace Nam\Commander\Exceptions;

use InvalidArgumentException;

/**
 * Class InvalidCommandException
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Core\Commands
 *
 */
class InvalidCommandException extends InvalidArgumentException
{
    /**
     * @var mixed
     */
    private $command;

    /**
     * @param mixed $command
     */
    public function __construct($command)
    {
        $this->command = $command;
    }
}
