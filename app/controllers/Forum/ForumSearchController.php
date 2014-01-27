<?php

class ForumSearchController extends BaseController
{
    protected $search;
    protected $threadsPerPage = 20;

    public function __construct(\Lio\Comments\ForumSearch $search)
    {
        $this->search = $search;
    }

    public function getSearch()
    {
        $query = Input::get('query');

        // perform search and add the search query to every pagination link
        $results = $this->search->searchPaginated($query, $this->threadsPerPage);
        $results->appends(array('query' => $query));

        // share the view data necessary for the sidenav, and render the search results
        $this->prepareViewData();
        $this->view('forum.search', compact('query', 'results'));
    }

    // ------------------------- //
    private function prepareViewData()
    {
        $forumSections = Config::get('forum.sections');
        $sectionCounts = $this->sections->getCounts(Session::get('forum_last_visited'));
        View::share(compact('forumSections', 'sectionCounts'));
        View::share('last_visited_timestamp', App::make('Lio\Forum\SectionCountManager')->updatedAndGetLastVisited(Input::get('tags')));
    }
}