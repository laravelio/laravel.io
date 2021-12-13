<p align="center">
    <img src="https://github.com/laravelio/art/blob/main/laravelio-logo-lg.svg" width="400" />
</p>

<p align="center">
    <a href="https://github.com/laravelio/laravel.io/actions?query=workflow%3ATests">
        <img src="https://github.com/laravelio/laravel.io/workflows/Tests/badge.svg" alt="Tests" />
    </a>
    <a href="https://github.styleci.io/repos/12895187">
        <img src="https://github.styleci.io/repos/12895187/shield?style=flat" alt="Code Style">
    </a>
</p>

# Laravel.io

This is the repository for the [Laravel.io](http://laravel.io) community portal. The code is entirely open source and licensed under [the MIT license](LICENSE.md). We welcome your contributions but we encourage you to read [the contributing guide](CONTRIBUTING.md) before creating an issue or sending in a pull request. Read the installation guide below to get started with setting up the app on your machine.

## Sponsors

We'd like to thank these **amazing companies** for sponsoring us. If you are interested in becoming a sponsor, please visit <a href="https://github.com/sponsors/laravelio">the Laravel.io Github Sponsors page</a>.

- **[Devsquad](https://devsquad.com)**
- **[LaraJobs](https://larajobs.com)**
- **[Cloudways](https://www.cloudways.com/en/?id=972670)**
- [Forge](https://forge.laravel.com)
- [Envoyer](https://envoyer.io)
- [Fathom](https://usefathom.com)
- [Blackfire.io](https://blackfire.io)
- [Tinkerwell](https://tinkerwell.app)
- [Akaunting](https://akaunting.com/developers?utm_source=Laravelio&utm_medium=Banner&utm_campaign=Developers)
- [Scout APM](https://ter.li/o1adaj)
- [red-amber.green](https://red-amber.green)

## Requirements

The following tools are required in order to start the installation.

- PHP >=8.0
- [Composer](https://getcomposer.org/download/)
- [NPM](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- [Valet](https://laravel.com/docs/valet#installation)

## Installation

> Note that you're free to adjust the `~/Sites/laravel.io` location to any directory you want on your machine. In doing so, be sure to run the `valet link` command inside the desired directory.

1. Clone this repository with `git clone git@github.com:laravelio/laravel.io.git ~/Sites/laravel.io`
2. Run `composer install` to install the PHP dependencies
3. Set up a local database called `laravel`
4. Run `composer setup` to setup the application
5. Set up a working e-mail driver like [Mailtrap](https://mailtrap.io/)
6. Run `valet link` to link the site to a testing web address
7. Configure the (optional) features from below

You can now visit the app in your browser by visiting [http://laravel.io.test](http://laravel.io.test). If you seeded the database you can login into a test account with **`johndoe`** & **`password`**.

### Github Authentication (optional)

To get Github authentication to work locally, you'll need to [register a new OAuth application on Github](https://github.com/settings/applications/new). Use `http://laravel.io.test` for the homepage url and `http://laravel.io.test/auth/github` for the callback url. When you've created the app, fill in the ID and secret in your `.env` file in the env variables below. You should now be able to authentication with Github.

```
GITHUB_ID=
GITHUB_SECRET=
GITHUB_URL=http://laravel.io.test/auth/github
```

### Algolia Search (optional)

To get Algolia search running locally, you'll need to [register for a new account](https://www.algolia.com/users/sign_up) and create an index called `threads`. Algolia has a free tier that satisfies all of the requirements needed for a development environment. Now update the below variables in your `.env` file. The App ID and secret keys can be found in the `API Keys` section of the Algoila UI. 

```
SCOUT_DRIVER=algolia
SCOUT_QUEUE=true

ALGOLIA_APP_ID=
ALGOLIA_SECRET="Use the Write API Key"

MIX_ALGOLIA_APP_ID="${ALGOLIA_APP_ID}"
MIX_ALGOLIA_SECRET="Use the Search API Key"
MIX_ALGOLIA_INDEX=threads
```

In order to index your existing threads, run the following command:

```bash
php artisan scout:import App\\Models\\Thread
```

New threads will be automatically added to the index and threads which get updated will be automatically synced. If you need to flush your index and start again, you can run the following command:

```bash
php artisan scout:flush App\\Models\\Thread
```

### Twitter Sharing (optional)

To enable published articles to be automatically shared on Twitter, you'll need to [create a Twitter app](https://developer.twitter.com/apps/). Once the app has been created, update the below variables in your `.env` file. The consumer key and secret and access token and secret can be found in the `Keys and tokens` section of the Twitter developers UI. 

```
TWITTER_CONSUMER_KEY=
TWITTER_CONSUMER_SECRET=
TWITTER_ACCESS_TOKEN=
TWITTER_ACCESS_SECRET=
```

Approved articles are shared in the order they were submitted for approval. Articles are shared twice per day at 14:00 and 18:00 UTC. Once an article has been shared, it will not be shared again.

## Commands

Command | Description
--- | ---
**`php artisan test --parallel`** | Run the tests
`php artisan migrate:fresh --seed` | Reset the database
`npm run watch` | Watch for changes in CSS and JS files

## Maintainers

The Laravel.io portal is currently maintained by [Dries Vints](https://github.com/driesvints) and [Joe Dixon](https://github.com/joedixon). If you have any questions please don't hesitate to create an issue on this repo.

## Contributing

Please read [the contributing guide](CONTRIBUTING.md) before creating an issue or sending in a pull request.

## Code of Conduct

Please read our [Code of Conduct](CODE_OF_CONDUCT.md) before contributing or engaging in discussions.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## License

The MIT License. Please see [the license file](LICENSE.md) for more information.
