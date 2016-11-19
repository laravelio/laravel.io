# Contributing Guide

We welcome contributions to the Laravel.io project. Please read the following guide on how to send in pull requests.

## Pull Requests

- **Feature requests** first need to be discussed and accepted [through an issue](https://github.com/laravelio/laravel.io/issues/new) before sending in a pull request
- **Bug fixes** should contain [regression tests](https://laracasts.com/lessons/regression-testing)
- All pull requests should follow the [coding standards](#coding-standards)
- Pull requests will be merged after being reviewed by [the maintainers](readme.md#maintainers)
- Please be respectful to other contributors and hold to [The Code Manifesto](http://codemanifesto.com/)

## Coding Standards

- Follow the [PSR-2 Coding Standard](http://www.php-fig.org/psr/psr-2/)
- It's a good practice to write tests for your contribution
- Write the full namespace in DocBlocks for `@param`, `@var` or `@return` tags

## Testing

All tests can be run with the following commands. Make sure to run this inside the Homestead box.

    $ vendor/bin/phpspec run
    $ vendor/bin/phpunit
