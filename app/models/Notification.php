<?php
use Carbon\Carbon as Carbon;
class Notification extends \Eloquent {

   public $fechar = "";

   public static $rules = [];
	protected $fillable = ['class','status','title','message','type','date','tarefa_id'];

   /**
    *    FECHAR NOTIFICAÇÕES
    *
    * @param  int  $id
    * @return Response
    */
   public function close()
   {        
      $this->status = '1';
      $this->save();
      return $this;      
   }

   public function tarefa(){
      return $this->belongsTo('Tarefa');
   }

    public function daysbefore($days='')
    {
        if( $this->tarefa ){
            $dataNotification = Carbon::create( date('Y',strtotime($this->tarefa->start)), date('m',strtotime($this->tarefa->start)), date('d',strtotime($this->tarefa->start)) );                        
            $dataTarefa       = Carbon::create( date('Y',strtotime($this->date) ), date('m',strtotime($this->date) ), date('d',strtotime($this->date) ) );             
            return $dataNotification->diffInDays( $dataTarefa );           
        }
        return false;        
    }  
}