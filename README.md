<p align="center">
    <img src="https://github.com/laravelio/art/blob/main/laravelio-logo-lg.svg" width="400" />
</p>

<p align="center">
    <a href="https://github.com/laravelio/laravel.io/actions?query=workflow%3ATests">
        <img src="https://github.com/laravelio/laravel.io/workflows/Tests/badge.svg" alt="Tests" />
    </a>
    <a href="https://github.com/laravelio/laravel.io/actions?query=workflow%3A%22Code+Style%22">
        <img src="https://github.com/laravelio/laravel.io/workflows/Code%20Style/badge.svg" alt="Code Style" />
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://shield.with.social/cc/github/laravelio/laravel.io/main.svg?style=flat-square" alt="Laravel Version" />
    </a>
</p>

# Laravel.io

This is the repository for the [Laravel.io](http://laravel.io) community portal. The code is entirely open source and licensed under [the MIT license](LICENSE.md). We welcome your contributions but we encourage you to read the [the contributing guide](CONTRIBUTING.md) before creating an issue or sending in a pull request. Read the installation guide below to get started with setting up the app on your machine.

## Sponsors

We'd like to thank these **amazing companies** for sponsoring us. If you are interested in becoming a sponsor, please visit <a href="https://github.com/sponsors/laravelio">the Laravel.io Github Sponsors page</a>.

- **[Devsquad](https://devsquad.com)**
- [Forge](https://forge.laravel.com)
- [Envoyer](https://envoyer.io)
- [Fathom](https://usefathom.com)
- [Blackfire.io](https://blackfire.io)
- [Tinkerwell](https://tinkerwell.app)

## Requirements

The following tools are required in order to start the installation.

- [Composer](https://getcomposer.org/download/)
- [NPM](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- [Valet](https://laravel.com/docs/valet#installation)
- PHP >=7.3

## Installation

> Note that you're free to adjust the `~/Sites/laravel.io` location to any directory you want on your machine. In doing so, be sure to run the `valet link` command inside the desired directory.

1. Clone this repository with `git clone git@github.com:laravelio/laravel.io.git ~/Sites/laravel.io`
2. Run `composer install` to install the PHP dependencies
3. Setup a local database called `laravelio`
4. Run `composer setup` to setup the application
5. Setup a working e-mail driver like [Mailtrap](https://mailtrap.io/)
6. (optional) Set up Github authentication (see below)

You can now visit the app in your browser by visiting [http://laravel.io.test](http://laravel.io.test). If you seeded the database you can login into a test account with **`johndoe`** & **`password`**.

### Github Authentication (optional)

To get Github authentication to work locally, you'll need to [register a new OAuth application on Github](https://github.com/settings/applications/new). Use `http://laravel.io.test` for the homepage url and `http://laravel.io.test/auth/github` for the callback url. When you've created the app, fill in the ID and secret in your `.env` file in the env variables below. You should now be able to authentication with Github.

```
GITHUB_ID=
GITHUB_SECRET=
GITHUB_URL=http://laravel.io.test/auth/github
```

### Algolia search (optional)

To get Algolia search running locally, you'll need to [register for a new account](https://www.algolia.com/users/sign_up) and create an index called `threads`. Algolia has a free tier which satisfies all of the requirements needed for a development environment. Now update the below variables in your `.env` file. The App ID and secret keys can be found in the `API Keys` section of the Algoila UI. 

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

`php artisan scout:import App\\Models\\Thread`

New threads will be automatically added to the index and threads which get edited will be automatically updated. If you need to flush your index and start again, you can run the following command:

`php artisan scout:flush App\\Models\\Thread`

## Maintainers

The Laravel.io portal is currently maintained by [Dries Vints](https://github.com/driesvints) and [Joe Dixon](https://github.com/joedixon). If you have any questions please don't hesitate to create an issue on this repo.

## Contributing

Please read [the contributing guide](CONTRIBUTING.md) before creating an issue or sending in a pull request.

## Code of Conduct

Please read our [Code of Conduct](CODE_OF_CONDUCT.md) before contributing or engaging in discussions.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel.io, please send an email immediately to [security@laravel.io](mailto:security@laravel.io). **Do not create an issue for the vulnerability.**

## License

The MIT License. Please see [the license file](LICENSE.md) for more information.
