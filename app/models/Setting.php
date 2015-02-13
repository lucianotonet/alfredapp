<?php

class Setting extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'user_id' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['user_id','configs'];

}