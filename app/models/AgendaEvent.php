<?php

class AgendaEvent extends \Eloquent {
	protected $table = 'agendaevents';
	// Add your validation rules here
	public static $rules = [
		'title' => 'required'
	];
	public static $messages = array(
                                  'required' => 'O :attribute é obrigatório.',
                              );

	// Don't forget to fill this array
	protected $fillable = [
                           'title',
                           'description',
                           'icon', // integer
                           'date_start',
                           'date_end',                           
                           'time_start',
                           'time_end',    
                           'done', //bool
                           'category_id',
                           'cliente_id',
                           'user_id', 
                        ];

    protected $visible = array(
	                           'title', 
	                           'description', 
	                           'icon', 	                           	                          
	                           'date_start',
	                           'date_end',                           
	                           'time_start',
	                           'time_end',  
	                           'done'	                           
	                        );

	public function category()
	{
		return $this->belongsTo('Category');
	}

	public function cliente()
	{
		return $this->belongsTo('Cliente');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}	

}