<?php

namespace Viviniko\Content;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Viviniko\Content\Console\Commands\ContentTableCommand;

class ContentServiceProvider extends BaseServiceProvider
{
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

        $config = $this->app['config'];

        Relation::morphMap([
            'content.category' => $config->get('content.category'),
            'content.item' => $config->get('catalog.item'),
        ]);
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

        $this->registerService();

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
            \Viviniko\Content\Repositories\Model\ModelRepository::class,
            \Viviniko\Content\Repositories\Model\EloquentModel::class
        );

        $this->app->singleton(
            \Viviniko\Content\Repositories\Field\FieldRepository::class,
            \Viviniko\Content\Repositories\Field\EloquentField::class
        );

        $this->app->singleton(
            \Viviniko\Content\Repositories\Category\CategoryRepository::class,
            \Viviniko\Content\Repositories\Category\EloquentCategory::class
        );

        $this->app->singleton(
            \Viviniko\Content\Repositories\Item\ItemRepository::class,
            \Viviniko\Content\Repositories\Item\EloquentItem::class
        );
    }

    private function registerService()
    {
        $this->app->singleton('content', \Viviniko\Content\Factory::class);

        $this->app->alias('content', \Viviniko\Content\Contracts\Factory::class);
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
        ];
    }
}