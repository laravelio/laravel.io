## A Base-Model for Laravel's Eloquent ORM

**Version: 1.1**

This is just a simple Eloquent base model. As I think of more features to add here I will. This is not intended to be similar to Aware or any of those extended Eloquent models. This is intended to be a light-weight base model that only adds functionality that is expected to be used on most of my sites.

Since this base model is so basic I see no reason to submit it to the Laravel bundle repository.

### Feature Overview

- Validation

### Installation

Install to bundles/eloquent-base-model.

Then, update your bundles.php to auto-start the bundle.

	return array(
		'eloquent-base-model' => array( 'auto' => true ),
	);

### Example

Message Model

    class Message extends \EloquentBaseModel\Base
    {
        public static $accessible = array( 'subject', 'body' );

        public static $rules = array(
            'author_id'         => 'required|exists:users,id',
            'recipient_id'      => 'required|exists:users,id',
            'subject'           => 'required|min:3',
            'body'              => 'required',
        );
    }

Controller Action

    // validate message
    $message = new Message( Input::all() );

    $message->recipient_id = 1;
    $message->author_id    = 1;

    if( !$message->is_valid() )
    {
        return Redirect::back()->with_input()->with_errors( $message->validation );
    }

    $message->save();
