<?php

class Movimento extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'valor' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['valor','data','desc'];

}