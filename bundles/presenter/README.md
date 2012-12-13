# Laravel Presenter Bundle

This is a very simplistic presenter pattern implentation.  It allows
the developer to wrap presentation logic inside of an object to pass 
to the view - keeping the templates free of as much logic as possible.

There is also a PresenterCollection class to allow the developer to
wrap an entire result set in presenters easily.

All you need to get started is to create a presenter, extend from the
Presenter class, add your class to the autoloader, and set up the presenter
to your liking!

## Example

```php
// Presenter
<?php

class UserPresenter extends \Presenter
{
    // Let's us name the variable for our resource
	public $resource_name = 'user';

    public function name()
    {
        return "{$this->user->first_name} {$this->user->last_name}";
    }

    // Methods are also available as magic getters
	public function confirmed_at()
	{
		return $this->user->confirmed_at->format('m/d/Y');
	}
}
// End Presenter

<?php

// Routes or controller equivalent
Route::get('user/(:num)', function($id) {
	$user = User::find($id);

	return View::make('profile')->with('user', new UserPresenter($user));
});
// End Route

// Template/View
<h1>{{ $user->name }}</h1>
<p>User was confirmed at {{ $user->confirmed_at }}</p>

<p>{{ $user->bio }}</p>
<p>
    Note that user attributes that aren't set on the presenter
    will pass through to the original resource like a proxy.
    This also works with methods.
</p>

<div class="avatar">{{ $user->avatar() }}</div>
// End Template/View

```

Released under the MIT license

# [Laravel](http://laravel.com) - A PHP Framework For Web Artisans
# [Matthew Machuga](http://matthewmachuga.com) - My Site
