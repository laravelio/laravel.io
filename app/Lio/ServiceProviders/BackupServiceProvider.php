<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Lio\Backup\BackupCreator;
use Lio\Backup\BackupCreatorCommand;

class BackupServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events
     *
     * @return void
     */
    public function boot()
    {
        $this->commands('command.backup.creator');
    }

    /**
     * Register the service provider
     *
     * @return void
     */
    public function register()
    {
        $this->registerBackupCreator();
        $this->registerBackupCreatorCommand();
    }

    /**
     * Register the backup creator
     */
    protected function registerBackupCreator()
    {
        $this->app->bindShared('backup.creator', function($app) {
            $config = $app['config'];
            $database = $config->get('database.default');
            $destination = $config->get('backup.destination');

            return new BackupCreator($app['BigName\BackupManager\Manager'], $database, $destination);
        });

        $this->app->alias('backup.creator', 'Lio\Backup\BackupCreator');
    }

    /**
     * Register the backup creator command
     */
    protected function registerBackupCreatorCommand()
    {
        $this->app->bindShared('command.backup.creator', function($app) {
            return new BackupCreatorCommand($app['backup.creator']);
        });
    }

    /**
     * Get the services provided by the provider
     *
     * @return array
     */
    public function provides()
    {
        return ['backup.creator', 'command.backup.creator'];
    }
}