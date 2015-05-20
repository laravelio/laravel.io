<?php
namespace Lio\Backup;

use Illuminate\Console\Command;
use Illuminate\Translation\Translator;
use Symfony\Component\Console\Input\InputArgument;

class BackupCleanCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'backup:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans the given amount of old backups';

    /**
     * @var \Lio\Backup\BackupCleaner
     */
    private $cleaner;

    /**
     * @var \Illuminate\Translation\Translator
     */
    private $translator;

    /**
     * Create a new command instance.
     *
     * @param \Lio\Backup\BackupCleaner $cleaner
     * @param \Illuminate\Translation\Translator $translator
     */
    public function __construct(BackupCleaner $cleaner, Translator $translator)
    {
        $this->cleaner = $cleaner;
        $this->translator = $translator;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $keep = (int) $this->argument('keep');
        $removedBackups = count($this->cleaner->removeOldBackups($keep));

        $this->info($this->translator->choice('backups.cleaned', $removedBackups, ['amount' => $removedBackups]));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['keep', InputArgument::REQUIRED, 'The given number of backups to keep', null],
        ];
    }
}
