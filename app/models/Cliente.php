<?php

   class Cliente extends Eloquent
   {

      public function pedidos(){
         return $this->hasMany('Pedido', 'cliente_id');
      }


      public function tarefas(){
         return $this->hasMany('Tarefa', 'cliente_id');
      }


      public function conversas(){
         return $this->hasMany('Conversa', 'cliente_id')->orderBy('id','DESC');
      }

      public function emails()
      {
         // EMAILS DO CLIENTE (exceto CC ou BCC)
         return $this->hasMany('Email', 'to', 'email');
      }

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
                           'cnpj'
                        );
   }