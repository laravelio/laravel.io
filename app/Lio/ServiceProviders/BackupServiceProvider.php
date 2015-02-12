<?php namespace Lio\ServiceProviders;

use Aws\S3\S3Client;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Adapter\AwsS3;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Lio\Backup\BackupCreator;
use Lio\Backup\BackupCleaner;

class BackupServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider
     *
     * @return void
     */
    public function register()
    {
        $this->registerBackupCreator();
        $this->registerBackupCleaner();

        $this->commands([
            'Lio\\Backup\\BackupCleanCommand',
            'Lio\\Backup\\BackupCreateCommand'
        ]);
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
     * Register the backup creator
     */
    protected function registerBackupCleaner()
    {
        $this->app->bindShared('backup.cleaner', function($app) {
            $storage = $app['config']['backup-manager::storage'];
            $destination = $app['config']->get('backup.destination');

            if ($destination === 's3') {
                $config = $storage['local']['s3'];

                $client = S3Client::factory([
                    'key'    => $config['key'],
                    'secret' => $config['secret'],
                    'region' => $config['region'],
                ]);
                $adapter = new AwsS3($client, $config['bucket']);
            } else {
                $adapter = new Local($storage['local']['root']);
            }

            return new BackupCleaner(new Filesystem($adapter));
        });

        $this->app->alias('backup.cleaner', 'Lio\Backup\BackupCleaner');
    }

    /**
     * Get the services provided by the provider
     *
     * @return array
     */
    public function provides()
    {
        return ['backup.creator', 'backup.cleaner'];
    }
}