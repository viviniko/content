<?php

namespace Viviniko\Content\Console\Commands;

use Viviniko\Support\Console\CreateMigrationCommand;

class ContentTableCommand extends CreateMigrationCommand
{
    /**
     * @var string
     */
    protected $name = 'content:table';

    /**
     * @var string
     */
    protected $description = 'Create a migration for the content service table';

    /**
     * @var string
     */
    protected $stub = __DIR__.'/stubs/content.stub';

    /**
     * @var string
     */
    protected $migration = 'create_content_table';
}
