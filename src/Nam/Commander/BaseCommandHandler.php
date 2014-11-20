<?php


namespace Nam\Commander;

use Illuminate\Config\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use Mbibi\Exceptions\CannotRollbackAttachModelOperationException;
use Mbibi\Models\User;
use Nam\Commander\Events\Contracts\Dispatcher;

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
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

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
        if (! $this->dispatcher instanceof Dispatcher) {
            $this->dispatcher = $this->app->make('Nam\Commander\Events\EventDispatcher');
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
     * @param string $repo
     *
     * @return mixed
     */
    protected function getRepository($repo)
    {
        $className = ucfirst(Str::camel($repo));

        return $this->app->make("Mbibi\\Contracts\\Repository\\{$className}");
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    protected function config($key, $default = null)
    {
        /** @var Repository $config */
        $config = $this->app->make('config');

        return $config->get($key, $default);
    }

    /**
     * @return User
     */
    protected function getCurrentUser()
    {
        return $this->getRepository('user')->getCurrentUserOrFail();
    }

    /**
     * @param Model $model
     *
     * @return bool
     */
    protected function rollbackModel(Model $model)
    {
        if (! $model->delete()) {
            throw new CannotRollbackAttachModelOperationException($model);
        }

        return true;
    }
}
