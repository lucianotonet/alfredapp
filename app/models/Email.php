<?php

class Email extends \Eloquent {
   public static $rules    = [
                  'to' => 'required'
               ];
	protected $fillable = [
                  'from',
                  'to',
                  'cc',
                  'subject',
                  'message',
                  'attachments',
                  'resource_id',
                  'resource_name',
                  'headers',
                  'status'                  
               ];

   public function resource(){
      return $this->belongsTo( $this->resource_name , 'resource_id');
   }

   /**
    * http://matthewhailwood.co.nz/visualizing-laravel-relationships/#polymorphicOneToMany
    */
   public function owner(){
      return $this->morphTo('owner');
   }
   
}