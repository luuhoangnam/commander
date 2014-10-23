<?php

use Nam\Commander\Events\EventListener;
use TestCommands\Events\BarEvent;
use TestCommands\Events\BazEvent;

/**
 * EventListenerTest Test Case
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 *
 */
class EventListenerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var EventListener
     */
    private $listener;

    protected function setUp()
    {
        $this->listener = new FooListener;
    }

    public function test_handle_event_by_existing_handler_method()
    {
        // prepare
        $event = new BarEvent;

        // act
        $result = $this->listener->handle($event);

        // assert
        $this->assertEquals('baz', $result);
    }

    public function test_handle_event_with_non_existed_handler_method()
    {
        // prepare
        $event = new BazEvent;

        // act
        $result = $this->listener->handle($event);

        // assert
        $this->assertNull($result);
    }
}

class FooListener extends EventListener
{
    public function whenBarEvent($event)
    {
        return 'baz';
    }
}

