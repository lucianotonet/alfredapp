<?php
use Carbon\Carbon as Carbon;
use Faker\Factory as Faker;

class ClienteController extends \BaseController {

	protected $table_fields =[
		'nome',
		'empresa',
		'endereco',
		'bairro',
		'cidade',
		'cep',
		'uf',
		'telefone',
		'celular',
		'email',
		'ie',
		'cnpj'
	];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{           



			if( Request::ajax() ){
				 $query = Input::get('query');         

				 //return Response::json($query);

				 $clientes = Cliente::with('pedidos','conversas')
																 ->where('nome', 'like', '%'.$query.'%')                               
																 ->orWhere('empresa', 'like', '%'.$query.'%')
																 ->orWhere('cidade', 'like', '%'.$query.'%')                                 
																 ->get();


				 return Response::json($clientes);

			}else{


					 

				 // get all the clientes
				 if( isset( $_GET['orderby'] ) ){
						$clientes = Cliente::with('pedidos','conversas')->orderBy( $_GET['orderby'] )->get();               
				 }else{
						$clientes = Cliente::with('pedidos','conversas')->orderBy( 'nome' )->get();             

				 }
				 
				 // $pedidos = Pedido::sortBy('cliente_id')->





				 $topten = DB::table('pedidos')
								 ->select('cliente_id', DB::raw('count(*) as total'))
								 ->groupBy('cliente_id')
								 ->orderBy('total', 'DESC')
								 ->take(10)
								 ->get();

				 if( count($topten) ){
						$itemIds = array();
						foreach ($topten as $cliente) {
							 $itemIds[] = $cliente->cliente_id;
						}
						$ids = implode(',', $itemIds);
						 
						$clientes->topten = Cliente::whereIn('id', $itemIds)
						 ->orderByRaw(DB::raw("FIELD(id, $ids)"))
						 ->take( 10 )
						 ->get();
				 }else{
						$clientes->topten = array();
				 }

				 
				
				 return View::make('clientes.index')
						->with('clientes', $clientes);
			}

			


			

	}   



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// load the create form (app/views/clientes/create.blade.php)      
		return View::make('clientes.create');

	}
	

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Validator
		// leia mais sobre Validator em http://laravel.com/docs/validation      
			$rules = array(
				 // 'nome'       => 'required',
				 // 'empresa'    => 'required'       
			);
			$validator = Validator::make(Input::all(), $rules);
			
			if ($validator->fails()) {

				 return Redirect::to('clientes/create')
				->withErrors($validator)
				->withInput(Input::except('password'));


		} else {
			// store
			Cliente::create($this->post_to_array($this->table_fields));
				 //Session::flush();
				 $alert[] = [   'class' => 'alert-success', 'message'   => 'Novo cliente adicionado!' ];
				 Session::flash('alerts', $alert);
			return Redirect::to('clientes');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{


			// Schema::table('conversas', function($table)
			// {
			//  $table->string('important');
			// });
			// exit;


		// Cliente
		//$cliente  = Cliente::with('pedidos.emails')->find($id);
			$cliente  = Cliente::with('pedidos','conversas','tarefas')->find($id);
			
			// Pedidos do cliente
			//$pedidos  = $cliente->pedidos();  

			// return $cliente;
			// exit;


			
			


			if($cliente){
				 $pedidos  = $cliente->pedidos();  
			

				 // $roles = User::find(1)->roles->toArray();


				 // foreach ($pedidos as $pedido)
				 // {
				 //    if( $pedido->status == 1 ){
				 //       $pedido = array_add( $pedidos->aguardando, $pedido );            
				 //    }else
				 //    if( $pedido->status == 2 ){
				 //       $pedido = array_add( $pedidos->enviados, $pedido );         
				 //    }
				 // }


				 // foreach ($cliente->tarefas as $tarefa)
				 // {
				 //    if( $tarefa->done == 0 ){
				 //       $tarefa = array_add( $cliente->tarefas->pendentes, $tarefa );            
				 //    }
				 // }
				 

				$tarefas = $cliente->tarefas;

				$hoje    = date('Y-m-d');
				$ontem   = Carbon::create(date('Y'), date('m'), date('d'))->subDay();
				$amanha  = Carbon::create(date('Y'), date('m'), date('d'))->addDay();
				$proximo = Carbon::create(date('Y'), date('m'), date('d'))->addDay();//Igual amanhã
				if( $proximo->isWeekend() ){
				 $proximo = new Carbon('next monday');           
				}   
 
				 $tarefas->pendentes = Tarefa::where('cliente_id', $cliente->id )->where('start','<',$hoje )->where('done', 0)->orderBy('start', 'DESC')->get();
				 $tarefas->hoje      = Tarefa::where('cliente_id', $cliente->id )->where('start','<',$amanha->startOfDay())->where('start','>',$ontem)->where('done', 0)->get();

				 $tarefas->nextDay   = Tarefa::where('cliente_id', $cliente->id )
																								->where('done', 0)
																								->where('start','>=',$amanha)                            
																								->where('start','<',$proximo->addDay())   
																								->orderBy('start', 'DESC')                                                
																								->get();
			$tarefas->proximas   = Tarefa::where( 'cliente_id', $cliente->id )->where( 'start', '>=', $amanha->startOfDay() )->where( 'done', 0)->orderBy( 'start', 'ASC')->get();
			$tarefas->concluidas = Tarefa::where( 'cliente_id', $cliente->id )->where( 'done', 1)->orderBy( 'updated_at', 'DESC')->get();                                    

				 
			// show the view and pass the cliente to it
			return View::make('clientes.show', compact('cliente','tarefas'));                     			
															//->with( 'pedidos', $cliente->pedidos() );
			}else{         
				 $alert[] = [   'class' => 'alert-warning', 'message'   => 'O cliente que você procura não existe!' ];
				 Session::flash('alerts', $alert);
				 return Redirect::to('clientes');
			} 


	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// get the cliente
		$cliente = Cliente::find($id);

		// show the edit form and pass the cliente
		return View::make('clientes.edit')
			->with('cliente', $cliente);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('clientes/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			Cliente::where('id', $id)->update($this->post_to_array($this->table_fields));
				 //Show success message         
					$alert[] = [   'class' => 'alert-success', 'message'   => 'Cliente atualizado com sucesso!' ];
				 Session::flash('alerts', $alert);

			// redirect
			return Redirect::to('clientes');
		}
	}
	

	 /**
		* Adiciona um item randomico
		*
		* @return Response
		*/
	 public function add()
	 {
				 

				 // // redirect
				 // Session::flash('message', 'Um cliente randomico foi adicionado!');
				 // return Redirect::to('clientes');

				 // get all the clientes
				 $clientes = Cliente::all();      

				 // load the view and pass the clientes
				 return View::make('clientes.index')
						->with('clientes', $clientes);
	 }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// delete
		$cliente = Cliente::find($id);
		$cliente->delete();

		//Show success message
				 $alert[] = [   'class' => 'alert-success', 'message'   => 'O item foi excluído com sucesso!' ];
				 Session::flash('alerts', $alert);
			
			// redirect
		return Redirect::to('clientes');
	}


	 /**
		* Enviar dados do cliente por email
		*
		* @param  int  $id
		* @return Response
		*/
	 public function enviarcontato($id)
	 {
			// delete
			$cliente = Cliente::find($id);
			echo "<pre>";
			print_r($cliente);
			echo "</pre>";
			//exit;

			$resource               = Cliente::find($id);  
			$email['resourcename']  = 'cliente';
			$email['fornecedores']  = Fornecedor::all();
			$email['to']            = array(
																		 "nome"     => "Luciano T.",
																		 "email"    => "tonetlds@gmail.com",
																	);
			$email['cc']   = array(
												 "nome"     => "",
												 "email"    => "contato@lucianotonet.com",
											);
			$email['content'] = "Teste";
			$email['message'] = "Olá, segue os dados do cliente.";





			return View::make('emails.create', compact('email','resource'));

	 }


	 public function getConversas($id){     
			return Cliente::find($id)->conversas()->get();
	 }

	 public function getTarefas($id){     
			return Cliente::find($id)->tarefas()->get();
	 }   


     /*   

      GET Costumers
         via AJAX



    */
   public function getCostumers()
   {
      //if( Request::ajax() ){
         $query = Input::get('query');         

         $clientes      = Cliente::where('nome', 'like', '%'.$query.'%')->orWhere('empresa', 'like', '%'.$query.'%')->get();
         $fornecedores  = Fornecedor::where('nome', 'like', '%'.$query.'%')->orWhere('empresa', 'like', '%'.$query.'%')->get();
         $vendedores    = Vendedor::where('nome', 'like', '%'.$query.'%')->orWhere('empresa', 'like', '%'.$query.'%')->get();



         foreach ($clientes as $cliente) {
            $suggestions[] = array(
                                    "value"  => $cliente->nome." [".$cliente->empresa."]",
                                    "data"    => array(
                                                   'type' => 'Clientes ('.count( $clientes ).')',
                                                   'obj'  => json_encode( $cliente )
                                                )                          
                                );           
         }
         foreach ($fornecedores as $fornecedor) {
            $suggestions[] = array(
                                    "value"  => $fornecedor->nome." [".$fornecedor->empresa."]",
                                    "data"    => array(
                                                   'type' => 'Fornecedores ('.count($fornecedores).')'
                                                )                          
                                );           
         }
         foreach ($vendedores as $vendedor) {
            $suggestions[] = array(
                                    "value"  => $vendedor->nome." [".$vendedor->empresa."]",
                                    "data"    => array(
                                                   'type' => 'Vendedores ('.count($vendedores).')'
                                                )                          
                                );           
         }


         $costumers = array( 'suggestions' => $suggestions );   
      
         //$costumers = Cliente::all();
         return Response::json($costumers);
       //}
   }


    public function mini($id = 0)
    {
        $costumer = Cliente::find( $id );
        if( $costumer ){
            return View::make('clientes.panels.item', ['cliente'=>$costumer]);
        }else{
            return Response::json([ 'error' => 'true' ]);
        }
    }
}