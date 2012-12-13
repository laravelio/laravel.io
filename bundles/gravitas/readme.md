# Gravitas Bundle

## Installation

```bash
php artisan bundle:install gravitas
```

## Bundle Registration

Add the following to your **application/bundles.php** file:

```php
'gravitas' => array(
	'autoloads' => array(
		'map' => array(
			'Gravitas\\API' => '(:bundle)/api.php',
		),
	),
),
```

## Guide

Get a Gravatar URL

```php
Gravitas\API::url('me@phills.me.uk', 120);
```

Get the HTML for a Gravatar image

```php
Gravitas\API::image('me@phills.me.uk', null, 'Phill Sparks');
```

## Configure

You can configure the size, rating and default image in **config/default.php**.  Full documentation is included in the config file.
