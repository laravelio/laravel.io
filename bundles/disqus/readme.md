# [laravel-disqus](http://roumen.me/projects/laravel-disqus) bundle

A Laravel bundle for the DisqusAPI library.


## Installation

Install using the Artian CLI:

	php artisan bundle:install disqus

then edit ``application/bundles.php`` to autoload disqus:

```php
'disqus' => array('auto' => true)
```


## Example

```php
$secret_key = 'YOUR_SECRET_KEY';

$disqus = new DisqusAPI($secret_key);

// to turn off SSL
$disqus->setSecure(false);

// call the API
$disqus->trends->listThreads();
```

Documentation on all methods, as well as general API usage can be found at http://disqus.com/api/


## About DisqusAPI library

Author:		DISQUS <team@disqus.com>

Copyright:	2007-2010 Big Head Labs

License:        Apache version 2.0 (see disqusapi/LICENSE for more information)

Link:		http://disqus.com/