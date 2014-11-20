<?php


namespace Nam\Commander\Exceptions;

use InvalidArgumentException;
use Nam\Commander\BaseCommand;

/**
 * Class InvalidCommandArgumentException
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Nam\Commander\Exceptions
 *
 */
class InvalidCommandArgumentException extends InvalidArgumentException
{

    /**
     * @var BaseCommand concrete command
     */
    private $command;

    /**
     * @param BaseCommand $command
     */
    public function __construct(BaseCommand $command)
    {
        $this->command = $command;
    }

    /**
     * @return BaseCommand
     */
    public function getCommand()
    {
        return $this->command;
    }
}
