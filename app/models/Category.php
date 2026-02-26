<?php

class Category extends Eloquent {

	protected $table = 'categories';
	public $timestamps = true;
	protected $fillable = ['name', 'owner_id', 'owner_type'];
	protected $visible = ['name', 'owner_id', 'owner_type'];

	// Add your validation rules here
	public static $rules = [
      'name' => 'required'
	];

	public function getTransactions()
	{
		return $this->hasMany('Transaction');
	}

	public function tarefas()
	{
		return $this->hasMany('Tarefa');
	}

}