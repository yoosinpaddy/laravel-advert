<?php
namespace Adumskis\LaravelAdvert;

use Illuminate\Support\ServiceProvider;

class AdvertServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('laravel-advert.php'),
            __DIR__.'/../migrations/2016_03_11_202301_create_advert_categories_table.php' => database_path('migrations/2016_03_11_202301_create_advert_categories_table.php'),
            __DIR__.'/../migrations/2016_03_11_202607_create_adverts_table.php' => database_path('migrations/2016_03_11_202607_create_adverts_table.php'),
            __DIR__.'/../view/advert.blade.php' => resource_path('views/partials/advert.blade.php')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/routes.php';
        $this->app->make('Adumskis\LaravelAdvert\AdvertManagerController');
        $this->app->singleton('advert_manager', function() {
            return new AdvertManager();
        });

        /*
         * Register the service provider for the dependency.
         */
        $this->app->register(\Rymanalu\LaravelSimpleUploader\UploaderServiceProvider::class);
        /*
         * Create aliases for the dependency.
         */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Uploader', 'Rymanalu\LaravelSimpleUploader\Support\Uploader');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['advert_manager'];
    }
}