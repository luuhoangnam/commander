<?php

use Nam\Commander\Events\EventDispatcher;
use TestCommands\Events\BarEvent;
use TestCommands\Events\FooEvent;

/**
 * EventDispatcherTest Test Case
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 *
 */
class EventDispatcherTest extends PHPUnit_Framework_TestCase
{
    public function test_it_can_dispatch_events()
    {
        // prepare
        $laravelDispatcher = Mockery::mock('Illuminate\Events\Dispatcher');
        $fireMethod = $laravelDispatcher->shouldReceive('fire')->twice();

        $logWriter = Mockery::mock('Illuminate\Log\Writer');
        $infoMethod = $logWriter->shouldReceive('info')->twice();

        $eventDispatcher = new EventDispatcher($laravelDispatcher, $logWriter);

        $events = [
            new FooEvent,
            new BarEvent,
        ];

        // act
        $eventDispatcher->dispatch($events);

        // assert
        $fireMethod->verify();
        $infoMethod->verify();
    }
}
