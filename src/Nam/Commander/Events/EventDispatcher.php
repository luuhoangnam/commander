<?php


namespace Nam\Commander\Events;

use Nam\Commander\Events\Contracts\Dispatcher as DispatcherInterface;
use Illuminate\Events\Dispatcher;
use Illuminate\Log\Writer;

/**
 * Class EventDispatcher
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Core\Commands\Events
 *
 */
class EventDispatcher implements DispatcherInterface
{

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var Writer
     */
    private $log;

    /**
     * Create a new EventDispatcher instance.
     *
     * @param Dispatcher $dispatcher
     * @param Writer     $log
     */
    public function __construct(Dispatcher $dispatcher, Writer $log)
    {
        $this->dispatcher = $dispatcher;
        $this->log = $log;
    }

    /**
     * Dispatch all raised events.
     *
     * @param array $events
     *
     * @return void
     */
    public function dispatch(array $events)
    {
        foreach ($events as $event) {
            $eventName = $this->getEventName($event);

            $this->dispatcher->fire($eventName, $event);

            /** @noinspection PhpUndefinedMethodInspection */
            $this->log->info("{$eventName} was fired.");
        }
    }

    /**
     * Make the fired event name look more object-oriented.
     *
     * @param $event
     *
     * @return string
     */
    protected function getEventName($event)
    {
        return str_replace('\\', '.', get_class($event));
    }
}