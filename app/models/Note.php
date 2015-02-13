<?php

class Note extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'note' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['note'];


   public static function boot()
   {
      parent::boot();

      // Setup event bindings...
      Note::creating(function($note)
      {           

         // exit;
      });

      Note::created(function($note)
      {
         // Report::create([
         //    'user_id'        => Auth::id(),
         //    'status'         => 'success',
         //    'event'          => 'created',
         //    'title'          => 'Nota adicionada',
         //    'resource_model' => 'Nota',
         //    'resource_id'    => $note->id,
         //    'resource_obj'   => json_encode($note),
         // ]);

         $alert = array(                     
                     'alert-success' => 'Nota criada!'
                  );       
         Session::flash('alerts', $alert);

      });

      Note::saving(function($note)
      {
         
      });

      Note::saved(function($note)
      {
         // Report::create([
         //    'user_id'        => Auth::id(),
         //    'status'         => 'success', // info, success, warning, danger
         //    'event'          => 'saved',
         //    'title'          => 'Nota salvo',
         //    'resource_model' => 'Nota',
         //    'resource_id'    => $note->id
         //    'resource_obj'   => json_encode($note),
         // ]);
         
      });

      Note::updating(function($note)
      {
         
      });

      Note::updated(function($note)
      {
         // Report::create([
         //    'user_id'        => Auth::id(),
         //    'status'         => 'success',
         //    'event'          => 'updated',
         //    'title'          => 'Nota atualizada',
         //    'resource_model' => 'Nota',
         //    'resource_id'    => $note->id,
         //    'resource_obj'   => json_encode($note),
         // ]);
         $alert = array(                     
                     'alert-success' => 'Nota salva!'
                  );       
         Session::flash('alerts', $alert);
      });

      Note::deleting(function($note)
      {
         
      });

      Note::deleted(function($note)
      {
         // Report::create([
         //    'user_id'        => Auth::id(),
         //    'status'         => 'danger', // info, success, warning, danger
         //    'event'          => 'deleted',
         //    'title'          => 'Nota excluída',
         //    'resource_model' => 'Nota',
         //    'resource_id'    => $note->id,
         //    'resource_obj'   => json_encode($note),
         // ]);
         $alert = array(                     
                     'alert-warning' => 'Nota excluída!'
                  );       
         Session::flash('alerts', $alert);
      });

   }


}