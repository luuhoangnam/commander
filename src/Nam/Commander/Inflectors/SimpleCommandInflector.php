<?php


namespace Nam\Commander\Inflectors;

use Nam\Commander\BaseCommand;
use Nam\Commander\CommandHandler;
use Nam\Commander\Exceptions\HandlerNotRegisteredException;
use Nam\Commander\Exceptions\ValidatorNotRegisteredException;
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
        list( $commandName, $commandNamespace ) = $this->getCommandNamespace($command);

        $handler = $commandNamespace . "\\Handlers\\{$commandName}Handler"; // => \Mbibi\Core\Commands\Handlers\RegisterUserCommandHandler

        if ( ! class_exists($handler)) {
            $message = "Command handler [$handler] does not exist.";

            throw new HandlerNotRegisteredException($message);
        }

        return $handler;
    }

    /**
     * @param BaseCommand $command
     *
     * @throws ValidatorNotRegisteredException
     * @return mixed
     */
    public function getCommandValidator(BaseCommand $command)
    {
        list( $commandName, $commandNamespace ) = $this->getCommandNamespace($command);

        $validator = $commandNamespace . "\\Validators\\{$commandName}Validator"; // => \Mbibi\Core\Commands\Handlers\RegisterUserCommandHandler

        if ( ! class_exists($validator)) {
            $message = "Command validator [$validator] does not exist.";

            throw new ValidatorNotRegisteredException($message);
        }

        return $validator;
    }

    /**
     * @param BaseCommand $command
     *
     * @return array
     */
    protected function getCommandNamespace(BaseCommand $command)
    {
        $commandName = (new ReflectionClass($command))->getName();
        $parts = explode('\\', $commandName); // => \Mbibi\Core\Commands\RegisterUserCommand
        $command = array_pop($parts);
        $commandNamespace = implode('\\', $parts);

        return [ $command, $commandNamespace ];
    }
}