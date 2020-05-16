import algoliasearch from 'algoliasearch/lite';

const client = algoliasearch(process.env.MIX_ALGOLIA_APP_ID, process.env.MIX_ALGOLIA_SECRET);

window.search = (event) => {
    // If the input is empty, return no results.
    if (event.target.value.length === 0) {
        return Promise.resolve({ hits: [] });
    }

    // Perform the search using the provided input.
    return client.multipleQueries([
        {
            indexName: process.env.MIX_ALGOLIA_THREADS_INDEX,
            query: event.target.value,
            params: {
                hitsPerPage: 5,
                attributesToSnippet: ['body:10'],
            },
        },
        {
            indexName: process.env.MIX_ALGOLIA_ARTICLES_INDEX,
            query: event.target.value,
            params: {
                hitsPerPage: 5,
                attributesToSnippet: ['body:10'],
            },
        },
    ]);
};
