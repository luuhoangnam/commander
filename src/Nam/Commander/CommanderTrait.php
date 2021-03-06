<?php


namespace Nam\Commander;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;

/**
 * Trait CommanderTrait
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Nam\Commander
 *
 */
trait CommanderTrait
{
    /**
     * @param string $command
     * @param array  $input
     *
     * @return mixed
     */
    protected function executeCommand($command, array $input = null)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $input = $input ?: Input::all();

        $command = $this->mapInputToCommand($command, $input);
        $commandBus = $this->getCommandBus();

        return $commandBus->execute($command);
    }

    /**
     * @param string $command
     * @param array  $input
     *
     * @return BaseCommand
     */
    protected function mapInputToCommand($command, array $input)
    {
        $dependencies = [ ];

        $class = new ReflectionClass($command);

        $commandConstructor = $class->getConstructor();
        if ($commandConstructor) {
            $dependencies = $this->resolveDependencies($input, $commandConstructor, $dependencies);
        }

        return $class->newInstanceArgs($dependencies);
    }

    /**
     * @return CommandBus
     */
    protected function getCommandBus()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return App::make('Nam\Commander\CommandBus');
    }

    /**
     * @param array            $input
     * @param ReflectionMethod $commandConstructor
     * @param                  $dependencies
     *
     * @return array
     */
    protected function resolveDependencies(array $input, ReflectionMethod $commandConstructor, $dependencies)
    {
        foreach ($commandConstructor->getParameters() as $parameter) {
            $name = $parameter->getName();

            if (isset( $input[$name] )) {
                $dependencies[] = $input[$name];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                throw new InvalidArgumentException("Unable to map input to command: {$name}");
            }
        }

        return $dependencies;
    }
}
