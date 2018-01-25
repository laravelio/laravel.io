# Developers.mv Community Portal

This is the repository for the [Developers.mv](http://developers.mv) community portal. The code is entirely open source and licensed under [the MIT license](license.txt). We welcome your contributions but we encourage you to read the [the contributing guide](contributing.md) before creating an issue or sending in a pull request. Read the installation guide below to get started with setting up the app on your machine.

We hope to see your contribution soon!

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Maintainers](#maintainers)
- [Contributing](#contributing)
- [Code of Conduct](#code-of-conduct)
- [Security Vulnerabilities](#security-vulnerabilities)
- [License](#license)

## Requirements

The following tools are required in order to start the installation.

- [VirtualBox](https://www.virtualbox.org/)
- [Vagrant](https://www.vagrantup.com/)

## Installation


1. Clone this repository
2. Run `composer start`
4. Run `vagrant up`
5. SSH into your Vagrant box, go to `/home/vagrant/Code/developers` and run `composer setup`
6. Add `192.168.10.10 developers.test` to your computer's `/etc/hosts` file
7. Setup a working e-mail driver like [Mailtrap](https://mailtrap.io/)
8. (optional) Set up Github authentication (see below)


### Github Authentication (optional)

To get Github authentication to work locally, you'll need to [register a new OAuth application on Github](https://github.com/settings/applications/new). Use `http://developers.test` for the homepage url and `http://developers.test/auth/github` for the callback url. When you've created the app, fill in the ID and secret in your `.env` file in the env variables below. You should now be able to authentication with Github.

```
GITHUB_ID=
GITHUB_SECRET=
GITHUB_URL=http://developers.test/auth/github
```

## Maintainers

The Developers.mv portal is currently maintained by [Raf](https://github.com/raftalks). If you have any questions please don't hesitate to create an issue on this repo or ask us through the MV Developers group on [Telegram](https://t.me/mvdevelopers).

## Contributing

Please read [the contributing guide](contributing.md) before creating an issue or sending in a pull request.

## Code of Conduct

Please read our [Code of Conduct](code_of_conduct.md) before contributing or engaging in discussions.

## Security Vulnerabilities

If you discover a security vulnerability within Developers.mv, please send an email immediately to Raf at [raftalks@gmail.com](mailto:raftalks@gmail.com). **Do not create an issue for the vulnerability.**

## License

The MIT License. Please see [the license file](license.txt) for more information.
