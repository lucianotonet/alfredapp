<?php

class Report extends \Eloquent {
	
   protected $rules = [
                  'status'          => 'required',
                  'event'           => 'required',
                  'resource_model'  => 'required',
                  'resource_id'     => 'required',                  
                  'user_id'         => 'required'
               ];
   
   protected $fillable = [ 
                  'status', 
                  'event', 
                  'resource_id', 
                  'resource_model', 
                  'resource_obj', 
                  'title', 
                  'user_id'
               ];

   public function user(){
      return $this->belongsTo('User');
   }


   public function getDates(){
      return array('created_at');
   }


}