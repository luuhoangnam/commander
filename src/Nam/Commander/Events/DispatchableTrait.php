<?php

namespace Nam\Commander\Events;

use Illuminate\Events\Dispatcher;

/**
 * Class DispatchableTrait
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Nam\Commander\Events
 *
 */
trait DispatchableTrait
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * @return Dispatcher
     */
    public function getDispatcher()
    {
        if (! $this->dispatcher instanceof Dispatcher) {
            $this->dispatcher = \App::make('Nam\Commander\Events\EventDispatcher');
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

    public function dispatch()
    {
        $this->getDispatcher()->dispatch($this->releaseEvents());
    }
}
