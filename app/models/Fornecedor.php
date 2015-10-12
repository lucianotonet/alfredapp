<?php

class Fornecedor extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
   protected $fillable = array(
                           'nome',
                           'empresa',
                           'endereco',
                           'bairro',
                           'cidade',
                           'cep',
                           'uf',
                           'telefone',
                           'celular',
                           'email',
                           'ie',
                           'cnpj',
                        );

    public function pedidos(){
        return $this->hasMany('Pedido', 'fornecedor_id');
    }

}