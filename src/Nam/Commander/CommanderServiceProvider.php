<?php namespace Nam\Commander;

use Illuminate\Support\ServiceProvider;

/**
 * Class CommanderServiceProvider
 * @package Nam\Commander
 */
class CommanderServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     *
     */
    public function boot()
    {
        $this->package('nam/commander');

        $this->bootArtisanCommand();

        $this->bootEventListeners();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->bindInflectors();

        $this->bindCommandBus();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ ];
    }

    /**
     *
     */
    private function bindInflectors()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $this->app->bind(
            'Nam\Commander\Inflectors\CommandInflector',
            'Nam\Commander\Inflectors\SimpleCommandInflector'
        );
    }

    /**
     *
     */
    private function bindCommandBus()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $this->app->bindShared('Nam\Commander\CommandBus', function ($app) {
            /** @noinspection PhpUndefinedMethodInspection */
            return $app->make('Nam\Commander\DefaultCommandBus');
        });
    }

    /**
     *
     */
    protected function bootArtisanCommand()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $this->app->bindShared('commander.command.make', function ($app) {
            /** @noinspection PhpUndefinedMethodInspection */
            return $app->make('Nam\Commander\Console\CommanderMakeCommand');
        });

        $this->commands('commander.command.make');
    }

    /**
     *
     */
    protected function bootEventListeners()
    {
        $listeners = $this->app['config']['commander::event.listeners'];

        foreach ($listeners as $listener) {
            /** @noinspection PhpUndefinedMethodInspection */
            $this->app['events']->listen('Mbibi.Core.Commands.Events.*', $listener);
        }
    }

}
