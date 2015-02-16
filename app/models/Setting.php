<?php

class Setting extends \Eloquent {

	// Add your validation rules here
	public static $rules = ['setting_type' =>'required',
							'setting_name' =>'required'];

	// Don't forget to fill this array
	protected $fillable = ['user_id','setting_type','setting_name','setting_value'];

	public $timestamps = true;

	public function user()
	{
		return $this->belongsTo('User');
	}
}