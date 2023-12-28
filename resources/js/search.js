import algoliasearch from 'algoliasearch/lite';

const client = algoliasearch(import.meta.env.VITE_ALGOLIA_APP_ID, import.meta.env.VITE_ALGOLIA_SECRET);

window.searchConfig = () => {
    return {
        threads: {
            total: 0,
            formattedTotal: function () {
                return `${this.total} ${this.total === 1 ? 'Result' : 'Results'}`;
            },
            threads: [],
        },
        articles: {
            total: 0,
            formattedTotal: function () {
                return `${this.total} ${this.total === 1 ? 'Result' : 'Results'}`;
            },
            articles: [],
        },
        users: {
            total: 0,
            formattedTotal: function () {
                return `${this.total} ${this.total === 1 ? 'Result' : 'Results'}`;
            },
            users: [],
        },
        toggle() {
            this.searchQuery = '';
            this.lockScroll = this.searchVisible;

            if (this.searchVisible) this.$nextTick(() => this.$refs.search.focus());
        },
        search: async function () {
            // If the input is empty, return no results.
            if (this.searchQuery.length === 0) {
                return Promise.resolve({ hits: [] });
            }

            // Perform the search using the provided input.
            const { results } = await client.multipleQueries([
                {
                    indexName: import.meta.env.VITE_ALGOLIA_THREADS_INDEX,
                    query: this.searchQuery,
                    params: {
                        hitsPerPage: 5,
                        attributesToSnippet: ['body:10'],
                    },
                },
                {
                    indexName: import.meta.env.VITE_ALGOLIA_ARTICLES_INDEX,
                    query: this.searchQuery,
                    params: {
                        hitsPerPage: 5,
                        attributesToSnippet: ['body:10'],
                    },
                },
                {
                    indexName: import.meta.env.VITE_ALGOLIA_USERS_INDEX,
                    query: this.searchQuery,
                    params: {
                        hitsPerPage: 5,
                        attributesToSnippet: ['bio:10'],
                    },
                },
            ]);

            this.threads.total = results[0].nbHits;
            this.threads.threads = results[0].hits;
            this.articles.total = results[1].nbHits;
            this.articles.articles = results[1].hits;
            this.users.total = results[2].nbHits;
            this.users.users = results[2].hits;
        },
    };
};

window.tabConfig = () => {
    return {
        activeTab: 'threads',
        setActiveTab: function (tab) {
            this.activeTab = tab;
        },
        currentTab: function (tab) {
            return this.activeTab === tab ? 'bg-white rounded-lg shadow text-indigo-900' : '';
        }
    };
}