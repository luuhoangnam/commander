<?php


namespace Nam\Commander;

use Nam\Commander\Exceptions\HandlerNotRegisteredException;
use ReflectionClass;

/**
 * Class SimpleCommandInflector
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Core\Commands
 *
 */
class SimpleCommandInflector implements CommandInflector
{

    /**
     * @param BaseCommand $command
     *
     * @throws HandlerNotRegisteredException
     * @return CommandHandler
     */
    public function getCommandHandler(BaseCommand $command)
    {
        $commandName = (new ReflectionClass($command))->getName();
        $parts = explode('\\', $commandName); // => \Mbibi\Core\Commands\RegisterUserCommand
        $command = array_pop($parts);
        $handler = implode('\\', $parts) . "\\Handlers\\{$command}Handler"; // => \Mbibi\Core\Commands\Handlers\RegisterUserCommandHandler

        if ( ! class_exists($handler)) {
            $message = "Command handler [$handler] does not exist.";

            throw new HandlerNotRegisteredException($message);
        }

        return $handler;
    }
}