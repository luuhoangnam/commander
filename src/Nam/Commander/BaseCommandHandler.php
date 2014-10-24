<?php


namespace Nam\Commander;

use App;
use Nam\Commander\Events\Contracts\Dispatcher;
use Nam\Commander\Exceptions\InvalidCommandArgumentException;


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
        $handlerClassName = get_class($this);
        $commandClassName = get_class($command);

        $handlerName = substr($handlerClassName, 0, strlen($handlerClassName) - 7);

        if ($handlerName !== $commandClassName) {
            throw new InvalidCommandArgumentException($command);
        }
    }
}