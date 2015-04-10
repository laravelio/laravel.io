# Contributing Guide

We welcome contributions to the Laravel.IO project. Please read the following guide on how to in pull requests.

## Pull Requests

- **Feature requests** first need to be discussed and accepted [through an issue](https://github.com/LaravelIO/laravel.io/issues/new) before sending in a pull request
- **Bug fixes** should contain [regression tests](https://laracasts.com/lessons/regression-testing)
- All pull requests should follow the [coding standards](#coding-standards)
- Pull requests will be merged after being reviewed by [the maintainers](readme.md#maintainers)
- Please be respectful to other contributors and hold to [The Code Manifesto](http://codemanifesto.com/)

## Coding Standards

- Follow the [PSR-2 Coding Standard](http://www.php-fig.org/psr/psr-2/)
- Add tests because we generally don't accept pull requests without them
- Write the full namespace in DocBlocks for `@param`, `@var` or `@return` tags

## Testing

All tests can be run with the following commands. Make sure to run this inside the Homestead box.

    $ vendor/bin/phpspec run
    $ vendor/bin/phpunit