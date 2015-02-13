<?php
use Faker\Factory as Faker;
use Carbon\Carbon as Carbon;

class TransactionsController extends \BaseController {

	/**
	 * Display a listing of transactions
	 *
	 * @return Response
	 */
	public function index()
	{
	
		// $faker = Faker::create();
		// echo $faker->date('Y-m-d');
		// echo "<br/>";
		// echo date("Y-m-d", strtotime( $faker->date('Y-m-d') ) );
		//           exit;

		// $trans = new TransactionsTableSeeder;
		// $trans->run();

		// $cats = new CreateCategoriesTable;
		// $cats->up();
		// $trans = new CreateTransactionsTable;
		// $trans->up();
		// return "Pronto";

		


		

		$data = Input::all();
		if( !isset($data['view']) )		{ $data['view'] 	 = 'day'; }
		if( !isset($data['date_from']) ){ $data['date_from'] = date('Y-m-d'); }

		// NAVIGATION
		if( !isset($data['next']) )		{ $data['next'] 	 = 0; }
		if( !isset($data['prev']) )		{ $data['prev'] 	 = 0; }

		if( @$data['next'] == @$data['prev'] ) { $data['next'] = $data['prev'] = 0; }

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit;      


		setlocale(LC_ALL, "pt");

		//MESSAGES
		$info = array();


		/*
			FILTROS DE EXIBIÇÃO
		*/	
		switch ( $data['view'] ) {
			case 'week':				

				$view = "transactions.views.week";
				$date 		  		= Carbon::createFromFormat( 'Y-m-d', $data['date_from'] )
												->addWeeks( $data['next'] )
												->subWeeks( $data['prev'] );										
										
				$transactions 		= Transaction::where( 'date', '>=', $date->startOfWeek()->format('Y-m-d') )
												 ->where( 'date', '<=', $date->endOfWeek()->format('Y-m-d') )
												 ->where( 'user_id', Auth::id() )
												 ->orderBy( 'date' )
												 ->get();				
	
				$title = "De " . strftime("%a %d/%m", strtotime( $date->startOfWeek() )) . " à " . strftime("%a %d/%m", strtotime( $date->endOfWeek() ));

				break;
			
			case 'month':

				$view = "transactions.views.month";
				$date 		  = Carbon::createFromFormat( 'Y-m-d', $data['date_from'] )
										->addMonths( $data['next'] )
										->subMonths( $data['prev'] );
								
				$transactions = Transaction::where( 'date', '>=', $date->startOfMonth()->format('Y-m-d') )
											 ->where( 'date', '<=', $date->endOfMonth()->format('Y-m-d') )
											 ->where( 'user_id', Auth::id() )
											 ->orderBy( 'date' )
											 ->get();		

				$title = strftime("%B de %Y", strtotime( $date ));

				break;
			
			case 'range':

				$view = "transactions.views.index";
								
				$transactions = Transaction::where( 'date', '>=', $data['date_from'] )
											 ->where( 'date', '<=', $data['date_to'] )
											 ->where( 'user_id', Auth::id() )
											 ->orderBy( 'date' )
											 ->get();		

				$title = strftime("%d de %B", strtotime( $data['date_from'] )) . " à " . strftime("%d de %B", strtotime( @$data['date_to'] ));
				break;

			case 'overdue':

				$view = "transactions.views.overdue";
				$date 		  		= Carbon::now();

				$transactions 		= Transaction::where('done', 0)->where( 'date', '<', $date->format('Y-m-d') )
													->orderBy( 'date' )
													->where( 'user_id', Auth::id() )
													->get();
				
				if ( count( $transactions ) <= 0 ){	
					$info[] = [  'class' 	=> 'alert-success',
				                 'message' => "Nenhum lançamento pendente. Muito bem!" ];
				}else{
					$info[] = [  'class' 	=> 'alert-warning',
			              		 'message' => '<strong><i class="fa fa-warning"></i></strong> Você tem <strong>'.count( $transactions ) . '</strong> lançamentos pendentes.' ];
	
				}				

				$title = "Lançamentos pendentes";

				
				break;
			
			default:

				$view = "transactions.views.day";
				$date 		  		= Carbon::createFromFormat( 'Y-m-d', $data['date_from'] )
												->addDays( $data['next'] )
												->subDays( $data['prev'] );

				$transactions 		= Transaction::where( 'date', $date->format('Y-m-d') )->where( 'user_id', Auth::id() )->orderBy( 'date' )->get();
				
				if ( $date->isToday() ){
					$title = "hoje";
				}else if ( $date->isTomorrow() ){
					$title = "amanhã";
				}else if ( $date->isYesterday() ){
					$title = "ontem";
				}else{
					$title = strftime("%d de %B", strtotime( $date ));
				}
				break;
		}
		
		
		$transactionsOverdue  = Transaction::where('done', 0)->where( 'date', '<', date('Y-m-d') )->where( 'user_id', Auth::id() )->orderBy( 'date' )->get();

		
		if ( count( $transactionsOverdue ) > 0 && $data['view'] != 'overdue' ){
			$info[] = [  'class' 	=> 'alert-warning',
			              'message' => '<strong><i class="fa fa-warning"></i></strong> Você tem <strong>'.count( $transactionsOverdue ) . '</strong> lançamentos pendentes. <a href="'. url( "financeiro/?view=overdue" ) .'" class="btn btn-link">Ver lançamentos</a>' ];
	
		}

		Session::flash('info', $info);
		// echo $title;
		// echo "<pre>";
		// print_r($transactions);
		// echo "</pre>";
		// exit;



		/*
			DADOS PRA NAVEGAÇÃO
		*/	
		$navigation = array();


		return View::make('transactions.index', compact('transactions', 'view', 'title', 'data', 'saldo'));
	}

	/**
	 * Show the form for creating a new transaction
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('transactions.create');
	}

	/**
	 * Store a newly created transaction in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Transaction::$rules);
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}



		// USER
		$data['user_id'] = Auth::id();

		// AMOUNT Format
		$data['amount'] = str_replace('.', '', $data['amount'] );
		$data['amount'] = str_replace(',', '.', $data['amount'] );

		// TYPE
		if( $data['type'] == 'despesa' ){
			$data['amount'] = (0 - $data['amount']); // Deixa o número negativo
		}

		// DONE
		if( !empty( $data['done'] ) ){
			$data['done'] = "1";
		}

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit;      


		switch ( @$data['recurring_type'] ) {
			case 'daily':
				//return "Repetir diariamente";
				break;
			
			case 'weekly':
				# code...
				break;
			
			case 'biweekly':
				# code...
				break;
			
			case 'monthly':
				# code...
				break;
			
			case 'bimonthly':
				# code...
				break;
			
			case 'trimonthly':
				# code...
				break;
			
			case 'sixmonthly':
				# code...
				break;
			
			case 'yearly':
				# code...
				break;
			
			default:
				//echo "Nunca repetir";
				break;
		}


		//return Response::json($data);
		//exit;

		// Create the transaction
		$transaction = Transaction::create($data);
		if( $transaction ){
			$alert[] = [  'class' 	=> 'alert-success',
			              'message' => '<strong><i class="fa fa-check"></i></strong> Movimentação registrada!' ];
		}
	    Session::flash('alerts', $alert);
		return Redirect::back()->withInput();			

	}

	/**
	 * Display the specified transaction.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$transaction = Transaction::find( $id );

		if( count( $transaction ) < 1 ){
			$alert[] = [  'class' 	=> 'alert-warning',
			              'message' => '<strong><i class="fa fa-warning"></i></strong> Lançamento não encontrado!' ];
		    Session::flash('alerts', $alert);
		    if ( Request::header('referer') ) {
				return Redirect::back();				    	
		    }else{
		    	return Redirect::to('financeiro');
		    }
		}

		if ( $transaction->user_id != Auth::id() ) {
			$alert[] = [  'class' 	=> 'alert-danger',
			              'message' => '<strong><i class="fa fa-warning"></i></strong> Hei! O que está tentando fazer?' ];
		    Session::flash('alerts', $alert);
		    if ( Request::header('referer') ) {
				return Redirect::back();				    	
		    }else{
		    	return Redirect::to('financeiro');
		    }
		}

		return View::make('transactions.show', compact('transaction'));
	}

	/**
	 * Show the form for editing the specified transaction.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$transaction = Transaction::find($id);

		if( count( $transaction ) < 1 ){
			$alert[] = [  'class' 	=> 'alert-warning',
			              'message' => '<strong><i class="fa fa-warning"></i></strong> Lançamento não encontrado!' ];
		    Session::flash('alerts', $alert);
		    if ( Request::header('referer') ) {
				return Redirect::back();				    	
		    }else{
		    	return Redirect::to('financeiro');
		    }
		}

		if ( $transaction->user_id != Auth::id() ) {
			$alert[] = [  'class' 	=> 'alert-danger',
			              'message' => '<strong><i class="fa fa-warning"></i></strong> Hei! O que está tentando fazer?' ];
		    Session::flash('alerts', $alert);
		    if ( Request::header('referer') ) {
				return Redirect::back();				    	
		    }else{
		    	return Redirect::to('financeiro');
		    }
		}

		$transaction->amount = str_replace('-', '', $transaction->amount);
		$transaction->amount = number_format( (float)$transaction->amount, '2', ',', '.');

		if (Request::ajax()) {	return View::make('transactions.panels.edit', compact('transaction'));} 
		else {  				return View::make('transactions.edit', compact('transaction')); }
	}

	/**
	 * Update the specified transaction in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$transaction = Transaction::find($id);

		$validator = Validator::make($data = Input::all(), Transaction::$rules);

		if ($validator->fails())
		{
			$alert[] = [   'class' => 'alert-danger', 'message'   => '<strong><i class="fa fa-warning"></i></strong> Erro!' ];
			Session::flash('alerts', $alert);	
			return Redirect::back()->withErrors($validator)->withInput();
		}

		// DONE
		if( isset( $data['done'] ) and !empty( $data['done'] ) ) {
			$data['done'] = 1;
		}else{
			$data['done'] = 0;
		}


		if( isset( $data['amount'] ) ){
			// AMOUNT Format
			$data['amount'] = str_replace('.', '', $data['amount'] );
			$data['amount'] = str_replace(',', '.', $data['amount'] );		
			$data['amount'] = str_replace('-', '', $data['amount'] );	// TIRA O "-"			
			if( $data['type'] == 'despesa' ){
				$data['amount'] = (0 - $data['amount']); // Deixa o número negativo
			}
		}

		// return Response::json($data);
		// exit;

		$transaction->update($data);

		$alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Lançamento atualizado!' ];
		Session::flash('alerts', $alert);			
		
		return Redirect::to( URL::previous() );  		
	}

	/**
	 * Remove the specified transaction from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$transaction = Translation::find($id);
		if ( $transaction->user_id != Auth::id() ) {
			Transaction::destroy($id);

			$alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Lançamento excluído!' ];
		}else{
			$alert[] = [   'class' => 'alert-danger', 'message'   => '<strong><i class="fa fa-check"></i></strong> Sem permissão para excluir o lançamento!' ];
		}
		Session::flash('alerts', $alert);			
		return Redirect::to( URL::previous() );  
	}



	/**
	 *	RESUMO
	 * 		Painel inicial
	 *	
	 * @return Response
	 */
	public function dashboard()
	{		
		// setlocale(LC_ALL, "pt");
		// setlocale(LC_TIME, "America/Sao_Paulo");
		setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
		date_default_timezone_set('America/Sao_Paulo');

		$hoje = Carbon::now();
	 

		// BALANCE
		$balance = DB::table('transactions')                                    							                            
                            ->where( 'user_id', Auth::id() )
                            ->where( 'done', 1 )
                            //->get();
                            ->sum( 'amount' );

        // Despesas no mês
		$despesas_mes = DB::table('transactions')                                    							
                            ->where( 'created_at', '>=', $hoje->startOfMonth()->format('Y-m-d H:i:s') )
                            ->where( 'created_at', '<=', $hoje->endOfMonth()->format('Y-m-d H:i:s') )
                            ->where( 'type', 'despesa' )
                            ->where( 'user_id', Auth::id() )
                            ->where( 'done', 1 )
                            //->get();
                            ->sum( 'amount' );

		// Receitas do Mês
		$receitas_mes = DB::table('transactions')                                    							
                            ->where( 'created_at', '>=', $hoje->startOfMonth()->format('Y-m-d H:i:s') )
                            ->where( 'created_at', '<=', $hoje->endOfMonth()->format('Y-m-d H:i:s') )
                            ->where( 'type', 'receita' )
                            ->where( 'user_id', Auth::id() )
                            ->where( 'done', 1 )
                            //->get();
                            ->sum( 'amount' );                           

       
		// LABELS
		$labels = [	'date' 			=> strftime("%A, %d de %B de %Y", strtotime( date('Y-m-d') )),
					'balance' 		=> number_format($balance, '2', ',', '.'),
					'despesas_mes'  => number_format($despesas_mes, '2', ',', '.'),
					'receitas_mes'  => number_format($receitas_mes, '2', ',', '.') ];	


		// STATUS DESPESAS
		$transactions['despesas'] 				= Transaction::where( 'done', 0 )
																->where( 'type', 'despesa' )
																->where('user_id', Auth::id() )
													 			->orderBy( 'date' )
													 			->get();	
		
		$transactions['despesas_atrasadas'] 	= $transactions['despesas']->filter( function( $transaction ){
																		if ( $transaction->isOverdue() ) return $transaction;
																	});
		if ( count( $transactions['despesas_atrasadas'] ) > 0 ){
			$labels['despesas_atrasadas'] = '<div class="list-group-item alert-danger text-center"><i class="fa fa-warning"></i> '.count( $transactions['despesas_atrasadas'] ).' despesas atrasadas</div>';
		}else{
			$labels['despesas_atrasadas'] = '';
		}


		// STATUS RECEITAS
		$transactions['receitas'] 	= Transaction::where( 'done', 0 )
													->where( 'type', 'receita' )											 			
													->orderBy( 'date' )	
													->where('user_id', Auth::id() )
										 			->get();	

		$transactions['receitas_atrasadas'] 	= $transactions['receitas']->filter( function( $transaction ){
																		if ( $transaction->isOverdue() ) return $transaction;
																	});
		if ( count( $transactions['receitas_atrasadas'] ) > 0 ){
			$labels['receitas_atrasadas'] = '<div class="list-group-item alert-danger text-center"><i class="fa fa-warning"></i> '.count( $transactions['receitas_atrasadas'] ).' receitas atrasadas</div>';
		}else{
			$labels['receitas_atrasadas'] = '';
		}




		return View::make('transactions.dashboard', compact('transactions','balance', 'labels'));
	}




}
