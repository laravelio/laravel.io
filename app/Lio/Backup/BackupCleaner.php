<?php
namespace Lio\Backup;

use Illuminate\Support\Collection;
use League\Flysystem\FilesystemInterface;

class BackupCleaner
{
    /**
     * @var \League\Flysystem\FilesystemInterface
     */
    private $filesystem;

    /**
     * @param \League\Flysystem\FilesystemInterface $filesystem
     */
    public function __construct(FilesystemInterface $filesystem)
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
        $files = $this->findAllBackupFilesToDelete($keep);

        $this->deleteFiles($files);

        return $this->getFilenames($files);
    }

    /**
     * @param int $keep
     * @return \Illuminate\Support\Collection
     */
    private function findAllBackupFilesToDelete($keep = 5)
    {
        $files = $this->findAllBackupFiles();

        return $files->slice(0, -$keep);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function findAllBackupFiles()
    {
        $files = new Collection($this->filesystem->listFiles());
        $files = $this->filterOutGitignoreFile($files);
        $files = $this->sortFilesByCreationDate($files);

        return $files;
    }

    /**
     * @param \Illuminate\Support\Collection $files
     * @return \Illuminate\Support\Collection
     */
    private function filterOutGitignoreFile($files)
    {
        return $files->filter(function ($file) {
            return $file['path'] !== '.gitignore';
        });
    }

    /**
     * @param \Illuminate\Support\Collection $files
     * @return \Illuminate\Support\Collection
     */
    private function sortFilesByCreationDate($files)
    {
        return $files->sortBy(function ($file) {
            return $this->filesystem->getTimestamp($file['path']);
        });
    }

    /**
     * @param \Illuminate\Support\Collection $files
     */
    private function deleteFiles($files)
    {
        foreach ($files as $file) {
            $this->filesystem->delete($file['path']);
        }
    }

    /**
     * @param \Illuminate\Support\Collection $files
     * @return \Illuminate\Support\Collection
     */
    private function getFilenames($files)
    {
        return $files->lists('path');
    }
}
