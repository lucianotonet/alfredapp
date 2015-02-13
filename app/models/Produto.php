<?php

class Produto extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'cod' => 'required',
      'nome' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [
         'cod',
         'nome',
         'preco',
         'unidade',
         'category_id',
         'detalhes'
      ];

   protected $table = 'produtos';
   public $timestamps = true;

   public function category()
   {
      return $this->belongsTo('Category');
   }

}