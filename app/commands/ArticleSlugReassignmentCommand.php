<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ArticleSlugReassignmentCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'articles:reslug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all article slugs and re-assign. (don\'t in production)';

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
        DB::table('articles')->update(['slug' => '']);

        \Lio\Articles\Article::chunk(200, function($articles) {
            foreach ($articles as $article) {
                $article->title = $article->title;
                $article->save();
            }
        });
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
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
        );
    }

}
