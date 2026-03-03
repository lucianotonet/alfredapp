<?php

class EmailsController extends \BaseController {

	/**
	 * Display a listing of emails
	 *
	 * @return Response
	 */
	public function index()
	{
		$emails = Email::orderBy('id', 'desc')->paginate( Input::get('paginate', 10) );

		return View::make('emails.index', compact('emails'));
	}

	/**
	 * Show the form for creating a new email
	 *      
		* 
	 * @return Response
	 */
	public function create()
	{
		$email['owner_type']	= ( isset( $_GET['owner_type'] ) ) ? $_GET['owner_type'] : NULL;
		$email['owner_id']		= ( isset( $_GET['owner_id'] ) )   ? $_GET['owner_id']   : NULL;
		$email['mail_to'] 		= ( isset( $_GET['mail_to'] ) )    ? $_GET['mail_to']    : NULL;

		/*
				SWITCH	RESOURCE
		*/
		switch ( $email['owner_type'] ) {
			case 'pedido':
				$resource = Pedido::find( $email['owner_id'] );
				if( $resource ){
					$email['subject']  	  = "Pedido nº".$resource->id . " - ".@$resource->cliente->nome." (".@$resource->cliente->empresa.")";	  						
					$email['message']  	  = "Segue pedido nº". $resource->id ." de '".@$resource->cliente->nome."' da empresa '".@$resource->cliente->empresa."'";  
					$email['attachments'] = $resource->getAttachment();
				}else{
					if (Request::ajax()) {
						$alert = '<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong><i class="fa fa-warning"></i></strong> O pedido n°'.$email['owner_id'].' não existe!
								 </div>';
						return $alert;
					}else{
						// Alert
						$alert[] = array(                     
		 							'class'		=>	'alert-danger',
		                            'message'   => '<strong><i class="fa fa-warning"></i></strong> O pedido n°'.$email['owner_id'].' não existe!'
		                        );
						Session::flash('alerts', $alert);	
						return Redirect::to( URL::previous() );   
					}				
				}				
				break;
			
			case 'relatorio':
				$resource = Relatorio::find( $email['owner_id'] );    
				if( $resource ){
					switch ($resource->type) {
						case 'despesas':									
							$email['subject']  		= "Relatório de despesas (".date('d/m/Y').")";	  						
							$email['message']  		= "Novo relatório com ".count( $resource->get_despesas() )." registros.";	  
							$email['attachments']   = @$resource->getAttachment(); 						
							break;
						
						case 'conversas':
							$email['subject']  		= "Relatório de conversas (".date('d/m/Y').")";	  						
							$email['message']  		= "Novo relatório com ".count($resource->conversas)." conversas.";	
							$email['attachments']   = @$resource->getAttachment(); 		  						
							break;
						
						default:
							$email['subject']  		= "Relatório nº".$resource->id;	  						
							$email['message']  		= "Segue relatório nº".$resource->id;
							break;
					}
				}else{
					if (Request::ajax()) {
						$alert = '<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong><i class="fa fa-warning"></i></strong> O relatório n°'.$email['owner_id'].' não existe!
								 </div>';
						return $alert;
					}else{
						// Alert
						$alert[] = array(                     
		 							'class'		=>	'alert-danger',
		                            'message'   => '<strong><i class="fa fa-warning"></i></strong> O relatório n°'.$email['owner_id'].' não existe!'
		                        );
						Session::flash('alerts', $alert);	
						return Redirect::to( URL::previous() );   
					}				
				}	
				break;
			
			case 'cliente':
				$resource 		   = Cliente::find( $email['owner_id'] );  
				if( $resource ){
					$email['subject']  = "Dados de contato";	  						
					$email['message']  = "Segue dados do cliente ". @$resource->nome ." (".@$resource->empresa.").";  
				}else{
					if (Request::ajax()) {
						$alert = '<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong><i class="fa fa-warning"></i></strong> O cliente n°'.$owner_id.' não existe!
								 </div>';
						return $alert;
					}else{
						// Alert
						$alert[] = array(                     
		 							'class'		=>	'alert-danger',
		                            'message'   => '<strong><i class="fa fa-warning"></i></strong> O cliente n°'.$owner_id.' não existe!'
		                        );
						Session::flash('alerts', $alert);	
						return Redirect::to( URL::previous() );   
					}				
				}	
				break;
			
			default:
				$resource = "";
				break;
		}		

		if (Request::ajax()) return View::make('emails.panels.create', compact('email', 'resource') );
		else 				 return View::make('emails.create', compact('email', 'resource') );		
	}

	/**
	 * Store a newly created email in storage.
	 * SEND THE MAIL
	 *
	 * @return Response
	 */
	public function store()
	{
			
		$validator = Validator::make($data = Input::all(), Email::$rules);
		//return Response::json($data);

		if( $validator->fails() ){
			if ( Request::ajax() ) return Response::json('error', '503')->withErrors($validator);			
			else return Redirect::back()->withErrors($validator)->withInput();			
		}

		// echo "<pre>";
		// print_r( $data );
		// echo "</pre>";
		// exit;

		switch ( $data['owner_type'] ) {
			case 'pedido':
				$resource = Pedido::find( $data['owner_id'] );   
				$view = 'layouts.email'; //Corpo do email
				if($resource){
					 $resource->status = '2';            
					 $resource->save();               
				}   						
				break;
			
			case 'relatorio':
				$resource = Relatorio::find( $data['owner_id'] );    	  					
				$view = 'relatorios.email';
				unset( $data['attachments'] );
				if($resource and Confide::user() ){
					 $resource->status = '2';            
					 $resource->save();               
				}  
				break;
			
			case 'cliente':
				$resource = Cliente::find( $data['owner_id'] );
				$data['resource'] = $resource;  
				// print_r($resource)  ;
				// exit;
				$view = 'clientes.email';
				break;
			
			default:
				$view 		= 'layouts.email';
				$resource 	= NULL;
				break;
		}

			/**
			*
			*	SEND THE MAILS
			*
			**/

			// SEND to EACH "TO"
			foreach ($data['to'] as $to) {
				
				$content 	   = $data;
				$content['to'] = $to; 

				// print_r($view);
				// exit;

				// DEBUG
				// return View::make( $view, array('email'=>$content, 'resource'=>$resource) );
				// exit;

				Mail::queue( $view, array('email'=>$content, 'resource'=>$resource ), function($message) use ($content, $to)
				{
				  	$message->to( $to )
				            ->subject( @$content['subject'] );
				    /**
					 *    ANEXA O PDF
					 */
				    // print_r($content['attachments']);
				    // exit;
						if( isset( $content['attachments'] ) AND is_file( $content['attachments'] ) ){							 
							 $attachment = $content['attachments'];
							 $message->attach( $attachment );
						}
				});


				$email = Email::create($content);			

		



			
				if($email){


					 //$downloadLink   = url(  'pedidos/'.$email->owner_id.'/download');
					 //$email->pdfLink = $downloadLink;           
					 //Swift_Preferences::getInstance()->setCacheType('disk')->setTempDir('/tmp');

					 

					 // //SEND THE MAIL         
					 // Mail::send('layouts.email', compact('email'), function($message)use($email){         
							

						// 	//$message->from('contato@lucianotonet.com', 'L. Tonet');
						// 	$message->to( $email->to );

						// 	if( isset($email->cc) and !empty($email->cc)) {
						// 		 $message->cc( $email->cc );
						// 		 //append to report record
						// 		 $reportMsg = ' com CC: <'.$email->cc.'>';
						// 	}

						// 	$message->subject( @$email->subject );


						// 	/**
						// 	 *    ANEXA O PDF
						// 	 */
						// 	if(isset($email->attachments)){
						// 		 $file = strtolower($email->owner_type).'-'.$email->owner_id.'.pdf';
						// 		 $file = asset('pdf/'.$file);
							
						// 		 $attachment = Swift_Attachment::fromPath('pdf/'.$file);
						// 		 // Attach it to the message
						// 		 $message->attach($file);


						// 	}

							
						         

						// 	//Log this
						// 	// Report::create([
						// 	//       'user_id'        => Auth::id(),
						// 	//       'status'         => 'success',
						// 	//       'event'          => 'sended',
						// 	//       'title'          => 'Pedido '.$email->owner_id.' enviado',
						// 	//       'resource_model' => 'Pedido',
						// 	//       'owner_id'    => $email->owner_id,
						// 	//       'resource_obj'   => json_encode($email),
						// 	//    ]);
							


					 // });
					


				}else{
					echo 'não criado';
				}
				// Alert
				$alert[] = [ 'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Enviado para <strong>'. $content['to'].'</strong> !' ];
 			}


 			
			
			
			Session::flash('alerts', $alert);      

			return Redirect::to( URL::previous() );

	}

	/**
	 * Display the specified email.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$email = Email::findOrFail($id);

		return View::make('emails.show', compact('email'));
			//return View::make('layouts.email', compact('email'));
	}

	/**
	 * Show the form for editing the specified email.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$email = Email::find($id);

		return View::make('emails.edit', compact('email'));
	}

	/**
	 * Update the specified email in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$email = Email::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Email::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$email->update($data);

		return Redirect::route('emails.index');
	}

	/**
	 * Remove the specified email from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Email::destroy($id);

		return Redirect::route('emails.index');
	}



	 /**
		*    TRACK EMAIL OPENS
		**/
	 public function track($id)
	 {
			if( isset($id) && !empty( $id )){

				 if( isset( $_GET['email'] ) && !empty( $_GET['email'] ) ){

						$email   = Email::find($id);

						if($email){
							 if( $_GET['email'] == $email->to and $email->status != 'sucess' and $email->status != 'danger'){
									$email->status    = 'success'; // Aberto pelo destinatário                  
									$email->last_open = $_GET['email'];

									// Notificação de leitura de email
									Notification::create([   
										'icon'     => 'fa-check',
										'title'    => $email->to . ' recebeu seu e-mail!<br/><small><span class="timeago" title="'.date('Y-m-d H:i:s').'"></span></small>',
										'status'   => false,
									]);

							 }
							 $email->save();      


						}else{
							 return "Não encontrado";
						}

							 //Full URI to the image
							 $graphic_http = 'http://basaltosegranitos.com.br/img/blank.gif';

							 //Get the filesize of the image for headers
							 $filesize = filesize( 'img/blank.gif' );

							 //Now actually output the image requested (intentionally disregarding if the database was affected)
							 header( 'Pragma: public' );
							 header( 'Expires: 0' );
							 header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
							 header( 'Cache-Control: private',false );
							 header( 'Content-Disposition: attachment; filename="blank.gif"' );
							 header( 'Content-Transfer-Encoding: binary' );
							 header( 'Content-Length: '.$filesize );
							 //Begin the header output
							 //header( 'Content-Type: image/gif' );
							 readfile( $graphic_http );

				 }else{
						return "Informe o e-mail";
				 } 
			}else{
				 return "Informe o id";
			} 
		
			

			
	 }


	 /*	

	 	GET CONTACTS
			via AJAX



	 */
	public function getContacts()
	{
	 	//if( Request::ajax() ){
 			$query = Input::get('query');         

			$clientes 		= Cliente::where('email', 'like', '%'.$query.'%')->get();
			$fornecedores 	= Fornecedor::where('email', 'like', '%'.$query.'%')->get();
			$vendedores 	= Vendedor::where('email', 'like', '%'.$query.'%')->get();



			foreach ($clientes as $cliente) {
				$suggestions[] = array(
				                       	"value"  => $cliente->email,
				                       	"data"	 => array(
				                       	               'type' => 'Clientes ('.count($clientes).')'
				                       	            )		 							
				                    );				
			}
			foreach ($fornecedores as $fornecedor) {
				$suggestions[] = array(
				                       	"value"  => $fornecedor->email,
				                       	"data"	 => array(
				                       	               'type' => 'Fornecedores ('.count($fornecedores).')'
				                       	            )		 							
				                    );				
			}
			foreach ($vendedores as $vendedor) {
				$suggestions[] = array(
				                       	"value"  => $vendedor->email,
				                       	"data"	 => array(
				                       	               'type' => 'Vendedores ('.count($vendedores).')'
				                       	            )		 							
				                    );				
			}


 			$contacts = array( 'suggestions' => $suggestions );	
		
		 	//$contacts = Cliente::all();
		 	return Response::json($contacts);
	    //}
	}

}
