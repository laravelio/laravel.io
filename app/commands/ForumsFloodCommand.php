<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ForumsFloodCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'forums:flood';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate threads and comments to stress test the forum.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$count = (int) $this->argument('itemCount');

		if ($count <= 0) {
			$argString = $this->argument('itemCount');

			$this->error("The item count argument must be a valid integer. Received, \"{$argString}\".");
			exit;
		}

		// set up generator
		$generator = new \Lio\Forum\ForumDataGenerator(
			App::make('faker'),
			App::make('Lio\Forum\ForumCategoryRepository'),
			App::make('Lio\Comments\CommentRepository'),
			App::make('Lio\Accounts\UserRepository'));

		// yup
		set_time_limit(0);
		ini_set('memory_limit','512M');

		try {
			$generator->generate($count);
		} catch (Exception $e) {
			$this->error('Fatal Exception: ' . $e->getMessage());
			exit;
		}
		
		echo "\n";
		$this->info('Generation Complete');
		$this->info("{$count} threads successfully added.");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('itemCount', InputArgument::REQUIRED, 'How many threads to create.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}