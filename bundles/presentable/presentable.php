<?php

/**
* Presentable class
*
* This class is heavily based off of Machuga's Presenter bundle. https://github.com/machuga/laravel-presenter
*
* It has been modified to provide static method pass-through as well as some other somewhat significant changes.
*
* @author Shawn McCool <shawn@heybigname.com>
* @author Matthew Machuga
*
* @version 1.0
* @license MIT
*/
class Presentable
{
    public $resource      = null;
    public $resource_name = 'resource';

    /**
    * Assign the resource and set an instance variable with the name
    * of the resource for more meaningful access for derived classes.
    */
    public function __construct($resource = null)
    {
        $resource and $this->resource = $resource;

        $this->{$this->resource_name} = $this->resource;
    }

    public static function make($resource = null)
    {
        if(is_null($resource))
        {
            return null;
        }

        $presenter_class_name = get_called_class();

        if(is_array($resource))
        {
            return new PresentableCollection($presenter_class_name, $resource);
        }

        return new $presenter_class_name($resource);
    }

    public static function __callStatic($name, $arguments)
    {
        // make assumptions about the resource class name
        $presenter_class_name = get_called_class();
        $resource_class_name  = str_replace("Presenter", "", $presenter_class_name);

        if(!class_exists($resource_class_name))
        {
            throw new Exception('Presentable: Resource class '.get_called_class().' does not exist');
        }

        $result = call_user_func_array(array($resource_class_name, $name), $arguments);

        if(is_null($result))
        {
            return null;
        }
        
        if(is_array($result))
        {
            return new PresentableCollection($presenter_class_name, $result);
        }

        return new $presenter_class_name($result);
    }

    /**
    * Magically return values from methods as if they're attributes.
    *
    * If the method doesn't exist then call for the property from the resource.
    */
    public function __get($key)
    {
        if(method_exists($this, $key))
        {
            return $this->{$key}();
        }
        else
        {
            return $this->resource->$key;
        }
    }

    /**
    * Magically call methods on the resource.
    *
    * If they don't exist then throw an exception.
    */
    public function __call($key, $args)
    {
        if(method_exists($this->resource, $key))
        {
            return call_user_func_array(array($this->resource, $key), $args);
        }
        else
        {
            throw new Exception('Presentable: '.get_called_class().'::'.$key.' method does not exist');
        }
    }

    /**
    * Magically treat string conversion of this class as string conversion of
    * the resource instead.
    */
    public function __toString()
    {
        return $this->resource->__toString();
    }
}