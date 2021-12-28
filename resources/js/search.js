import algoliasearch from 'algoliasearch/lite';

const client = algoliasearch(process.env.MIX_ALGOLIA_APP_ID, process.env.MIX_ALGOLIA_SECRET);

window.searchConfig = () => {
    return {
        show: false,
        threads: {
            total: 0,
            formattedTotal: function () {
                return `${this.total} ${this.total === 1 ? 'Result' : 'Results'}`
            },
            threads: [],
        },
        articles: {
            total: 0,
            formattedTotal: function () {
                return `${this.total} ${this.total === 1 ? 'Result' : 'Results'}`
            },
            articles: [],
        },
        search: async function (query) {
            // If the input is empty, return no results.
            if (query.length === 0) {
                return Promise.resolve({ hits: [] });
            }

            // Perform the search using the provided input.
            const { results } = await client.multipleQueries([
                {
                    indexName: process.env.MIX_ALGOLIA_THREADS_INDEX,
                    query: query,
                    params: {
                        hitsPerPage: 5,
                        attributesToSnippet: ['body:10'],
                    },
                },
                {
                    indexName: process.env.MIX_ALGOLIA_ARTICLES_INDEX,
                    query: query,
                    params: {
                        hitsPerPage: 5,
                        attributesToSnippet: ['body:10'],
                    },
                },
            ]);

            this.show = true;
            this.threads.total = results[0].nbHits;
            this.threads.threads = results[0].hits;
            this.articles.total = results[1].nbHits;
            this.articles.articles = results[1].hits;
        }
    };
}
