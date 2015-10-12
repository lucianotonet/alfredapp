<?php

class PedidosController extends \BaseController {

   
	/**
	 * Display a listing of pedidos
	 *
	 * @return Response
	 */
	public function index()
	{

		$pedidos  = Pedido::all(); 

	  $produtos            = Produto::all();

	  $pedidos->emails     = Email::where('resource_name', 'like', 'pedido')->orderBy('id','DESC')->get();
	  
	  $pedidos->aguardando = Pedido::aguardando();
	  $pedidos->enviados   = Pedido::enviados();

	  // CONFERE STATUS
	  $pedidos->enviados->each(function($pedido)
	  {
		 // ARRUMA ISSO... PELAMORDED... (usa collections)
		 $email = Email::where( 'resource_name', 'like', 'pedido' )
					   ->where( 'resource_id', $pedido->id )
					   ->first();                   
		   
		 

	  });

	  //$pedidos->enviados   = array();
	  //$pedidos->aguardando = array();     

	  // $pedidos->enviados->each(function($pedido)
	  // {
	  //     //
	  // });
	  // $pedidos->aguardando->each(function($pedido)
	  // {
	  //     //
	  // });

	  if($pedidos){

		 foreach ($pedidos as $pedido) {
			//$pedido->cliente      = Cliente::find($pedido->cliente_id);
			$fornecedor   = Fornecedor::find($pedido->fornecedor_id);
			if( !$fornecedor){
			   //FORNECEDOR EXCLUÍDO
						   
			   $alert[] = [  'class'   => 'alert-warning',
					  'message'   => '<strong><i class="fa fa-warning"></i></strong> Há um problema com este pedido!<br/><strong>O Fornecedor não existe mais</strong><br/>Por favor corrija e salve novamente.' ];
			   Session::flash('alerts', $alert);
			   return Redirect::to( url('pedidos/'.$pedido->id.'/edit') ); 
			}
			$pedido->vendedor     = Vendedor::find($pedido->vendedor_id);                              
			
			// Formata data
			$pedido->data = date("d/m/y", strtotime($pedido->created_at));

			// Decode JSON
			$pedido->itens = json_decode($pedido->itens, true);    

			$pedido->total = number_format( $pedido->total, '2', ',', '.' );            
			

			// if( $email and $pedido->status == 2 ){ // se o status do pedido for 2 (enviado) e existir email com resource == pedido->id
			//    //$pedidos->enviados[] = $pedido;
			// }else{
			//    //$pedidos->aguardando[] = $pedido;
			// }
			
		 }

		   return View::make('pedidos.index', compact('pedidos', 'produtos', 'emails'));         
	  }else{
		 $alert[] = [  'class'   => 'alert-warning',
					  'message'   => 'Nenhum pedido ainda?' ];
		 Session::flash('alerts', $alert);
		 return Redirect::to( URL::previous() );         
	  }
	}
   

	/**
	 * Show the form for creating a new pedido
	 *
	 * @return Response
	 */
	public function create($id=0)
	{
		$cliente = Cliente::find($id);
		$fornecedores = Fornecedor::all();
		$produtos = Produto::all();
		$vendedores = Vendedor::all();
		$categories = Category::all();
		
		return View::make('pedidos.create', compact('cliente', 'produtos', 'fornecedores', 'vendedores', 'categories'));         
	  
	}

	/**
	 * Store a newly created pedido in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Pedido::$rules);
	  if ($validator->fails())
	  {

		 $alert[] = [   'class'   => 'alert-danger',
						'message'   => 'Erros de validação. Verifique!' ];
		 Session::flash('alerts', $alert);
		 return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
	  }
		   
	  $total = NULL;

	  // Tratamos os valores monetários com carinho ;)
	  foreach ($data['itens']['preco'] as $item => $preco) {
		 $data['itens']['preco'][$item] = FazMeRir::feio($preco);
	  }      

	  foreach ($data['itens']['subtotal'] as $item => $subtotal) {
		 $data['itens']['subtotal'][$item] = FazMeRir::feio($subtotal);
		 // Soma ao total
		 $total += $data['itens']['subtotal'][$item];
	  }
	  
	  //Reformata o total
	  $data['total'] = number_format($total,'2','.','');         

	  // Codifica PRODUTOS em JSON
	  $data['itens'] = json_encode( $data['itens'] );      
	  

	  //Status
	  // 1 = Salvo / Não enviado
	  // 2 = Enviado
	  $data['status'] = '1';

	  /**
	   *    CRIA NOVO PEDIDO
	   */
		$pedido = Pedido::create($data);

	  if( $pedido ){
		 
		 $alert[] = [   'class'   => 'alert-success',
				'message'   => 'O pedido foi fechado. Não esqueça de enviá-lo!' ];   
		 Session::flash('alerts', $alert);
		 
		 // GERA PDF
		 $this->gerarPdf($pedido->id);

		 $pedido = $pedido->id;
		   return Redirect::route('pedidos.show', compact('pedido'));         
	  }else{

		$alert[] = [   'class'   => 'alert-danger',
				'message'   => 'Erro: Não foi possível fechar o pedido.'];   
		 Session::flash('alerts', $alert);
		 return Redirect::back()->withErrors();
	  }


	}

	/**
	 * Display the specified pedido.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$pedido = Pedido::find($id);

	  if($pedido){
		 
		 $pedido->cliente     = Cliente::find($pedido->cliente_id);

		 if( !$pedido->cliente ){
			$alert[] = [   'class'   => 'alert-warning',
				'message'   =>'O Cliente deste pedido foi excluído ou alterado!<br/>Por favor corrija e salve novamente.' ];   
			Session::flash('alerts', $alert);
			return Redirect::to( url('pedidos/'.$pedido->id.'/edit') ); 

		 }


		 $pedido->fornecedor  = Fornecedor::find($pedido->fornecedor_id);        
		 if( !$pedido->fornecedor ){
					
			$alert[] = [   'class'   => 'alert-warning',
				'message'   =>'O Fornecedor não existe!<br/>Por favor corrija e salve novamente.' ];   
			Session::flash('alerts', $alert);
			return Redirect::to( url('pedidos/'.$pedido->id.'/edit') ); 

		 }


		 $pedido->vendedor    = Vendedor::find($pedido->vendedor_id);
		 if( !$pedido->fornecedor ){
					
			$alert[] = [   'class'   => 'alert-warning',
				'message'   =>'O Vendedor deste pedido foi excluído!<br/>Por favor corrija e salve novamente.' ];   
			Session::flash('alerts', $alert);
			return Redirect::to( url('pedidos/'.$pedido->id.'/edit') ); 

		 }
		 //$produtos          = Produto::all();

		 // Formata data
		 $pedido->entrega_data = date("d/m/Y", strtotime($pedido->entrega_data));
		 $pedido->data         = date("d/m/Y", strtotime($pedido->created_at));

		 // Decode JSON
		 $pedido->itens = json_decode($pedido->itens, true);

		 $itens = array();

		 for ( $i = 0; $i < count( $pedido->itens['qtd'] ); $i++ ) { // Loop no primeiro item pra pegar a quantidade de linhas
					  
			$itens[$i] = array(
								 'qtd'            => $pedido->itens['qtd'][$i],
								 'unidade'        => $pedido->itens['unidade'][$i],

								 'produto'        => Produto::find( $pedido->itens['produto_id'][$i] ), // Envia o produto inteiro                                     

								 'preco'          => number_format($pedido->itens['preco'][$i],'2',',','.'),
								 'subtotal'       => number_format($pedido->itens['subtotal'][$i],'2',',','.'),
			);                    
		 };      
		 $pedido->itens = $itens;      

		 $pedido->total = number_format($pedido->total,'2',',','.');                 


		// STATUS
		switch ($pedido->status) {            
			case 1:
				$pedido->statusTxt = '<i class="fa fa-edit"></i> Aberto';
				break;
			
			case 2:
				$pedido->statusTxt = '<i class="fa fa-check"></i> Enviado';
				break;
			
			case 3:
				$pedido->statusTxt = '<i class="icon-drawer"></i> Arquivado';
				break;
			
			default:
				$pedido->statusTxt = '<i class="fa fa-edit"></i> Aberto';
				break;
		}


		 // // SALVA O PDF
		 // $pdf = PDF::loadView( 'pedidos.email.preview', compact('pedido'))->save( 'pdf/pedido-'.$pedido->id.'.pdf' ); 
		 
		return View::make('pedidos.show', compact('pedido', 'cliente', 'fornecedor', 'vendedor', 'produtos', 'pedido_itens' ));

	  }else{

		 $alert[] = [   'class'   => 'alert-danger',
				'message'   => 'O pedido não existe.' ];   

		 Session::flash('alerts', $alert);

		 // Report::create([
		 //    'user_id'        => Auth::id(),
		 //    'status'         => 'warning',
		 //    'event'          => 'fail',
		 //    'title'          => 'Pedido não encontrado',
		 //    'resource_model' => 'Pedido',
		 //    'resource_id'    => $id,
		 //    'resource_obj'   => json_encode($pedido),
		 // ]);

		 //return Redirect::to( URL::previous() )->withErrors($alert);
		 return Redirect::to('pedidos');
	  }

	}


   /**
	* PDF (download)
	*
	* @param  int  $id
	* @return Response
	*/
   public function download($id)
   {
	  $pedido = Pedido::find($id);

	  if($pedido){

		 $pedido->cliente     = Cliente::find($pedido->cliente_id);
		 //$pedido->fornecedor  = Fornecedor::find($pedido->fornecedor_id);
		 $pedido->vendedor    = Vendedor::find($pedido->vendedor_id);
		 //$produtos          = Produto::all();

		 // Formata data
		 $pedido->entrega_data = date("d/m/Y", strtotime($pedido->entrega_data));
		 $pedido->data         = date("d/m/Y", strtotime($pedido->created_at));

		 // Decode JSON
		 $pedido->itens = json_decode($pedido->itens, true);

		 $itens = array();

		 for ( $i = 0; $i < count( $pedido->itens['qtd'] ); $i++ ) { // Loop no primeiro item pra pegar a quantidade de linhas
					  
			$itens[$i] = array(
								 'qtd'            => $pedido->itens['qtd'][$i],
								 'unidade'        => $pedido->itens['unidade'][$i],

								 'produto'        => Produto::find( $pedido->itens['produto_id'][$i] ), // Envia o produto inteiro                                     
								 'acabamento'     => Category::find( @$pedido->itens['produto_category_id'][$i] ), //                                      

								 'preco'          => number_format($pedido->itens['preco'][$i],'2',',','.'),
								 'subtotal'       => number_format($pedido->itens['subtotal'][$i],'2',',','.'),
			);                    
		 };      
		 $pedido->itens = $itens;      

		 $pedido->total = number_format($pedido->total,'2',',','.');

		 //$pdf = PDF::loadView( 'pedidos.email.preview', compact('pedido'));     
		 $pdf = PDF::loadView( 'pedidos.email.preview', compact('pedido'))->save( 'pdf/pedido-'.$pedido->id.'.pdf' );     
		 return $pdf->download( 'pedido-'.$pedido->id.'.pdf' );     
	  }
	  return false;
   }   


	/**
	 * Show the form for editing the specified pedido.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	  if($id){
		   $pedido = Pedido::find($id);
		 if($pedido){
			
			$pedido->cliente     = Cliente::find($pedido->cliente_id);    
			if( !$pedido->cliente ){
				
				$alert[] = [   'class'   => 'alert-warning',
					'message'   =>'<i class="fa fa-3x fa-warning pull-left"></i> O Cliente deste pedido foi excluído!<br/>Por favor corrija e salve novamente.' ];   
				Session::flash('alerts', $alert);
			
				$pedido->cliente = NULL;
			}        
			
			// $pedido->fornecedor  = Fornecedor::find($pedido->fornecedor_id);
			if(!$pedido->fornecedor){

				$alert[] = [   'class'   => 'alert-warning',
					'message'   =>'<i class="fa fa-4x fa-warning pull-left"></i>Atençao! Há um problema com o <strong>pedido nº'.$pedido->id.'</strong><br/>O Fornecedor deste pedido foi excluído ou alterado!<br/>Por favor informe outro e salve novamente.' ];   
				Session::flash('alerts', $alert);
			
			   $pedido->fornecedor = 0;
			}
			
			$pedido->vendedor    = Vendedor::find($pedido->vendedor_id);
			if(!$pedido->vendedor){
			   $pedido->vendedor = 0;
			}

			$fornecedores = Fornecedor::orderBy('nome')->get();
			$vendedores   = Vendedor::all();                        
			$produtos     = Produto::all();
			$categories   = Category::where('owner_type', 'Produto')->get();

			// Decode JSON
			$pedido->itens = json_decode($pedido->itens, true);

			$itens = $pedido->itens;
			$pedido_itens = array();

			for ( $i = 0; $i < count( end($itens) ); $i++ ) { // Loop no primeiro item pra pegar a quantidade de linhas
						 
			    $pedido_itens[$i] = array(
									'qtd'            => $itens['qtd'][$i],
									'unidade'        => $itens['unidade'][$i],

									'produto'        => Produto::find( $itens['produto_id'][$i] ), // Envia o produto inteiro                                     
									'acabamento'     => Category::find( @$itens['produto_category_id'][$i] ), // Envia a categoria inteira

									'preco'          => $itens['preco'][$i],
									'subtotal'       => $itens['subtotal'][$i],
			   );                    
			};
			$pedido->itens = $pedido_itens;
			return View::make('pedidos.edit', compact('pedido', 'produtos', 'fornecedores', 'vendedores', 'categories'));         

		 }else{
		   
			$alert[] = [   'class'   => 'alert-warning',
							'message'   => 'Não foi possível encontrar o pedido solicitado.' ];   
			Session::flash('alerts', $alert);
			return Redirect::to( URL::previous() );         
		 }
	  }else{         
		
		$alert[] = [   'class'   => 'alert-warning',
				'message'   => 'Não foi possível encontrar o pedido solicitado.' ];   
		Session::flash('alerts', $alert);
		return Redirect::to('pedidos');    

	  }

		return View::make('pedidos.edit', compact('pedido'));
	}

	/**
	 * Update the specified pedido in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
   public function update($id)
   {      

	  $pedido = Pedido::find($id);
	  
	  $validator = Validator::make($data = Input::all(), Pedido::$rules, Pedido::$messages);      
	  

	  // echo "<pre>";
	  // print_r($data);
	  // echo "</pre>";
	  // exit;  


	  if ($validator->fails() )
	  {         
		 $alert[] = [   'class'   => 'alert-danger',
				'message'   => 'Erros de validação. Verifique!' ];  

		 Session::flash('alerts', $alert);
		 return Redirect::back()->withErrors($validator)->withInput($data);
	  }
	  
	  $fornecedor = Fornecedor::find( $data['fornecedor_id'] );     

	  if( !$fornecedor ){
		 // redirect to edit
		 $alert[] = [   'class'   => 'alert-warning',
				'message'   => 'O Fornecedor não existe!<br/>Por favor corrija e salve novamente!' ];  
		 Session::flash('alerts', $alert);
		 return Redirect::to( url('pedidos/'.$pedido->id.'/edit') );          
	  };

	  $total = NULL;

	  // Tratamos os valores monetários com carinho ;)
	  foreach (@$data['itens']['preco'] as $item => $preco) {
		 $data['itens']['preco'][$item] = FazMeRir::feio($preco);
	  }      

	  foreach ($data['itens']['subtotal'] as $item => $subtotal) {
		 $data['itens']['subtotal'][$item] = FazMeRir::feio($subtotal);
		 // Soma ao total
		 $total += $data['itens']['subtotal'][$item];
	  }
	  
	  //Reformata o total
	  $data['total'] = number_format($total,'2','.','');         

	  // Codifica PRODUTOS em JSON
	  $data['itens'] = json_encode( $data['itens'] );      
	  

	  //Status
	  // 1 = Salvo / Não enviado
	  // 2 = Enviado
	  $data['status'] = '1';

	  

	  $email         = Email::where('resource_name', 'like', 'pedido')->where('resource_id', $id)->first();
	  if($email){
		 $email->status = 'warning';
		 $email->save();
	  }




	  /**
	   *    ATUALIZA O PEDIDO
	   */
	  $pedido->update($data);
  
	  $alert[] = [   'class'   => 'alert-success',
				'message'   => 'Pedido atualizado! Você terá que enviá-lo novamente.' ];     
	  Session::flash('alerts', $alert);

	  // GERA PDF
	  $this->gerarPdf($pedido->id);

		return Redirect::route('pedidos.index');
	}

	/**
	 * Remove the specified pedido from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

	  
		$pedido = Pedido::destroy($id);
	  if($pedido){

		 $email         = Email::where('resource_name', 'pedido')->where('resource_id', $id)->first();
		 if( $email ){
		   $email->status = 'danger';
		   $email->save();
		 }

	
		  $alert[] = [   'class'   => 'alert-warning',
				'message'   =>  'O pedido foi excluído definitivamente. Agora não adianta chorar!' ];  
		 Session::flash('alerts', $alert);
		return Redirect::route('pedidos.index');
	  }else{         
		 $alert[] = [   'class'   => 'alert-danger',
				'message'   =>  'Opa, algo errado. Não deu para excluir o pedido.' ];  
		 Session::flash('alerts', $alert);
		 return Redirect::back()->withErrors();         
	  }
	}

   /**
	* Seleciona o destinatário para enviar o pedido via e-mail    
	*
	* @param  string  $email
	* @return Response
	*/
   public function sendTo($id)
   {
	  $pedido       = $id;
	  $fornecedores = Fornecedor::all();
	  $vendedores   = Vendedor::all();
	  $clientes     = Cliente::all();
	  return View::make('pedidos.enviar', compact('pedido','fornecedores', 'vendedores', 'clientes'));
   }



   /**
	* Envia o pedido via e-mail
	* para o fornecedor ou e-mail selecionado
	*
	* @param  string  $email
	* @return Response
	*/
   public function sendNow()
   {
	  $data                = Input::all();
	 
	  $pedido              = Pedido::find($data['id']);      
	  $pedido->cliente     = Cliente::find($pedido->cliente_id);
	  $pedido->fornecedor  = Fornecedor::find($pedido->fornecedor_id);
	  $pedido->vendedor    = Vendedor::find($pedido->vendedor_id);
	  //$produtos            = Produto::all();

	  // Formata data
	  $pedido->entrega_data = date("d/m/Y", strtotime($pedido->entrega_data));
	  $pedido->data         = date("d/m/Y", strtotime($pedido->created_at));

	  // Decode JSON
	  $pedido->itens = json_decode($pedido->itens, true);

	  $itens = array();

	  for ( $i = 0; $i < count( $pedido->itens['qtd'] ); $i++ ) { // Loop no primeiro item pra pegar a quantidade de linhas
				   
		 $itens[$i] = array(
							  'qtd'            => $pedido->itens['qtd'][$i],
							  'unidade'        => $pedido->itens['unidade'][$i],

							  'produto'        => Produto::find( $pedido->itens['produto_id'][$i] ), // Envia o produto inteiro                                     

							  'preco'          => number_format($pedido->itens['preco'][$i],'2',',','.'),
							  'subtotal'       => number_format($pedido->itens['subtotal'][$i],'2',',','.'),
		 );                    
	  };      
	  $pedido->itens = $itens;     
	  $pedido->total = number_format($pedido->total,'2',',','.');

	  //return View::make('pedidos.email.index', compact('pedido','fornecedores'));
	  
	  // Change Pedido Status
	  $p         = Pedido::find($data['id']);
	  $p->status = '2';
	  $p->save();
	  
	  $data['fornecedor'] = ($pedido->fornecedor->empresa) ? $pedido->fornecedor->empresa : @$pedido->fornecedor->nome;
	  $data['pedido']     = $pedido;
	  

	  //SEND THE MAIL
	  Mail::send('pedidos.email.preview', compact('pedido','fornecedores'), function($message)use($data){         

		 //$message->from('contato@lucianotonet.com', 'L. Tonet');
		 $message->from('olmar@basaltosegranitos.com.br', 'Olmar Primieri');
		 $message->to( $data['to'] );

		 if( isset($data['cc']) and !empty($data['cc'])) {
			$message->cc( $data['cc'] );
			//append to report record
			$reportMsg = ' com CC: <'.$data['cc'].'>';
		 }

		 $message->subject('NOVO PEDIDO - Olmar Primieri ('.$data['fornecedor'].')');

		 // Log this
		 // Report::create([
		 //       'user_id'        => Auth::id(),
		 //       'status'         => 'success',
		 //       'event'          => 'sended',
		 //       'title'          => 'Pedido enviado para <'. $data['to'] .'>'.@$reportMsg,
		 //       'resource_model' => 'Pedido',
		 //       'resource_id'    => $data['pedido']->id,
		 //       'resource_obj'   => json_encode($data['pedido']),
		 //    ]);


	  });



	  // MAIL TO CLIENTe (cc)
	  if( isset($data['to_client']) and !empty( $data['to_client'] ) ){
		 $data['cliente_nome'] = $pedido->nome;
		 Mail::send('pedidos.email.preview', compact('pedido','fornecedores'), function($message)use($data)
		 {
			 $message->to( $data['to_client'] , $data['cliente_nome'] )->subject('SEU PEDIDO - Olmar Primieri');

			// Report::create([
			//    'user_id'        => Auth::id(),
			//    'status'         => 'success',
			//    'event'          => 'sended',
			//    'title'          => 'Pedido enviado para "'. $data['cliente_nome'] . ' <'.$data['to_client'] .'>"',
			//    'resource_model' => 'Pedido',
			//    'resource_id'    => $pedido->id,
			//    'resource_obj'   => json_encode($pedido),
			// ]);


		 });
	  }


	  /**
	   *    PDF VIA EMAIL
	   */
	  define('PEDIDOS_DIR', public_path('uploads/pedidos')); // I define this in a constants.php file

	  if (!is_dir(PEDIDOS_DIR)){
		  mkdir(PEDIDOS_DIR, 0755, true);
	  }

	  $outputName = 'PEDIDO-'.$pedido->id;
	  $pdfPath = PEDIDOS_DIR.'/'.$outputName.'.pdf';
	  File::put($pdfPath, PDF::load($view, 'A4', 'portrait')->output());

	  Mail::send('pedidos.email', $data, function($message) use ($pdfPath){
		  //$message->from('us@example.com', 'Laravel');
		  $message->to('contato@lucianotonet.com');
		  $message->attach($pdfPath);
	  });

	  // $alert = array(                     
	  //                'alert-danger' => 'Opa, algo errado. Não deu para enviar o pedido.'
	  //             );
	  // Session::flash('alerts', $alert);
	  // return Redirect::route('pedidos.index');

	  // }else{
			$alert[] = [   'class'   => 'alert-success',
				'message'   =>  'O pedido foi enviado! Note que se você alterar este pedido novamente, o status mudará para <strong>não enviado</strong>.' ];  
			Session::flash('alerts', $alert);
			return Redirect::route('pedidos.index');
	  // }
   }


   /**
	* Previsualização do pedido    
	*
	* @param  string  $id
	* @return Response
	*/
   public function preview($id)
   {     
	  $pedido              = Pedido::find($id);
	  $pedido->cliente     = Cliente::find($pedido->cliente_id);
	  
	  $fornecedor  = Fornecedor::find($pedido->fornecedor_id);
	  if( !$fornecedor ){
		 // redirect to edit
		  $alert[] = [   'class'   => 'alert-warning',
				'message'   =>  'O Fornecedor não existe!<br/>Por favor corrija e salve novamente.' ];  
		 Session::flash('alerts', $alert);
		 return Redirect::to( url('pedidos/'.$pedido->id.'/edit') ); 

	  }
	  $pedido->vendedor    = Vendedor::find($pedido->vendedor_id);
	  if( count( $pedido->vendedor ) < 1 ){
			$alert[] = [   'class'   => 'alert-warning',
				'message'            => 'O VENDEDOR para este pedido foi excluído!<br/>Por favor corrija e tente novamente.' ];  
			Session::flash('alerts', $alert);
			return Redirect::to( url('pedidos/'.$pedido->id.'/edit') ); 
	  }
	  $pedido->vendedorArr = Vendedor::find($pedido->vendedor_id)->toArray();

	  //$produtos          = Produto::all();

	  // Formata data
	  $pedido->entrega_data = date("d/m/Y", strtotime($pedido->entrega_data));
	  $pedido->data         = date("d/m/Y", strtotime($pedido->created_at));

	  // Decode JSON
	  $pedido->itens = json_decode($pedido->itens, true);

	  $itens = array();

	 
	  for ( $i = 0; $i < count( $pedido->itens['qtd'] ); $i++ ) { // Loop no primeiro item pra pegar a quantidade de linhas
				   
		 $itens[$i] = array(
							  'qtd'            => $pedido->itens['qtd'][$i],
							  'unidade'        => $pedido->itens['unidade'][$i],

							  'produto'        => Produto::find( $pedido->itens['produto_id'][$i] ), // Envia o produto inteiro                                     
							  'acabamento'     => Category::find( @$pedido->itens['produto_category_id'][$i] ), //                                      

							  'preco'          => number_format($pedido->itens['preco'][$i],'2',',','.'),
							  'subtotal'       => number_format($pedido->itens['subtotal'][$i],'2',',','.'),
		 );                    
	  };      
	  $pedido->itens = $itens;      

	  $pedido->total = number_format($pedido->total,'2',',','.');

	  // echo "<pre>";
	  // print_r($pedido->itens);
	  // echo "</pre>";
	  // exit;

	  
	  $pdf = PDF::loadView( 'pedidos.email.preview', compact('pedido'))->setPaper('a4')->setOrientation('portrait')->setWarnings(false)->save( 'pdf/pedido-'.$pedido->id.'.pdf' );  
	  //   return $pdf->stream(); 
	  

	  return View::make('pedidos.email.preview', compact('pedido'));      
   }


	/**
	* PDF (stream)    
	*
	* @param  string  $id
	* @return Response
	*/
   public function pdf($id)
   {     
	  $pedido              = Pedido::find($id);
	  $pedido->cliente     = Cliente::find($pedido->cliente_id);
	  //$pedido->fornecedor  = Fornecedor::find($pedido->fornecedor_id);
	  $pedido->vendedor    = Vendedor::find($pedido->vendedor_id);
	  //$produtos          = Produto::all();

	  // Formata data
	  $pedido->entrega_data = date("d/m/Y", strtotime($pedido->entrega_data));
	  $pedido->data         = date("d/m/Y", strtotime($pedido->created_at));

	  // Decode JSON
	  $pedido->itens = json_decode($pedido->itens, true);

	  $itens = array();

	  for ( $i = 0; $i < count( $pedido->itens['qtd'] ); $i++ ) { // Loop no primeiro item pra pegar a quantidade de linhas
				   
		 $itens[$i] = array(
							  'qtd'            => $pedido->itens['qtd'][$i],
							  'unidade'        => $pedido->itens['unidade'][$i],

							  'produto'        => Produto::find( $pedido->itens['produto_id'][$i] ), // Envia o produto inteiro                                     

							  'preco'          => number_format($pedido->itens['preco'][$i],'2',',','.'),
							  'subtotal'       => number_format($pedido->itens['subtotal'][$i],'2',',','.'),
		 );                    
	  };      
	  $pedido->itens = $itens;      

	  $pedido->total = number_format($pedido->total,'2',',','.');

	  
		 $pdf = PDF::loadView(  'pedidos.email.preview', compact('pedido'));                  
		 return $pdf->stream(); 
   }


  /**
	* PDF (SÓ GERA O ARQUIVO)    
	*
	* @param  string  $id
	* @return TRUE ou FALSE
	*/
   public function gerarPdf($id)
   {     
	  $pedido              = Pedido::find($id);
	  $pedido->cliente     = Cliente::find($pedido->cliente_id);
	  //$pedido->fornecedor  = Fornecedor::find($pedido->fornecedor_id);
	  $pedido->vendedor    = Vendedor::find($pedido->vendedor_id);
	  //$produtos          = Produto::all();

	  // Formata data
	  $pedido->entrega_data = date("d/m/Y", strtotime($pedido->entrega_data));
	  $pedido->data         = date("d/m/Y", strtotime($pedido->created_at));

	  // Decode JSON
	  $pedido->itens = json_decode($pedido->itens, true);

	  $itens = array();

	  for ( $i = 0; $i < count( $pedido->itens['qtd'] ); $i++ ) { // Loop no primeiro item pra pegar a quantidade de linhas
				   
		 $itens[$i] = array(
							  'qtd'            => $pedido->itens['qtd'][$i],
							  'unidade'        => $pedido->itens['unidade'][$i],

							  'produto'        => Produto::find( $pedido->itens['produto_id'][$i] ), // Envia o produto inteiro                                     

							  'preco'          => number_format($pedido->itens['preco'][$i],'2',',','.'),
							  'subtotal'       => number_format($pedido->itens['subtotal'][$i],'2',',','.'),
		 );                    
	  };      
	  $pedido->itens = $itens;      

	  $pedido->total = number_format($pedido->total,'2',',','.');

			   // print_r($pedido);
			   // exit;
		 // SALVA O PDF
		 $pdf = PDF::loadView( 'pedidos.email.preview', compact('pedido'))->setPaper('a4')->setOrientation('portrait')->setWarnings(false)->save( 'pdf/pedido-'.$pedido->id.'.pdf' );
		 return asset('pdf/pedido-'.$pedido->id.'.pdf'); 
   }


   /**
	*    IMPRESSÃO      
	*/
   public function printPreview($id)
   {     
	  $pedido              = Pedido::find($id);
	  $pedido->cliente     = Cliente::find($pedido->cliente_id);
	  //$pedido->fornecedor  = Fornecedor::find($pedido->fornecedor_id);
	  $pedido->vendedor    = Vendedor::find($pedido->vendedor_id);
	  //$produtos          = Produto::all();

	  // Formata data
	  $pedido->entrega_data = date("d/m/Y", strtotime($pedido->entrega_data));
	  $pedido->data         = date("d/m/Y", strtotime($pedido->created_at));

	  // Decode JSON
	  $pedido->itens = json_decode($pedido->itens, true);

	  $itens = array();

	  for ( $i = 0; $i < count( $pedido->itens['qtd'] ); $i++ ) { // Loop no primeiro item pra pegar a quantidade de linhas
				   
		 $itens[$i] = array(
							  'qtd'            => $pedido->itens['qtd'][$i],
							  'unidade'        => $pedido->itens['unidade'][$i],

							  'produto'        => Produto::find( $pedido->itens['produto_id'][$i] ), // Envia o produto inteiro                                     

							  'preco'          => number_format($pedido->itens['preco'][$i],'2',',','.'),
							  'subtotal'       => number_format($pedido->itens['subtotal'][$i],'2',',','.'),
		 );                    
	  };      
	  $pedido->itens = $itens;      
	  $pedido->total = number_format($pedido->total,'2',',','.');      

	  return View::make('pedidos.print', compact('pedido'));      
   }




}