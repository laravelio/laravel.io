<?php namespace EloquentBaseModel;

class Base extends \Eloquent
{
	use \CacheableTrait;

	/**
	 * The rules array stores Validator rules in an array indexed by
	 * the field_name to which the rules should be applied.
	 *
	 * @var array
	 */
	public static $rules = array();

	/**
	 * The messages array stores Validator messages in an array indexed by
	 * the field_name to which the messages should be applied in case of errors.
	 *
	 * @var array
	 */
	public static $messages = array();

	/**
	 * The validation object is stored here once is_valid() is run.
	 * This object is publicly accessible so that it can be used
	 * to redirect with errors.
	 *
	 * @var object
	 */
	public $validation = false;

	/**
	 * Validates model.
	 *
	 * @param  array   $input
	 * @return bool
	 */
	public function is_valid()
	{
		if(empty(static::$rules))
		{
			return true;
		}

		// generate the validator and return its success status
		$this->validation = \Validator::make($this->attributes, static::$rules, static::$messages);

		return $this->validation->passes();
	}
}