<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ContextServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{

	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind('taxService', function()
        {
            return new \CodeTrim\Services\TaxService();
        });


        $this->app->singleton('context', function()
        {
            return new \CodeTrim\Models\Context(null,null,null);
        });
   	}

}
