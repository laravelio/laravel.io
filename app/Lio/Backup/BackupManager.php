<?php
namespace Lio\Backup;

use Illuminate\Support\Collection;
use League\Flysystem\Filesystem;

class BackupManager
{
    /**
     * @var \League\Flysystem\Filesystem
     */
    private $filesystem;

    /**
     * @param \League\Flysystem\Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Remove old backups based on their timestamps
     *
     * @param int $keep The amount of backup files to keep
     * @return array
     */
    public function removeOldBackups($keep = 5)
    {
        // Get all the files from the backup folder
        $files = new Collection($this->filesystem->listFiles());

        // Sort the backup files by their creation date.
        $files->sortBy(function ($file) {
            return $this->filesystem->getTimestamp($file);
        });

        // Slice the old backup files off from the amount to keep.
        $filesToDelete = $files->slice($keep);

        // Delete all the old backup files.
        foreach ($filesToDelete as $file) {
            $this->filesystem->delete($file);
        }

        // Return the files which were deleted.
        return $filesToDelete->toArray();
    }
}
