<?php

class Conversa extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
   ];

   public static function date(){
      return date('d/m', strtotime($this->created_at) );
   }

   // Don't forget to fill this array
   protected $fillable = array(
                           'data',                           
                           'cliente_id',
                           'previsao_compra',
                           'previsao_instalacao',
                           'tarefa_id',
                           'relatorio_id',
                           'resumo'
                        );

   public function cliente(){
      return $this->belongsTo('Cliente');
   }

   public function tarefas(){
      return $this->hasMany('Tarefa', 'conversa_id');
   }

   public function relatorios(){
      return $this->hasOne('Relatorio');
   }


}