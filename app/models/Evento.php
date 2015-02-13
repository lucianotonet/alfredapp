<?php

class Evento extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [
               'title',
               'allDay',
               'start',
               'end',
               'url',
               'className',
               'editable',
               'startEditable',
               'durationEditable',
               'color',
               'backgroundColor',
               'borderColor',
               'textColor',
               'cliente_id',
               'notification',
            ]; 

   

}