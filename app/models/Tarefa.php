<?php
use \Carbon\Carbon as Carbon;
class Tarefa extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
	];

	public static $messages = array(
		'required' => 'O :attribute é obrigatório.',
		);

	// Don't forget to fill this array
	protected $fillable = [
		'icon',
		'title',
		'description',
		'date',
		'time',
		
		'cliente_id',
		'conversa_id',
		'notification_id',
		'category_id',

		'owner_id',

		'done'
	];

   /**
	* CHECK
	* Marca a tarefa como concluída ou não
	*/
	public function check(){
		$this->done = $this->done ? false : true;
		$this->save();
	}

	public function conversas(){
		return $this->belongsTo('Conversa', 'tarefa_id');
	}

	public function cliente(){
		return $this->belongsTo('Cliente');
	}

	public function category(){
		return $this->belongsTo('Category');
	}

	public function notifications(){
		return $this->hasMany('Notification', 'owner_id');
	}

   // ESTÁ ATRASADA?
	public function atrasada(){
		$start = $this->date;
		$tarefa_start  = Carbon::createFromFormat("Y-m-d", $start);
		if( $tarefa_start->isPast() and !$tarefa_start->isToday() ){
		 // TAREFA ATRASADA
			return true;
		}
		return false;

	}
   // QUANTOS DIAS ATRASADA?
	public function dias(){      
		$tarefa_start  = Carbon::createFromFormat("Y-m-d", $this->date);

		if( $this->done ){
			return 0;
		}else {
			return $tarefa_start->diffInDays();
		}
	}



}