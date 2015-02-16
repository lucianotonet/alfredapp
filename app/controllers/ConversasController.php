<?php

class ConversasController extends \BaseController {

	/**
	 * Display a listing of conversas
	 *
	 * @return Response
	 */
	public function index()
	{
		$conversas = Conversa::orderBy('id', 'DESC')->get();
            
      
      $ontem            = mktime (0, 0, 0, date("m")  , date("d")-1, date("Y")  );
      $anteontem        = mktime (0, 0, 0, date("m")  , date("d")-2, date("Y")  );

      $conversas->hoje       = Conversa::where('data', '=', date('Y-m-d'))->get();
      $conversas->ontem      = Conversa::where('data', '=', date('Y-m-d', $ontem) )->get();
      $conversas->anteontem  = Conversa::where('data', '=', date('Y-m-d', $anteontem) )->get();
      $conversas->anteriores = Conversa::where('data', '<', date('Y-m-d', $anteontem) )->get();

      // $conversas_hoje = Conversa::where(function ($query)use($hoje) {
      //                                               $query->where('created_at', '=', $hoje)
      //                                                     ->orWhere('b', '=', 1);
      //                                           })->where(function ($query) {
      //                                               $query->where('c', '=', 1)
      //                                                     ->orWhere('d', '=', 1);
      //                                           });

      //if( Request::ajax() ){
      //return $conversas;
      //}else{         
		  return View::make('conversas.index', compact('conversas'));
      //}
        
	}

	/**
	 * Show the form for creating a new conversa
	 *
	 * @return Response
	 */
	public function create($id = NULL)
	{
      if($id){
         $cliente      = Cliente::find($id);
         $fornecedores = Fornecedor::all();
         $produtos     = Produto::all();
         $vendedores   = Vendedor::all();

         if (Request::ajax()) {
            return View::make('conversas.panels.create');
         } else {         
   		   return View::make('conversas.create', compact('cliente','fornecedores','produtos','vendedores'));            
         }


      }else{
         $alert[] = [   'class' => 'alert-warning', 'message'   => 'Escolha um cliente para criar uma nova conversa.' ];
         Session::flash('alerts', $alert);
         return Redirect::to('clientes');    
      }
	}

	/**
	 * Store a newly created conversa in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
      $validator = Validator::make($data = Input::all(), Conversa::$rules);
         
         //return Conversa::create($data);
         if ($validator->fails())
         {
            return Response::json(array('success' => false));
         }

         $conversa = Conversa::create($data);  

         if($conversa){
            $alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong>Conversa salva com sucesso!' ];            
            
            // AGENDAR PRÓXIMA CONVERSA
            if( isset( $data['tarefa_title'] ) ){
               $cliente = Cliente::find($data['cliente_id']);

               if( !empty($data['tarefa_title']) ){ $tarefa_title = $data['tarefa_title']; }
               else{ $tarefa_title = "Conversa agendada com ".$cliente->nome; }

               $tarefa  = Tarefa::create([
                           'start'      => date('Y-m-d H:m:i', strtotime($data['tarefa_date'])),
                           'cliente_id' => $data['cliente_id'],
                           'conversa_id'=> $conversa->id,
                           'title'      => $tarefa_title,
                           'tipo'		=> $data['tarefa_tipo']
                        ]);
               if($tarefa){                  
                  $alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="icon-alarm"></i></strong> Próxima conversa agendada para '.date( 'd \d\e F', strtotime($tarefa->start) ) ];    
               }
            }
         }else{            
            $alert[] = [   'class' => 'alert-warning', 'message'   => '<strong><i class="fa fa-times"></i></strong> Erro! Não foi possível salvar a conversa.' ];
         }
         
         Session::flash('alerts', $alert);
         return Redirect::to( URL::previous() );  
         //return Response::json(array('success' => true));         

	}

	/**
	 * Display the specified conversa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$conversa = Conversa::find($id);

      if (Request::ajax()) {
          return View::make('conversas.panels.show', compact('conversa'));
      } else {         
         return View::make('conversas.show', compact('conversa'));
      }
	}

   /**
    * RETURN A VIEW.
    *
    * @param  int  $id
    * @return Response
    */
   public function view($id)
   {
      $conversa = Conversa::find($id);

      if (Request::ajax()) {
          return View::make('conversas.item', compact('conversa'));
      } else {         
         return View::make('conversas.show', compact('conversa'));
      }
   }

	/**
	 * Show the form for editing the specified conversa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$conversa = Conversa::find($id);

		return View::make('conversas.edit', compact('conversa'));
	}

	/**
	 * Update the specified conversa in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$conversa = Conversa::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Conversa::$rules);

		if ($validator->fails())
		{
         //Show error message
         $alert[] = [   'class' => 'alert-danger', 'message'   => 'Opa! Confere aí...' ];            
         Session::flash('alerts', $alert);

         return Redirect::back()
            ->withErrors($validator)
            ->withInput(Input::all());			
		}

      //else
		$conversa->update($data);
      //Show success message

      $alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Conversa atualizada!' ];             
      Session::flash('alerts', $alert);


      return Redirect::to( URL::previous() );  
	}

	/**
	 * Remove the specified conversa from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Conversa::destroy($id);      
      $alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Conversa excluída!' ];              
      Session::flash('alerts', $alert);
      return Redirect::to( URL::previous() );  
	}

}
