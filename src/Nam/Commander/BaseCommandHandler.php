<?php


namespace Nam\Commander;

use Illuminate\Support\Facades\App;
use Nam\Commander\Events\Contracts\Dispatcher;
use Nam\Commander\Exceptions\InvalidCommandArgumentException;
use ReflectionClass;


/**
 * Class BaseCommandHandler
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Nam\Commander
 *
 */
abstract class BaseCommandHandler implements CommandHandler
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;
    /**
     * @var array
     */
    protected $pendingEvents = [ ];

    /**
     * Raise a new event
     *
     * @param $event
     */
    public function raiseEvent($event)
    {
        $this->pendingEvents[] = $event;
    }

    /**
     * Return and reset all pending events
     *
     * @return array
     */
    public function releaseEvents()
    {
        $events = $this->pendingEvents;

        $this->pendingEvents = [ ];

        return $events;
    }

    /**
     * @return Dispatcher
     */
    public function getDispatcher()
    {
        if ( ! $this->dispatcher instanceof Dispatcher) {
            /** @noinspection PhpUndefinedMethodInspection */
            $this->dispatcher = App::make('Nam\Commander\Events\EventDispatcher');
        }

        return $this->dispatcher;
    }

    /**
     * @param Dispatcher $dispatcher
     */
    public function setDispatcher(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param BaseCommand $command
     */
    protected function checkValidCommand(BaseCommand $command)
    {
        $commandsNamespace = $this->getCommandsNamespace();

        $commandShortName = $this->getCommandShortName();

        $commandName = "$commandsNamespace\\$commandShortName";

        if ( ! $command instanceof $commandName) {
            throw new InvalidCommandArgumentException($command);
        }
    }

    /**
     * @return ReflectionClass
     */
    protected function getContainsNamespace()
    {
        $reflection = new ReflectionClass($this);

        return $reflection->getNamespaceName();
    }

    /**
     * @return array
     */
    protected function getCommandsNamespace()
    {
        $reflection = new ReflectionClass($this);

        $ns = $reflection->getNamespaceName();
        $segments = explode('\\', $ns);
        array_pop($segments);
        $cmdNs = $segments;

        return implode('\\', $cmdNs);
    }

    /**
     * @return string
     */
    protected function getCommandShortName()
    {
        $handlerShortName = (new ReflectionClass($this))->getShortName();
        $commandShortName = substr($handlerShortName, 0, strlen($handlerShortName) - 7);

        return $commandShortName;
    }

}