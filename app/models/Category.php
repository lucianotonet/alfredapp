<?php

class Category extends Eloquent {

	protected $table = 'categories';
	public $timestamps = true;
	protected $fillable = array('name', 'owner_id', 'owner_type');
	protected $visible = array('name', 'owner_id', 'owner_type');

	// Add your validation rules here
	public static $rules = [
      'name' => 'required'
	];

	public function getTransactions()
	{
		return $this->hasMany('Transaction', 'category_id');
	}

}