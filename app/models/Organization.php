<?php

class Organization extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	protected static $vendor;

	protected $fillable = ['name'];

	public function vendor()
	{
		static::$vendor || static::$vendor = static::find(1);
		return static::$vendor;
	}

	public function users()
	{
		return $this->hasMany('User');
	}

	public function isVendor()
	{
		return $this->id === static::vendor()->id;
	}

}