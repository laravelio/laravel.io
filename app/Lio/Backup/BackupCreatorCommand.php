<?php
namespace Lio\Backup;

use Illuminate\Console\Command;

class BackupCreatorCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'backup:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new database backup file.';

    /**
     * @var \Lio\Backup\BackupCreator
     */
    private $backup;

    /**
     * Create a new command instance.
     *
     * @param \Lio\Backup\BackupCreator $backup
     */
    public function __construct(BackupCreator $backup)
    {
        $this->backup = $backup;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $file = $this->backup->create();

        // Output a message to the user with the generated filename.
        $this->info("Backup file \"$file\" was created successfully.");
    }
}
