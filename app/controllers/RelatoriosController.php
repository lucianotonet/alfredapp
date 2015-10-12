<?php
use Carbon\Carbon as Carbon;
class RelatoriosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /relatorios
	 *
	 * @return Response
	 */
	public function index()
	{

		// $relatorios = new CreateRelatoriosTable;
		// $relatorios->down();
		// $relatorios->up();


		$relatorios = Relatorio::orderBy('updated_at','DESC')->get();	

		foreach ($relatorios as $relatorio) {
			switch ($relatorio->type) {
				case 'despesas':
					$relatorio->type = "despesas";	
					$relatorios->despesas[] = $relatorio;
					break;
				
				case 'conversas':
					$relatorio->type = "conversas";
					$relatorios->conversas[] = $relatorio;
					break;
				
				default:
					$relatorio->type;
					break;
			}			
		}	
	
		return View::make('relatorios.index', compact('relatorios'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /relatorios/create
	 *
	 * @return Response
	 */
	public function create($resource_name = NULL)
	{
		// STATUS			
		$status = $this->status( $resource_name );		

		// OLD INPUTS
		Input::flash();	

		// TIPO DE RELATÓRIO
		switch ($resource_name) {
			/*
				DESPESAS
			*/
			case 'despesas':
			
				/*
					FILTROS DE BUSCA
				*/	

				// GET Filters
				if( @$_GET['cidade'] || @$_GET['status'] || @$_GET['from'] || @$_GET['to'] ){
					// Se for pesquisa, carrega todas despesas e depois filtra
					$despesas = Despesa::all();

					// CIDADE
					$despesas = $despesas->filter(function($despesa){
						if( !isset($_GET['cidade']) || @$_GET['cidade'] == "all" || @$_GET['cidade'] == $despesa->cidade  ){
							return $despesa;								
						}		
					});	
							
				
					// STATUS
					$despesas = $despesas->filter(function($despesa){
						if( @$_GET['status'] == 'enviadas' ){
							if( $despesa->relatorio_id >= 1 ){
								return $despesa;								
							}								
						}else if( @$_GET['status'] == 'nao-enviadas' ){
							if( $despesa->relatorio_id < 1 ){
								return $despesa;								
							}								
						}else{
							return $despesa;						
						}
					});	
						
					// DATA (DE)
					$despesas = $despesas->filter(function($despesa){
						if( isset( $_GET['from'] ) ){
							if( $despesa->created_at >= $_GET['from'].' 00:00:00' ){
								return $despesa;								
							}		
						}
					});	

					// DATA (ATÉ)
					$despesas = $despesas->filter(function($despesa){
						if( isset( $_GET['to'] ) ){
							if( $despesa->created_at <= $_GET['to'].' 23:59:59' ){
								return $despesa;								
							}		
						}
					});	

				}else{	
					// Senão, carrega só as "NÃO ENVIADAS"
					$despesas = Despesa::where('relatorio_id', '<', 1)->get();					
				}			

				// Total de despesas
				$despesas->total = 0;
				foreach ($despesas as $despesa) {
					$despesas->total += $despesa->valor;
					// Fomata R$ despesas
					$despesa->valor  = number_format( $despesa->valor, 2, ',', '.' ); 
				};
				// Fomata R$ Total
				$despesas->total = number_format( $despesas->total, 2, ',', '.' );



				return View::make('relatorios.despesas.create', array( 'despesas' => $despesas ) );
				break;
			

			/*
				CONVERSAS
			*/
			case 'conversas':				
				/* 
					FILTROS DE BUSCA
				*/
				
				// CLIENTES (que tem conversas)
				$clientes 		= Cliente::has('conversas', '>', 0)->with('conversas')->get();	
				if( !Conversa::count() ){
					// Alert
					$alert[] = array(                     
	 							'class'		=>	'alert-warning',
	                            'message'   => '<strong><i class="fa fa-warning"></i></strong> Ainda não há nenhuma conversa cadastrada no sistema =(',	                           
	                        );
					Session::flash('alerts', $alert);	
					return Redirect::to( URL::previous() );   
				}

				$fieldClientes 	= array( 'all' => 'Todos' );
				foreach ($clientes as $cliente) {
					$fieldClientes[ $cliente->id ] = $cliente->nome;			
				}
				
				// DATE RANGE
				$fieldDate['min'] 	= Conversa::orderBy('created_at','ASC')->select('created_at')->first();
				$fieldDate['min'] 	= date( 'Y-m-d', strtotime( $fieldDate['min']->created_at ) );
				$fieldDate['max'] 	= Conversa::orderBy('created_at','DESC')->select('created_at')->first();
				$fieldDate['max'] 	= date( 'Y-m-d', strtotime( $fieldDate['max']->created_at ) );
				
			
				// FILTERS
				$filters = array(
				            'clientes'  => $fieldClientes,
				            'status'    => array( 	
				                            'all'			=>'Todas', 
											'enviadas'		=>'Enviadas',
											'nao-enviadas'	=>'Não enviadas'
										),
				            'from'		=> array(

				                            'min'	=> $fieldDate['min'],
				                            'max'	=> $fieldDate['max'],
				                        ),		            
				            'to'		=> array(
				                            'min'	=> $fieldDate['min'],
				                            'max'	=> $fieldDate['max'],
				                        )
				        );
				

				
				/*
					FILTROS DE BUSCA
				*/	

					// GET Filters
					if( @$_GET['cliente'] || @$_GET['status'] || @$_GET['from'] || @$_GET['to'] ){
						// Se for pesquisa, carrega todas conversas e depois filtra
						$conversas = Conversa::all();

						// CLIENTE
						$conversas = $conversas->filter(function($conversa){
							if( !isset($_GET['cliente']) || @$_GET['cliente'] == "all" || @$_GET['cliente'] == $conversa->cliente_id  ){
								return $conversa;								
							}		
						});	
								
					
						// STATUS
						$conversas = $conversas->filter(function($conversa){
							if( @$_GET['status'] == 'enviadas' ){
								if( $conversa->relatorio_id >= 1 ){
									return $conversa;								
								}								
							}else if( @$_GET['status'] == 'nao-enviadas' ){
								if( $conversa->relatorio_id < 1 ){
									return $conversa;								
								}								
							}else{
								return $conversa;						
							}
						});	
							
						// DATA (DE)
						$conversas = $conversas->filter(function($conversa){
							if( isset( $_GET['from'] ) ){
								if( $conversa->created_at >= $_GET['from'].' 00:00:00' ){
									return $conversa;								
								}		
							}
						});	

						// DATA (ATÉ)
						$conversas = $conversas->filter(function($conversa){
							if( isset( $_GET['to'] ) ){
								if( $conversa->created_at <= $_GET['to'].' 23:59:59' ){
									return $conversa;								
								}		
							}
						});	

					}else{	
						// Senão, carrega só as "NÃO ENVIADAS"
						$conversas = Conversa::where('relatorio_id', '<', 1)->get();					
					};		

					// Total de conversas encontradas
					$total = count($conversas);				

				
					


					//Agrupa por cliente
					$groups  			= $conversas->groupBy('cliente_id');
					$clientes_conversas = array();
					
					foreach($groups as $cliente_id => $conversas){

						$client = Cliente::find( $cliente_id );
						if( count( $client ) ){
							
							$client->conversas = $conversas;
							$clientes_conversas[] = $client;
						}
							
					};
					
					$search_results = $clientes_conversas;
					
					// echo "<pre>";
					// print_r( $search_results );
					// echo "</pre>";
					// exit;

					// Message Text
					
					if ( @$_GET['status'] ){
						if( $total == 1 ){
							$message = "Uma conversa encontrada";
						}else if( $total > 1 ){
							$message = $total . " conversas encontradas";
						}else{
							$message = "Nenhuma conversa encontrada";
						}
					}else{
						$message = "Você tem ".$status['nao_enviadas']." conversas não enviadas.";
					};



				return View::make( 'relatorios.conversas.create', array( 'status' => $status, 'filters' => $filters, 'search_results' => $search_results, 'message' => $message, 'conversas' => $conversas, 'relatorio' => new Relatorio, 'clientes' => $clientes ) );				
				break;
			
			default:
				//  se não informado um RESOURCE_NAME, a view CREATE padrão é chamada
				return View::make('relatorios.create');
				break;
			
		}			
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /relatorios
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Relatorio::$rules);

		// Cria o novo relatório
		$relatorio 		 = new Relatorio;
		if( isset( $data['type'] ) ){
			$relatorio->type = $data['type'];		
		}
			
		// Salva o relatório
		$relatorio->save();


		switch ( $data['type'] ) {
			case 'despesas':

				$despesas = Despesa::where('relatorio_id','<', 1)->get();
				$despesas_ids = array();

				// MARCA DESPESAS COM O ID DO RELATÓRIO ( LAST REPORT )
				foreach ($despesas as $despesa) {
					$despesas_ids[] = $despesa->id;

					$despesa->relatorio_id = $relatorio->id;
					$despesa->save();
				};

				// ADICIONA OS IDS DAS CONVERSAS NO RELATÓRIO
				$relatorio->ids  = implode( ",", $despesas_ids );

				// Alert
				$alert[] = array(                     
							'class' 	=> 'alert-success',
                            'message'   => '<strong><i class="fa fa-check"></i></strong> Relatório gerado com sucesso!',
                            // 'links'     =>  array(
                            //                     'btn-success' => array(                                                                  
                            //                                            'text'   => 'Ver relatório',
                            //                                            'link'   => url('relatorios', $relatorio->id)
                            //                                         )
                            //                )
				        );
				Session::flash('alerts', $alert);	

				break;

			case 'conversas':
				// AUTOMÁTICO
				if( @$data['auto'] ){
					// Marca as conversas com o ID do relatório criado
					$conversas = Conversa::where('relatorio_id','<', '1')->get();
					foreach ($conversas as $conversa) {
						$conversa->relatorio_id = $relatorio->id;
						$conversa->save();
					}
				// MANUAL
				}else{
				
					if( isset($data['conversas_ids']) and is_array($data['conversas_ids']) ){
						
						// ADICIONA OS IDS DAS CONVERSAS NO RELATÓRIO
						$relatorio->ids  = implode( ",", $data['conversas_ids'] );

						// MARCA AS CONVERSAS COM O ID DO ÚLTIMO RELATÓRIO (este)
						foreach ($data['conversas_ids'] as $conversa) {

							$conversa = Conversa::find( $conversa );
							$conversa->relatorio_id = $relatorio->id;
							$conversa->save();
						
						}
					}		

				}
				
				// Alert
				$alert[] = array(                     
 							'class'	=>	'alert-success',
                            'message'   => '<strong><i class="fa fa-check"></i></strong> Relatório de conversas gerado com sucesso!',
                            'links'     =>  array(
                                                'btn-success' => array(                                                                  
                                                                       'text'   => 'Ver relatório',
                                                                       'link'   => url('relatorios', $relatorio->id)
                                                                    )
                                            )
                        );
				Session::flash('alerts', $alert);	
				break;

			default:

				break;
		}				

		// Salva o relatório de novo
		$relatorio->save();		
		return Redirect::to( url('relatorios/'.$relatorio->id) );    
		
	}

	/**
	 * Display the specified relatorio.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		// $pdf_folder = Config::get('settings.user_id');
		// print_r($pdf_folder);
		// exit;

		$relatorio = Relatorio::find( $id );

		if( !$relatorio ){
			// Alert
			$alert[] = array(                     
					'class'		=> 'alert-warning',
                    'message'   => '<strong><i class="fa fa-warning"></i></strong> Relatório não encontrado'
                );
			Session::flash('alerts', $alert);	
			
			return Redirect::to( URL::previous() );   

		}


		switch ( $relatorio->type ) {
			case 'despesas':

				$despesas_ids = explode(',', $relatorio->ids);
    			$despesas 	  = Despesa::whereIn('id', $despesas_ids )->get();
    			$relatorio->despesas = $despesas;

				// Total de despesas
				$total = 0;
				foreach ($relatorio->despesas as $despesa) {
					$total += $despesa->valor;
					// Fomata R$ despesas
					$despesa->valor  = number_format( $despesa->valor, 2, ',', '.' ); 
				};
				// Fomata R$ Total
				$relatorio->total = number_format( $total, 2, ',', '.' );


				/**
				 * GERA O PDF
				 */
				//$pdf = $this->gerarPdf( $relatorio );

				//$pdf = PDF::loadView( 'relatorios.'.$relatorio->type.'.pdf', compact('relatorio'))->setPaper('a4')->setOrientation('portrait')->setWarnings(false)->save( 'pdf/relatorios/relatorio-'.$relatorio->id.'_'.$relatorio->type.'.pdf' );

				
				// TESTE PARA PDF
				//return View::make('relatorios.despesas.pdf', compact('relatorio'));
				//return View::make('relatorios.despesas.print', compact('relatorio'));
				return View::make('relatorios.despesas.show', compact('relatorio'));
				break;
			
			case 'conversas':

				// //Agrupa por cliente
				// $groups  			= $relatorio->conversas->groupBy('cliente_id');
				// $clientes_conversas = array();
				
				// foreach($groups as $cliente_id => $conversas){

				// 	$client = Cliente::find( $cliente_id );
				// 	if( count( $client ) ){
						
				// 		$client->conversas = $conversas;
				// 		$clientes_conversas[] = $client;
				// 	}
						
				// };
				
				// $relatorio->conversas = $clientes_conversas;


				// echo "<pre>";
				// print_r($relatorio->conversas);
				// echo "</pre>";
				// exit;


				return View::make('relatorios.conversas.show', compact('relatorio'));		
				break;
			
			default:
				return View::make('relatorios.show', compact('relatorio'));		
				break;

		}
		return View::make('relatorios.show', compact('relatorio'));		

	}

	/**
	 * Show the form for editing the specified relatorio.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $relatorio = Relatorio::find($id);
        if( $relatorio ){
        	switch ($relatorio->type) {
        		case 'despesas':
        			
        			$despesas_ids = explode(',', $relatorio->ids);

        			$despesas = Despesa::whereIn('id', $despesas_ids )->get();
					
					$total = 0;
        			foreach ($despesas as $despesa) {        		        				
						$total += $despesa->valor;        				
        			}        			//$relatorio->despesas = $despesas;
        			$total = number_format( $total, 2, ',', '.' );        			

        			$relatorio->despesas = $despesas;

        			// echo "<pre>";
        			// print_r($relatorio);
        			// echo "</pre>";
        			// exit;
        			break;
        		
        		case 'conversas':
        			# code...
        			break;
        		
        		default:
        			# code...
        			break;
        	}
        }
		return View::make('relatorios.edit', compact('relatorio', 'total'));
	}

	/**
	 * Update the specified relatorio in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$relatorio = Relatorio::find($id);

		$validator = Validator::make($data = Input::all(), Relatorio::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		switch ( $data['type'] ) {
			case 'despesas':
				
				// ADICIONA OS IDS DAS CONVERSAS NO RELATÓRIO
				$relatorio->ids  = $data['ids'];

				// ALTERA O STATUS
				$relatorio->status = 0;				

				// MARCA DESPESAS COM O ID DESTE RELATÓRIO (LAST REPORT)
				$despesas_ids   = explode( ',', $relatorio->ids );				
				$despesas 		= Despesa::whereIn( 'id', $despesas_ids )->update( array( 'relatorio_id' => $relatorio->id ) );

				//echo "<pre>"; print_r( $despesas ); echo "</pre>"; exit;

				// Alert
				$alert[] = array(                     
							'class' 	=> 'alert-success',
                            'message'   => '<strong><i class="fa fa-check"></i></strong> Relatório atualizado!<br/><strong>'.$despesas.'</strong> Despesas marcadas como reportadas!',
                            'links'     =>  array(
                                                'btn-success' => array(                                                                  
                                                                       'text'   => 'Ver relatório',
                                                                       'link'   => url('relatorios', $relatorio->id)
                                                                    )
                                            )
				        );				
				Session::flash('alerts', $alert);	

				break;

			case "conversas":

				break;

			default:

				break;

		}

		$relatorio->update($data);

		return Redirect::route('relatorios.index');
	}

	/**
	 * Remove the specified relatorio from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Relatorio::destroy($id);

		return Redirect::route('relatorios.index');
	}

	/**
    * PDF (stream)    
    *
    * @param  string  $id
    * @return Response
    */
	public function downloadpdf($id)
	{     
		// $relatorio           = Relatorio::find($id);	

		// $pdf = $this->gerarPdf( $relatorio->id );

		// // $pdf = PDF::loadView(  'relatorios.'.$relatorio->type.'.pdf', compact('relatorio'))->setPaper('a4')->setOrientation('portrait')->setWarnings(false)->save( 'pdf/relatorios/relatorio-'.$relatorio->id.'_'.$relatorio->type.'.pdf');                  
		// return $pdf->download();
	}

	/**
    * PDF (stream)    
    *
    * @param  string  $id
    * @return Response
    */
	public function streampdf($id)
	{     
		$relatorio           = Relatorio::find($id);	

		if( !$relatorio ){
			// Alert
			$alert[] = array(                     
						'class' 	=> 'alert-danger',
                        'message'   => '<strong><i class="fa fa-warning"></i></strong> o relatório não existe!',                        
			        );				
			Session::flash('alerts', $alert);

			if( URL::previous() ) 	return Redirect::to( URL::previous() );
			else 					return Redirect::to( 'relatorios' );
		}

		switch ( $relatorio->type ) {
			case 'despesas':

				// Total de despesas
				$total = 0;
				foreach ( $relatorio->get_despesas() as $despesa) {
					$total += $despesa->valor;
					// Fomata R$ despesas
					$despesa->valor  = number_format( $despesa->valor, 2, ',', '.' ); 
				};
				// Fomata R$ Total
				$relatorio->total = number_format( $total, 2, ',', '.' );

				//$view = 'relatorios.'.$relatorio->type.'.pdf';
				$pdf_view = 'relatorios.despesas.print';
				$pdf_file = 'pdf/relatorios/relatorio-'.$relatorio->id.'_'.$relatorio->type.'.pdf';

				break;
			
			case 'conversas':
				
				$relatorio->conversas = Conversa::whereIn('relatorio_id', explode(',', $relatorio->ids) )->get();				
				break;
			
			default:
				return "???";		
				break;

		}

		//$pdf = $this->gerarPdf( $relatorio->id );

		$pdf = App::make('dompdf');

		if( !is_file( asset( $pdf_file ) ) ){		
			$pdf = $pdf->loadView(  $pdf_view , compact('relatorio'))->setPaper('a4')->setOrientation('portrait')->setWarnings(false)->save( $pdf_file );            					
			echo "PDF gerado com successo!";
		}
		

		return $pdf->stream( $pdf_file ); 

	}



	/**
    * PREVIEW PRINT   
    *
    * @param  string  $id
    * @return Response
    */
	public function printThis($id)
	{     
		$relatorio           = Relatorio::find($id);			

		switch ( @$relatorio->type ) {
			case 'despesas':

				$despesas_ids = explode(',', $relatorio->ids);
    			$despesas = Despesa::whereIn('id', $despesas_ids )->get();
    			$relatorio->despesas = $despesas;
    			
				// Total de despesas
				$total = 0;
				foreach ($relatorio->despesas as $despesa) {
					$total += $despesa->valor;
					// Fomata R$ despesas
					$despesa->valor  = number_format( $despesa->valor, 2, ',', '.' ); 
				};
				// Fomata R$ Total
				$relatorio->total = number_format( $total, 2, ',', '.' );
				break;
			
			case 'conversas':
				//Agrupa por cliente
				$groups  			= $relatorio->conversas->groupBy('cliente_id');

				$clientes_conversas = array();
				
				foreach($groups as $cliente_id => $conversas){

					$client = Cliente::find( $cliente_id );
					if( count( $client ) ){
						
						$client->conversas = $conversas;
						$clientes_conversas[] = $client;
					}
						
				};
				
				$relatorio->conversas = $clientes_conversas;
				break;
			
			default:
				return "???";		
				break;

		}

		return View::make(  'relatorios.'.$relatorio->type.'.print', compact('relatorio'));            							     							
		return View::make(  'relatorios.'.$relatorio->type.'.print', compact('relatorio'));            							     							

	}



	/**
    * PDF (GERA O ARQUIVO)    
    *
    * @param  Relatorio Object
    * @return PDF Object
    */
	public function gerarPdf($relatorio)
	{     

		if( is_file( asset('pdf/relatorios/relatorio-'.$relatorio->id.'_'.$relatorio->type.'.pdf') ) ){
			$pdf = App::make('dompdf');
		}else{
			//$pdf = App::make('dompdf');
			$pdf = PDF::loadView( 'relatorios.'.$relatorio->type.'.pdf', compact('relatorio'))->setPaper('a4')->setOrientation('portrait')->setWarnings(false)->save( 'pdf/relatorios/relatorio-'.$relatorio->id.'_'.$relatorio->type.'.pdf' );
		}		
		
		return $pdf;  		
	}

	/**
	 * Status atual dos itens
	 *
	 * @param  string $resource_name
	 * @return Response
	 */
	public function status( $resource_name = NULL )
	{
		// TIPO DE RELATÓRIO
		switch ($resource_name) {
			/*
				DESPESAS
			*/
			case 'despesas':
				$items = Despesa::all();
				break;
			
			/*
				CONVERSAS
			*/
			case 'conversas':
				$items = Conversa::all();
				break;
			
			default:				
				return $items = array();
				break;
		}

		// STATUS
		$status['total'] 		= count($items);
		$status['nao_enviadas'] = $items->filter(function($item){
			if( isset($item->relatorio_id) and $item->relatorio_id < 1 ){
				return $item;
			}
		});
		$status['nao_enviadas'] = count($status['nao_enviadas']);

		// RETURN
		return $status;
	}


}