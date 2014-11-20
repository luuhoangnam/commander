<?php


namespace Nam\Commander\Inflectors;

use Illuminate\Support\Str;
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
        $handler = $this->getComponent($command, 'Handler');

        if (! class_exists($handler)) {
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
        $validator = $this->getComponent($command, 'Validator');

        if (! class_exists($validator)) {
            return null;
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

    /**
     * @param $segments
     *
     * @return int
     */
    protected function guestRoot($segments)
    {
        $found = false;
        $rootIndex = '';
        for ($i = count($segments) - 1; $i >= 0; $i--) {
//            $check = implode('\\', array_chunk($segments, $i + 1)[0]);
            if ($found) {
                $rootIndex = $i;
                break;
            }

            if ($segments[$i] === 'Commands') {
                $found = true;
            }
        }

        return $rootIndex;
    }

    /**
     * @param BaseCommand $command
     * @param string      $component
     *
     * @return string
     */
    protected function getComponent(BaseCommand $command, $component = 'Handler')
    {
        $reflectionClass = (new ReflectionClass($command));
        $commandName = $reflectionClass->getName();
        $segments = explode('\\', $commandName);
        $commandShortName = array_pop($segments);
        $commandObjectName = substr($commandShortName, 0, count($commandShortName) - 8);

        $rootIndex = $this->guestRoot($segments);
        $rootSegments = [ ];

        for ($i = 0; $i <= $rootIndex; $i++) {
            $rootSegments[] = array_shift($segments);
        }

        array_shift($segments);

        $namespaceSegments = [ ];
        foreach ($rootSegments as $rootSegment) {
            $namespaceSegments[] = $rootSegment;
        }

        $namespaceSegments[] = Str::plural($component);

        foreach ($segments as $segment) {
            $namespaceSegments[] = $segment;
        }

        $handlerName = implode('\\', $namespaceSegments) . "\\{$commandObjectName}Command{$component}";

        return $handlerName;
    }
}
