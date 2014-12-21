<?php
namespace Lio\Backup;

use BigName\BackupManager\Manager;

class BackupCreator
{
    /**
     * @var \BigName\BackupManager\Manager
     */
    private $manager;

    /**
     * @var string
     */
    private $database;

    /**
     * @var string
     */
    private $destination;

    /**
     * @param \BigName\BackupManager\Manager $manager
     * @param string $connection
     * @param string $destination
     */
    public function __construct(Manager $manager, $connection, $destination)
    {
        $this->manager = $manager;
        $this->database = $connection;
        $this->destination = $destination;
    }

    /**
     * Creates a new database backup
     *
     * @param string $file Optional filename for the backup file
     * @return string
     */
    public function create($file = null)
    {
        $file = $file ?: date('Y-m-d-H-i-s') . '_backup.sql';

        $this->manager->makeBackup()->run($this->database, $this->destination, $file, 'gzip');

        return $file . '.gz';
    }
}
