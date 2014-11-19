<?php

namespace Nam\Commander;

use Illuminate\Foundation\Application;
use Nam\Commander\Exceptions\CommandValidationException;
use Nam\Commander\Inflectors\CommandInflector;


/**
 * Class SimpleCommandBus
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Core\Commands
 *
 */
class DefaultCommandBus implements CommandBus
{

    /**
     * @var Application
     */
    private $app;
    /**
     * @var CommandInflector
     */
    private $commandInflector;

    /**
     * @param Application      $app
     * @param CommandInflector $inflector
     */
    public function __construct(Application $app, CommandInflector $inflector)
    {
        $this->app = $app;
        $this->commandInflector = $inflector;
    }

    /**
     * Execute a command
     *
     * @param $command
     *
     * @return mixed
     */
    public function execute($command)
    {
        $validator = $this->commandInflector->getCommandValidator($command);
        if ($validator) {
            $this->app->make($validator)->validate($command);
        }

        $handler = $this->commandInflector->getCommandHandler($command);

        return $this->app->make($handler)->handle($command);
    }
}