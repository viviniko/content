<?php

namespace Viviniko\Content;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Viviniko\Content\Console\Commands\ContentTableCommand;
use Viviniko\Content\Models\Category;

class ContentServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__.'/../config/content.php' => config_path('content.php'),
        ]);

        // Register commands
        $this->commands('command.content.table');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/content.php', 'content');

        $this->registerRepositories();

        $this->registerContentService();

        $this->registerCommands();
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->app->singleton('command.content.table', function ($app) {
            return new ContentTableCommand($app['files'], $app['composer']);
        });
    }

    protected function registerRepositories()
    {
        $this->app->singleton(
            \Viviniko\Content\Repositories\Category\CategoryRepository::class,
            \Viviniko\Content\Repositories\Category\EloquentCategory::class
        );

        $this->app->singleton(
            \Viviniko\Content\Repositories\Page\PageRepository::class,
            \Viviniko\Content\Repositories\Page\EloquentPage::class
        );
    }

    protected function registerContentService()
    {
        $this->app->singleton('content', \Viviniko\Content\Services\ContentServiceImpl::class);
        $this->app->alias('content', \Viviniko\Content\Contracts\ContentService::class);
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'content',
            \Viviniko\Content\Contracts\ContentService::class
        ];
    }
}