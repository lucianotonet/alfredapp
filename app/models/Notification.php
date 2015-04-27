<?php

class Notification extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['title', 'type', 'date', 'owner_type', 'owner_id', 'user_id', 'status'];

	public function categories()
	{
		return $this->hasMany('Category')
		            ->where('owner_type', 'notification')
		 			->where('owner_id',  $this->id );
	}

	public function cliente()
	{
		return $this->belongsTo('Cliente');
	}

	public function tarefa()
	{
		return $this->belongsTo('Tarefa', 'owner_id')->where('owner_type', 'tarefa');
	}

}