<?php namespace Nam\Commander;

use Illuminate\Support\ServiceProvider;

class CommanderServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        $this->package('nam/commander');
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

	private function bindInflectors()
	{
		$this->app->bind(
			'Nam\Commander\Inflectors\CommandInflector',
			'Nam\Commander\Inflectors\SimpleCommandInflector'
		);
	}

	private function bindCommandBus()
	{
		$this->app->bindShared('Nam\Commander\CommandBus', function ($app) {
			return $app->make('Nam\Commander\DefaultCommandBus');
		});
	}

}
