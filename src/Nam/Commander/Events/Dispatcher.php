<?php

namespace Nam\Commander\Events;


/**
 * Class EventDispatcher
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Core\Commands\Events
 *
 */
interface Dispatcher
{
    /**
     * Dispatch all raised events.
     *
     * @param array $events
     *
     * @return mixed
     */
    public function dispatch(array $events);
}
