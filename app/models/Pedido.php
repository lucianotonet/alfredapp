<?php

class Pedido extends \Eloquent {   

	// Add your validation rules here
	public static $rules = [
		  // 'cliente_id'       => 'required',        
    //   'frete'            => 'required',
    //   'fornecedor_id'    => 'required',
    //   'vendedor_id'      => 'required',
    //   'itens'            => 'required'      
	];

   public static $messages = array(
             'required' => 'O campo :attribute não foi informado.',
         );

	// Don't forget to fill this array
	protected $fillable = array(
                           'status',
                           'cliente_id',
                           'entrega_data',
                           'entrega_endereco',
                           'frete',
                           'fornecedor_id',
                           'vendedor_id',
                           'pgto',
                           'itens',
                           'total',
                           'obs',
                           'obs_adm'                     
                        );

   public function cliente(){
      return $this->belongsTo('Cliente', 'cliente_id');
   }

   public function fornecedor(){
      return $this->belongsTo('Fornecedor', 'fornecedor_id');
   }

   public function vendedor(){
      return $this->belongsTo('Vendedor');
   }

   public function emails(){
      // $emails = Email::where('resource_name', 'like', 'pedido')->orderBy('id','DESC')->get();
      return $this->hasMany('Email', 'resource_id')->where('resource_name', 'like', 'pedido');
   }   

   public static function boot()
   {
      parent::boot();

      // Setup event bindings...
      Pedido::creating(function($pedido)
      {           

         // exit;
      });

      Pedido::created(function($pedido)
      {
         // Report::create([
         //    'user_id'        => Auth::id(),
         //    'status'         => 'success',
         //    'event'          => 'created',
         //    'title'          => 'Pedido criado',
         //    'resource_model' => 'Pedido',
         //    'resource_id'    => $pedido->id,
         //    'resource_obj'   => json_encode($pedido),
         // ]);
      });

      Pedido::saving(function($pedido)
      {
         
      });

      Pedido::saved(function($pedido)
      {
         // Report::create([
         //    'user_id'        => Auth::id(),
         //    'status'         => 'success', // info, success, warning, danger
         //    'event'          => 'saved',
         //    'title'          => 'Pedido salvo',
         //    'resource_model' => 'Pedido',
         //    'resource_id'    => $pedido->id
         //    'resource_obj'   => json_encode($pedido),
         // ]);
         
      });

      Pedido::updating(function($pedido)
      {
         
      });

      Pedido::updated(function($pedido)
      {
         // Report::create([
         //    'user_id'        => Auth::id(),
         //    'status'         => 'success',
         //    'event'          => 'updated',
         //    'title'          => 'Pedido atualizado',
         //    'resource_model' => 'Pedido',
         //    'resource_id'    => $pedido->id,
         //    'resource_obj'   => json_encode($pedido),
         // ]);
      });

      Pedido::deleting(function($pedido)
      {
         
      });

      Pedido::deleted(function($pedido)
      {
         // Report::create([
         //    'user_id'        => Auth::id(),
         //    'status'         => 'danger', // info, success, warning, danger
         //    'event'          => 'deleted',
         //    'title'          => 'Pedido excluído',
         //    'resource_model' => 'Pedido',
         //    'resource_id'    => $pedido->id,
         //    'resource_obj'   => json_encode($pedido),
         // ]);
      });

   }


   /**
    * AGUARDANDO
    *
    * @return Response
    */
   public static function aguardando()
   {
      $pedidos = Pedido::where('status', 1)->orderby('id', 'DESC')->get(); 
      $pedidos->each(function($pedido)
      {
         // JÁ EXISTE EMAIL DESTE PEDIDO ???
         $email = Email::where( 'resource_name', 'pedido')
                        ->where( 'resource_id', $pedido->id)                           
                        ->first();   

         

          //
      });
      return $pedidos;
   }

   /**
    * ENVIADOS
    *
    * @return Response
    */
   public static function enviados()
   {   
      $pedidos = Pedido::where('status', 2)->orderby('id', 'DESC')->get();             
      return $pedidos;
   }


    public function getAttachment()
    {
        $attachment = "pdf/pedido-".$this->id.".pdf";               
        if( is_file( $attachment ) ){
            return $attachment;
        } else {
            return NULL; 
        }
    }


    public function arquivar(){
        $this->status = 3;
        $this->save();
        return $this;
    }

}