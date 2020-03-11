import algoliasearch from 'algoliasearch/lite';

const client = algoliasearch(process.env.MIX_ALGOLIA_APP_ID, process.env.MIX_ALGOLIA_SECRET)
const index = client.initIndex(process.env.MIX_ALGOLIA_INDEX)

window.search = (event) => {
    // If the input is empty, return no results.
    if (event.target.value.length === 0) {
        return Promise.resolve({ hits: [] })
    }

    // Perform the search using the provided input.
    return index.search(event.target.value, {
        hitsPerPage: 5,
        attributesToSnippet: [
            'body:10'
        ]
    });
}
