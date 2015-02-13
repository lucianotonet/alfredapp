<?php

class Vendedor extends \Eloquent {	

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
}