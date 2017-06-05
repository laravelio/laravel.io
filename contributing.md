# Contributing Guide

We welcome contributions to the Laravel.io project. Please read the following guide before posting an issue or sending in pull requests. Please also read our [Code of Conduct](code_of_conduct.md) before contributing or engaging in discussions.

## Issues

- **Feature requests** need to describe as thoroughly as possible and perhaps contain some info on how you would implement it
- **Bug reports** need to be described in detail what the problem is, how it was triggered and perhaps contain a possible solution
- **Questions** are free to be asked about the internals of the codebase and about the project

## Pull Requests

- **Feature requests** first need to be discussed and accepted [through an issue](https://github.com/laravelio/laravel.io/issues/new) before sending in a pull request
- **Bug fixes** should contain [regression tests](https://laracasts.com/lessons/regression-testing)
- All pull requests should follow the [coding standards](#coding-standards)
- Pull requests will be merged after being reviewed by [the maintainers](readme.md#maintainers)
- Please be respectful to other contributors and hold to [The Code Manifesto](http://codemanifesto.com/)

## Coding Standards

- It's a good practice to write tests for your contribution
- Write the full namespace in DocBlocks for `@param`, `@var` or `@return` tags
- The rest of the coding standards will be checked by [StyleCI](https://styleci.io/)

## Testing

All tests can be run with the following commands. Make sure to run this inside the Homestead box.

    $ composer spec
    $ composer test
