# Sparkdown Bundle

A simple bundle to provide [Markdown](http://daringfireball.net/projects/markdown/) and [Markdown Extra](http://michelf.com/projects/php-markdown/) functions.

Links and image URLs are passed through Laravel\URL::to and Larave\URL::to_asset.

## Installation

Install via the Artisan CLI:

```sh
php artisan bundle:install sparkdown
```

Or download the zip and unpack into your bundles directory.

## Bundle Registration

Just add `'sparkdown'` to your **application/bundles.php** file.

## Guide

### Parse some text

Start the bundle and use Sparkdown\Markdown

```php
Bundle::start('sparkdown');
echo Sparkdown\Markdown($text);
```

### View a markdown file

You can create Sparkdown\View objects, like Laravel\View objects

```php
Router::register('GET /about', function()
{
	// View of application/views/about.md
	return Sparkdown\View::make('about');

	// Also supports bundles and paths...
	// View of bundles/bundle/views/path/file.md
	return Sparkdown\View::make('bundle::path.file');
});
```

And you can route to the handy controller (needs 1 parameter).

```php
Route::get('(about)', 'sparkdown::page@show');
```
