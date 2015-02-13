<?php

class Despesa extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		//'date' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['date','descricao','cidade','valor'];

	public function relatorio(){
      return $this->belongsTo('Relatorio');
   }	

}