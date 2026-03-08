<?php
use Faker\Factory as Faker;
use Carbon\Carbon as Carbon;

class TransactionsController extends \BaseController {

	/**
	 *	RESUMO
	 * 		Painel inicial
	 *	
	 * @return Response
	 */
	public function index()
	{		
		
		$date   = Carbon::now();
		$title  = strftime("%B de %Y", strtotime( $date ));			
				
		// ALL UNPAID TRANSACTIONS				
		$transactions  = Transaction::where('done', 0)->where( 'user_id', Auth::id() )->orderBy( 'date' )->get();
		
		// RECEITAS FILTERS
		$receitas['all'] 		= $transactions->filter( function( $transaction ){ 		
			if( $transaction->type == 'receita' ){ 
				return $transaction; 
			} 
		});	
		$receitas['overdue'] 	= $receitas['all']->filter( function( $transaction ){ 	
			if( $transaction->date < date('Y-m-d') ){ 
				return $transaction; 
			} 
		});	
		$receitas['today'] 		= $receitas['all']->filter( function( $transaction ){ 	
			if( ( new Carbon( $transaction->date ) )->isToday() ){
				return $transaction;
			} 
		});	
		$receitas['next'] 		= $receitas['all']->filter( function( $transaction ){ 	
			if( $transaction->date > date('Y-m-d') ){ 
				return $transaction; 
			} 
		});	

		
		// DESPESAS FILTERS
		$despesas['all'] 		= $transactions->filter(function( $transaction ){ 		
			if( $transaction->type == 'despesa' ){ 
				return $transaction; 
			} 
		});			
		$despesas['overdue'] 	= $despesas['all']->filter(function( $transaction ){ 	
			if( $transaction->date < date('Y-m-d') ){ 
				return $transaction; 
			} 
		});	
		$despesas['today'] 		= $despesas['all']->filter( function( $transaction ){ 	
			if( ( new Carbon( $transaction->date ) )->isToday() ){
				return $transaction;
			} 
		});	
		$despesas['next'] 	= $despesas['all']->filter(function( $transaction ){ 	
			if( $transaction->date > date('Y-m-d') ){ 
				return $transaction; 
			} 
		});
				

		// GRAPH DATA CURRENT MONTH
		$month = Transaction::where( 'date', '>=', $date->startOfMonth()->format('Y-m-d') )
											 ->where( 'date', '<=', $date->endOfMonth()->format('Y-m-d') )
											 ->where( 'user_id', Auth::id() )
											 ->orderBy( 'date', 'DESC' )
											 ->get();
		// AGRUPA POR DIA
		$transactions_days = $month->groupBy( function($transaction)
		{
		    return $transaction->date;
		});
		

		// echo "<pre>";
		// print_r($transactions_days);
		// exit;

		// SALDO ATUAL
		$balance['saldo_atual'] 	= Transaction::where('done', 1)
													->where( 'user_id', Auth::id() )
													->sum('amount');

		$balance['total_depesas'] 	= Transaction::where('done', 1)
													->where( 'user_id', Auth::id() )
													->where( 'type', 'despesa' )
													->where( 'date', '>=', Carbon::now()->startOfMonth()->format('Y-m-d') )
													->where( 'date', '<=', Carbon::now()->endOfMonth()->format('Y-m-d') )
													->sum('amount');
		$balance['total_receitas'] 	= Transaction::where('done', 1)
													->where( 'user_id', Auth::id() )
													->where( 'type', 'receita' )
													->where( 'date', '>=', Carbon::now()->startOfMonth()->format('Y-m-d') )
													->where( 'date', '<=', Carbon::now()->endOfMonth()->format('Y-m-d') )
													->sum('amount');
		
		return View::make('transactions.novo.index', compact('transactions', 'transactions_days', 'receitas', 'despesas', 'balance'));
	}





	public function lancamentos()
	{
		$data = Input::all();
		if( !isset($data['view']) )		{ $data['view'] 	 = 'month'; }
		if( !isset($data['date_from']) ){ $data['date_from'] = date('Y-m-d'); }

		// NAVIGATION		
		if( !isset($data['next']) )		{ $data['next'] 	 = 0; }
		if( !isset($data['prev']) )		{ $data['prev'] 	 = 0; }

		// FILTERS
		if( !isset($data['filter_type']) ) { $data['filter_type'] = NULL; }
		if( !isset($data['filter_done']) ) { $data['filter_done'] = NULL; }

		if( @$data['next'] == @$data['prev'] ) { $data['next'] = $data['prev'] = 0; }

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit;      


		//MESSAGES
		$info = array();

	
		/*
			FILTROS DE EXIBIÇÃO
		*/	
		switch ( $data['view'] ) {

			case 'day':
				$view = "transactions.views.day";
				$date = Carbon::createFromFormat( 'Y-m-d', $data['date_from'] )
												->addDays( $data['next'] )
												->subDays( $data['prev'] );

				$transactions = Transaction::where( 'date', $date->format('Y-m-d') )->where( 'user_id', Auth::id() )->orderBy( 'date' )->get();
				
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
	
				$title = strftime("%a %d/%m", strtotime( $date->startOfWeek() )) . " à " . strftime("%a %d/%m", strtotime( $date->endOfWeek() ));

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

				$title = "pendentes";

				
				break;
			
			default:
				// case 'month':

				$view = "transactions.views.month";

				$date   = Carbon::createFromFormat( 'Y-m-d', $data['date_from'] )
										->addMonths( $data['next'] )
										->subMonths( $data['prev'] );
								
				$transactions = Transaction::where( 'date', '>=', $date->startOfMonth()->format('Y-m-d') )
											 ->where( 'date', '<=', $date->endOfMonth()->format('Y-m-d') )
											 ->where( 'user_id', Auth::id() )
											 ->orderBy( 'date', 'DESC' )
											 ->get();


				$title = strftime("%B de %Y", strtotime( $date ));				
				break;			
		}
		


		// FILTERS
		if( isset( $data['filter_order'] ) and $data['filter_order'] == 'desc'){
			$transactions->sortByDesc('date'); // sort using collection method
			$labels['filter_order'] = '<i class="fa fa-chevron-down"></i>';
		}else{
			$transactions->sortBy('date'); // sort using collection method
			$labels['filter_order'] = '<i class="fa fa-chevron-up"></i>';
		}

		
		if( $data['filter_done'] ){
			$transactions = $transactions->filter( function ( $transaction ) use ($data) {
				if( $transaction->done == $data['filter_done'] ){
					return $transaction;
				};
			});

			// LABELS
			switch ($data['filter_done']) {
				case 1:					
					$labels[ 'filter_done' 	] = 'efetivadas';
					break;
				
				case 0:
					$labels[ 'filter_done' 	] = 'não efetivadas';
					break;				
			}
		}


		if( $data['filter_type'] ){
			$transactions = $transactions->filter( function ( $transaction ) use ($data) {
				if( $transaction->type == $data['filter_type'] ){
					return $transaction;
				};
			} );

			// LABELS
			switch ($data['filter_type']) {
				case 'receita':					
					$labels[ 'filter_type' 	] = 'receitas';
					break;
				
				case 'despesa':
					$labels[ 'filter_type' 	] = 'despesas';
					break;
			}
		}



		// LABELS
		$labels[ 'title' ] = $title;
		


		// STATUS NO PERÍODO
		$receitas 		= $transactions->filter(function( $transaction ){ if( $transaction->type == 'receita' ){ return $transaction; } });	
		$receitas_ok	= $receitas->filter(function( $transaction ){ if( $transaction->done == '1' ){ return $transaction; } });	
		$despesas 		= $transactions->filter(function( $transaction ){ if( $transaction->type == 'despesa' ){ return $transaction; } });	
		$despesas_ok	= $despesas->filter(function( $transaction ){ if( $transaction->done == '1' ){ return $transaction; } });			
				
		$balance['receitas'] 		= $receitas->sum('amount');
		$balance['receitas_ok'] 	= $receitas_ok->sum('amount');
		$balance['despesas'] 		= $despesas->sum('amount');
		$balance['despesas_ok'] 	= $despesas_ok->sum('amount');		
		$balance['saldo'] 			= $transactions->sum('amount'); // SALDO NO PERÍODO
											 
		// SALDO ATUAL
		$balance['saldo_atual'] = Transaction::where('done', 1)->where( 'user_id', Auth::id() )->sum('amount');
		
		$transactionsOverdue  = Transaction::where('done', '!=', 1)->where( 'date', '<', date('Y-m-d') )->where( 'user_id', Auth::id() )->orderBy( 'date' )->get();
		
		if ( count( $transactionsOverdue ) > 0 && $data['view'] != 'overdue' ){
			$info[] = [  'class' 	=> 'alert-warning',
			              'message' => '<strong><i class="fa fa-warning"></i></strong> Você tem <strong>'.count( $transactionsOverdue ) . '</strong> lançamentos pendentes. <a href="'. url( "financeiro/lancamentos?view=overdue" ) .'" class="">Ver lançamentos</a>' ];
		}

		Session::flash('info', $info);
		
		// AGRUPA POR DIA
		$transactions_days = $transactions->groupBy( function($transaction)
		{
		    return $transaction->date;
		});

		// SORT BY FILTERS
		if( isset( $data['filter_order'] ) and $data['filter_order'] == 'desc'){
			$transactions_days = $transactions_days->sortByDesc( function($transaction){
				$t = end( $transaction );
			    return $t->date;
			});
		}else{
			$transactions_days = $transactions_days->sortBy( function($transaction){
				$t = end( $transaction );
			    return $t->date;
			});
		}

		// echo "<pre>";
		// print_r($balance);
		// exit;


		/*
			DADOS PRA NAVEGAÇÃO
		*/	
		$navigation = array();
		
		$view = 'transactions.novo.lancamentos';
		return View::make( $view, compact('transactions', 'transactions_days', 'view', 'title', 'data', 'balance', 'labels'));		
			
	}


	/**
	 * Adiciona nova transação
	 * @param  string $type Tipo de transação [despesa(default), receita]
	 * @return view       	View
	 */	
	public function create()
	{
		$data = Input::all();
		
		// return View::make('transactions.create');
		if ( Request::ajax() ) 	return View::make('transactions.novo.'.$data['type'].'.create');
		else 				 	return View::make('transactions.create', compact('type'));
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

		// CATEGORIA
		$category = Category::where('name', '=', @$data['category'] )->first();
		// cria se não existir
		if( !$category ){
			$category = Category::create([
					'name' 			=> ucfirst( $data['category'] ),
					'owner_type' 	=> 'transaction'
				]);
		}			

		

		
		$now = Carbon::now();

		switch ( @$data['recurring_type'] ) {
			
			// REPETIR DIARIAMENTE
			case 'daily':
			
				// CRIA AS TRANSACTIONS
				for ($i=0; $i < $data['recurring_times']; $i++) { 

					$transaction 							= new Transaction;
					
					$transaction->type 						= isset( $data['type'] ) ? $data['type'] : 'despesa';
					$transaction->amount 					= isset( $data['amount'] ) ? $data['amount'] : '0.00';
					$transaction->description 				= isset( $data['description'] ) ? $data['description'] : '( sem descrição )';
					$transaction->date 						= ( new Carbon( $data['date'] ) )->addDays( $i )->format('Y-m-d');
					$transaction->done 						= $data['done'];
					$transaction->recurring_type 			= $data['recurring_type'];
					$transaction->recurring_times 			= ( $data['recurring_type'] != 'never' ) ? $data['recurring_times'] : '';
					$transaction->recurring_cycle 			= ( $i + 1 );					
					$transaction->category_id 				= $category->id;
					$transaction->user_id					= Auth::id();
					$transaction->save();

					$transaction_owner 						= isset( $transaction_owner ) ? $transaction_owner : $transaction->id;
					$transaction->recurring_transaction_id	= $transaction_owner;
					$transaction->save();

				}
				
				break;
			
			// REPETIR SEMAMANLMENTE
			case 'weekly':
				
				// CRIA AS TRANSACTIONS
				for ($i=0; $i < $data['recurring_times']; $i++) { 

					$transaction 							= new Transaction;
					
					$transaction->type 						= isset( $data['type'] ) ? $data['type'] : 'despesa';
					$transaction->amount 					= isset( $data['amount'] ) ? $data['amount'] : '0.00';
					$transaction->description 				= isset( $data['description'] ) ? $data['description'] : '( sem descrição )';
					$transaction->date 						= ( new Carbon( $data['date'] ) )->addWeeks( $i )->format('Y-m-d');
					$transaction->done 						= $data['done'];
					$transaction->recurring_type 			= $data['recurring_type'];
					$transaction->recurring_times 			= ( $data['recurring_type'] != 'never' ) ? $data['recurring_times'] : '';
					$transaction->recurring_cycle 			= ( $i + 1 );					
					$transaction->category_id 				= $category->id;
					$transaction->user_id					= Auth::id();
					$transaction->save();

					$transaction_owner 						= isset( $transaction_owner ) ? $transaction_owner : $transaction->id;
					$transaction->recurring_transaction_id	= $transaction_owner;
					$transaction->save();

				}

				break;			
			
			// REPETIR QUINZENALMENTE
			case 'biweekly':
				
				// CRIA AS TRANSACTIONS
				for ($i=0; $i < $data['recurring_times']; $i++) { 

					$transaction 							= new Transaction;
					
					$transaction->type 						= isset( $data['type'] ) ? $data['type'] : 'despesa';
					$transaction->amount 					= isset( $data['amount'] ) ? $data['amount'] : '0.00';
					$transaction->description 				= isset( $data['description'] ) ? $data['description'] : '( sem descrição )';
					$transaction->date 						= ( new Carbon( $data['date'] ) )->addWeeks( $i * 2 )->format('Y-m-d');
					$transaction->done 						= $data['done'];
					$transaction->recurring_type 			= $data['recurring_type'];
					$transaction->recurring_times 			= ( $data['recurring_type'] != 'never' ) ? $data['recurring_times'] : '';
					$transaction->recurring_cycle 			= ( $i + 1 );					
					$transaction->category_id 				= $category->id;
					$transaction->user_id					= Auth::id();
					$transaction->save();

					$transaction_owner 						= isset( $transaction_owner ) ? $transaction_owner : $transaction->id;
					$transaction->recurring_transaction_id	= $transaction_owner;
					$transaction->save();

				}

				break;			
			
			// REPETIR MENSALMENTE
			case 'monthly':
				
				// CRIA AS TRANSACTIONS
				for ($i=0; $i < $data['recurring_times']; $i++) { 

					$transaction 							= new Transaction;
					
					$transaction->type 						= isset( $data['type'] ) ? $data['type'] : 'despesa';
					$transaction->amount 					= isset( $data['amount'] ) ? $data['amount'] : '0.00';
					$transaction->description 				= isset( $data['description'] ) ? $data['description'] : '( sem descrição )';
					$transaction->date 						= ( new Carbon( $data['date'] ) )->addMonths( $i )->format('Y-m-d');
					$transaction->done 						= $data['done'];
					$transaction->recurring_type 			= $data['recurring_type'];
					$transaction->recurring_times 			= ( $data['recurring_type'] != 'never' ) ? $data['recurring_times'] : '';
					$transaction->recurring_cycle 			= ( $i + 1 );					
					$transaction->category_id 				= $category->id;
					$transaction->user_id					= Auth::id();
					$transaction->save();

					$transaction_owner 						= isset( $transaction_owner ) ? $transaction_owner : $transaction->id;
					$transaction->recurring_transaction_id	= $transaction_owner;
					$transaction->save();

				}

				break;	
			
			// REPETIR BIMESTRALMENTE
			case 'bimonthly':
				
				// CRIA AS TRANSACTIONS
				for ($i=0; $i < $data['recurring_times']; $i++) { 

					$transaction 							= new Transaction;
					
					$transaction->type 						= isset( $data['type'] ) ? $data['type'] : 'despesa';
					$transaction->amount 					= isset( $data['amount'] ) ? $data['amount'] : '0.00';
					$transaction->description 				= isset( $data['description'] ) ? $data['description'] : '( sem descrição )';
					$transaction->date 						= ( new Carbon( $data['date'] ) )->addMonths( $i * 2 )->format('Y-m-d');
					$transaction->done 						= $data['done'];
					$transaction->recurring_type 			= $data['recurring_type'];
					$transaction->recurring_times 			= ( $data['recurring_type'] != 'never' ) ? $data['recurring_times'] : '';
					$transaction->recurring_cycle 			= ( $i + 1 );					
					$transaction->category_id 				= $category->id;
					$transaction->user_id					= Auth::id();
					$transaction->save();

					$transaction_owner 						= isset( $transaction_owner ) ? $transaction_owner : $transaction->id;
					$transaction->recurring_transaction_id	= $transaction_owner;
					$transaction->save();

				}

				break;	
			
			// REPETIR TRIMESTRAL
			case 'trimonthly':
				
				// CRIA AS TRANSACTIONS
				for ($i=0; $i < $data['recurring_times']; $i++) { 

					$transaction 							= new Transaction;
					
					$transaction->type 						= isset( $data['type'] ) ? $data['type'] : 'despesa';
					$transaction->amount 					= isset( $data['amount'] ) ? $data['amount'] : '0.00';
					$transaction->description 				= isset( $data['description'] ) ? $data['description'] : '( sem descrição )';
					$transaction->date 						= ( new Carbon( $data['date'] ) )->addMonths( $i * 3 )->format('Y-m-d');
					$transaction->done 						= $data['done'];
					$transaction->recurring_type 			= $data['recurring_type'];
					$transaction->recurring_times 			= ( $data['recurring_type'] != 'never' ) ? $data['recurring_times'] : '';
					$transaction->recurring_cycle 			= ( $i + 1 );					
					$transaction->category_id 				= $category->id;
					$transaction->user_id					= Auth::id();
					$transaction->save();

					$transaction_owner 						= isset( $transaction_owner ) ? $transaction_owner : $transaction->id;
					$transaction->recurring_transaction_id	= $transaction_owner;
					$transaction->save();

				}

				break;	
			
			// REPETIR SEMESTRAL
			case 'sixmonthly':	

				// CRIA AS TRANSACTIONS
				for ($i=0; $i < $data['recurring_times']; $i++) { 

					$transaction 							= new Transaction;
					
					$transaction->type 						= isset( $data['type'] ) ? $data['type'] : 'despesa';
					$transaction->amount 					= isset( $data['amount'] ) ? $data['amount'] : '0.00';
					$transaction->description 				= isset( $data['description'] ) ? $data['description'] : '( sem descrição )';
					$transaction->date 						= ( new Carbon( $data['date'] ) )->addMonths( $i * 6 )->format('Y-m-d');
					$transaction->done 						= $data['done'];
					$transaction->recurring_type 			= $data['recurring_type'];
					$transaction->recurring_times 			= ( $data['recurring_type'] != 'never' ) ? $data['recurring_times'] : '';
					$transaction->recurring_cycle 			= ( $i + 1 );					
					$transaction->category_id 				= $category->id;
					$transaction->user_id					= Auth::id();
					$transaction->save();

					$transaction_owner 						= isset( $transaction_owner ) ? $transaction_owner : $transaction->id;
					$transaction->recurring_transaction_id	= $transaction_owner;
					$transaction->save();

				}

				break;	
			
			// REPETIR ANUAL
			case 'yearly':
				
				// CRIA AS TRANSACTIONS
				for ($i=0; $i < $data['recurring_times']; $i++) { 

					$transaction 							= new Transaction;
					
					$transaction->type 						= isset( $data['type'] ) ? $data['type'] : 'despesa';
					$transaction->amount 					= isset( $data['amount'] ) ? $data['amount'] : '0.00';
					$transaction->description 				= isset( $data['description'] ) ? $data['description'] : '( sem descrição )';
					$transaction->date 						= ( new Carbon( $data['date'] ) )->addYears( $i )->format('Y-m-d');
					$transaction->done 						= $data['done'];
					$transaction->recurring_type 			= $data['recurring_type'];
					$transaction->recurring_times 			= ( $data['recurring_type'] != 'never' ) ? $data['recurring_times'] : '';
					$transaction->recurring_cycle 			= ( $i + 1 );					
					$transaction->category_id 				= $category->id;
					$transaction->save();

					$transaction_owner 						= isset( $transaction_owner ) ? $transaction_owner : $transaction->id;
					$transaction->recurring_transaction_id	= $transaction_owner;
					$transaction->user_id					= Auth::id();
					$transaction->save();

				}

				break;	
			
			default:
					
					$transaction 					= new Transaction;
					$transaction->type 				= isset( $data['type'] ) ? $data['type'] : 'despesa';
					$transaction->amount 			= isset( $data['amount'] ) ? $data['amount'] : '0.00';
					$transaction->description 		= isset( $data['description'] ) ? $data['description'] : '( sem descrição )';
					$transaction->date 				= ( new Carbon( $data['date'] ) )->format('Y-m-d');
					$transaction->done 				= $data['done'];
					$transaction->category_id 		= $category->id;
					$transaction->recurring_times	= 0;
					$transaction->user_id			= Auth::id();

					$transaction->save();

					// if( $transaction ){
					// 	$alert[] = [  'class' 	=> 'alert-success',
					//               'message' => '<strong><i class="fa fa-check"></i></strong> Lançamento registrado!' ];
					// }else{
					// 	$alert[] = [  'class' 	=> 'alert-danger',
					//               'message' => '<strong><i class="fa fa-warning"></i></strong> Um erro ocorreu!' ];
					// }
				
				break;
		}


		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit;     


		//return Response::json($data);
		//exit;

		
		if( $data['recurring_times'] > 1 ){
			$alert[] = [  'class' 	=> 'alert-success',
			              'message' => '<strong><i class="fa fa-check"></i></strong> Lançamentos registrados!' ];
		}else{
			$alert[] = [  'class' 	=> 'alert-success',
			              'message' => '<strong><i class="fa fa-check"></i></strong> Lançamento registrado!' ];
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


		// LABELS
		switch ( $transaction->recurring_type ) {			
			case 'daily':
				$labels['recurring_type'] = 'diariamente';
				break;
			case 'weekly':
				$labels['recurring_type'] = 'semanalmente';
				break;
			case 'biweekly':
				$labels['recurring_type'] = 'quinzenalmente';
				break;
			case 'monthly':
				$labels['recurring_type'] = 'mensalmente';
				break;
			
			case 'bimonthly':
				$labels['recurring_type'] = 'bimestral';
				break;
			
			case 'trimonthly':
				$labels['recurring_type'] = 'trimestral';
				break;
			
			case 'sixmonthly':
				$labels['recurring_type'] = 'semestral';
				break;

			case 'yearly':
				$labels['recurring_type'] = 'anualmente';
				break;

		}		

		if (Request::ajax()) return View::make('transactions.novo.'.$transaction->type.'.show', compact('transaction', 'labels') );
		else 				 return View::make('transactions.novo.'.$transaction->type.'.show', compact('transaction', 'labels') );
		// return View::make('transactions.show', compact('transaction'));
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

		// CATEGORY
		$category = Category::find( $transaction->category_id );
		if( $category ) { $transaction->category  = $category->name; }
		// $transaction->category = Category::find( $transaction->category_id );
		//$transaction->category = ( $transaction->getCategory->name ) ? $transaction->getCategory->name : '';

		if (Request::ajax()) {	return View::make('transactions.novo.'.$transaction->type.'.edit', compact('transaction'));} 
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
		$transaction 	= Transaction::find($id);
		$transactions 	= $transaction->getRecurringTransactions;
		$validator 	 	= Validator::make($data = Input::all(), Transaction::$rules);
		if ($validator->fails())
		{
			$alert[] = [   'class' => 'alert-danger', 'message'   => '<strong><i class="fa fa-warning"></i></strong> Erro!' ];
			Session::flash('alerts', $alert);	
			return Redirect::back()->withErrors($validator)->withInput();
		}

		// DONE (bug fix)
		if( isset( $data['done'] ) and !empty( $data['done'] ) ) {
			$data['done'] = 1;
		}else{
			$data['done'] = 0;
		}

		// AMOUNT Format
		if( !isset( $data['amount'] ) ){
			$data['amount'] = $transaction->amount;
		}else{
			$data['amount'] = number_format($data['amount'], '2','.', '');
			// $data['amount'] = str_replace('.', '', $data['amount'] );
			// $data['amount'] = str_replace(',', '.', $data['amount'] );		
			// $data['amount'] = str_replace('-', '', $data['amount'] );	// TIRA O "-"				
		}

		if( $data['type'] == 'despesa' ){
			if( @$data['amount'] > 0 ){
				$data['amount'] = (0 - $data['amount']); // Deixa o número negativo
			}
		}
		

		/**
		 * 	APLLY CHANGES TO...
		 */
		
		
		// CATEGORIA
		$category = Category::where('name', '=', @$data['category'] )->first();
		if( !$category ){
			// cria se não existir
			$category = Category::create([
					'name' 			=> isset( $data['category'] ) ? ucfirst( $data['category'] ) : "",
					'owner_type' 	=> 'transaction'
				]);
		}		

		$data['apply_changes_to'] = isset( $data['apply_changes_to'] ) ? $data['apply_changes_to'] : 'this';

		switch ( $data['apply_changes_to'] ) {			
			
			case 'next':
				/**
				 * SOMENTE PRÓXIMOS
				 * @var [type]
				 */
				$transactions = $transactions->filter(function( $t )use( $transaction ){
					if( $t->date >= $transaction->date ){
						return $t;
					}
				});
				
				break;
			
			case 'unpaid':
				$transactions = $transactions->filter(function( $t )use( $transaction ){
					if( $t->done != 1 ){
						return $t;
					}
				});
				break;
			
			case 'all':				
				break;

			default:	

				// THIS
				
				$transactions = $transactions->filter(function( $t )use( $transaction ){
					if( $t->id == $transaction->id ){
						return $t;
					}
				});

				// IF NO RECURRING

				$transaction->description 	= $data['description'];
				$transaction->amount 		= $data['amount'];
				$transaction->date 			= $data['date'];
				$transaction->type 			= $data['type'];
				$transaction->done 			= $data['done'];
				$transaction->category_id 	= $category->id;								

				$transaction->save();	

				break;
			
		}


		// echo "<pre>Data:";
		// print_r($data);
		// echo "</pre>";
		// echo "<pre>Current transaction:";
		// print_r($transaction->toArray());
		// echo "</pre>";
		// echo "<pre>Alterar:";
		// print_r($transactions->toArray());
		// echo "</pre>";
		// exit;

		

		/**
		 *  APLICA ALTERAÇÔES EM TODOS ITENS JA FILTRADOS
		 */
		$transaction_date 	= new Carbon( $transaction->date );
		$new_date 			= new Carbon( $data['date'] );
		$diff_in_days		= $transaction_date->diffInDays( $new_date, false );
	
		foreach ($transactions as $t) {
			$t->description 	= $data['description'];
			$t->amount 			= $data['amount'];
			$t->type 			= $data['type'];
			$t->done 			= $data['done'];	
			$t->category_id 	= $category->id;		

			$t->date 			= (new Carbon( $t->date ) )->addDays( $diff_in_days )->format('Y-m-d');

			$t->recurring_times = $transactions->count();
			$t->category_id 	= $category->id;								

			$t->save();	
		}


		$alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Lançamento atualizado!' ];
		Session::flash('alerts', $alert);			
		
		return Redirect::to( URL::previous() );  		
	}


	/**
	 * Ask how many items to delete
	 * @param  int 		$id
	 * @return View
	 */
	public function confirmDestroy($id){
		$transaction  	= Transaction::find($id);
		$transactions   = $transaction->getRecurringTransactions;
		$data 			= Input::all();
		
		// return View::make('transactions.create');
		if ( Request::ajax() ){
			return View::make('transactions.novo.delete', compact('transaction', 'transactions'));
		}else{
			return Redirect::to( URL::previous() );
		}

	}

	/**
	 * Remove the specified transaction from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy( $id )
	{
		$data 			= Input::all();

		$transaction  	= Transaction::find( $id );
		
		$transactions   = $transaction->getRecurringTransactions->filter(function( $t ){
			if ( $t->user_id == Auth::id() ){
				return $t;
			}
		});

		if ( $transaction->user_id == Auth::id() ) {
			/**
			 * 	DESTROY ONLY...
			 */
			switch ( @$data['apply_changes_to'] ) {
				case 'this':
					Transaction::destroy( $transaction->id );			
					break;	
				
				case 'next':
					$transactions = $transactions->filter(function( $t )use( $transaction ){						
						if( $t->date >= $transaction->date ){
							return $t;
						}
					});
					// DESTROY THE ITEMS
					foreach ($transactions as $transaction) {
						Transaction::destroy( $transaction->id );			
					}					
					break;
				
				case 'unpaid':
					$transactions = $transactions->filter(function( $t ){
						if( $t->done != 1 ){
							return $t;
						}
					});
					// DESTROY THE ITEMS
					foreach ($transactions as $t) {
						Transaction::destroy( $t->id );			
					}
					break;
				
				case 'all':
					// DESTROY THE ITEMS
					// echo "<pre>";
					// print_r($transactions->count());
					// exit;

					foreach ($transactions as $t) {
						$t->destroy( $t->id );			
					}
					break;

				default:
					// SAME OF 'THIS'
					Transaction::destroy( $transaction->id );			
					break;	
			}

			

			$alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Lançamento excluído!' ];
		}else{
			$alert[] = [   'class' => 'alert-danger', 'message'   => '<strong><i class="fa fa-check"></i></strong> Sem permissão para excluir o lançamento!' ];
		}
		Session::flash('alerts', $alert);			
		return Redirect::to( URL::previous() );  
	}


	

	public function relatorios()
	{
		$data = Input::all();
		if( !isset($data['view']) )		{ $data['view'] 	 = 'month'; }
		if( !isset($data['date_from']) ){ $data['date_from'] = date('Y-m-d'); }

		// NAVIGATION
		if( !isset($data['next']) )		{ $data['next'] 	 = 0; }
		if( !isset($data['prev']) )		{ $data['prev'] 	 = 0; }

		if( @$data['next'] == @$data['prev'] ) { $data['next'] = $data['prev'] = 0; }

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit;      


		//MESSAGES
		$info = array();

	
		/*
			FILTROS DE EXIBIÇÃO
		*/	
		switch ( $data['view'] ) {

			case 'day':
				$view = "transactions.views.day";
				$date = Carbon::createFromFormat( 'Y-m-d', $data['date_from'] )
												->addDays( $data['next'] )
												->subDays( $data['prev'] );

				$transactions = Transaction::where( 'date', $date->format('Y-m-d') )->where( 'user_id', Auth::id() )->orderBy( 'date' )->get();
				
				if ( $date->isToday() ){
					$title = "hoje";
					$labels['end'] = 'fim do dia';
				}else if ( $date->isTomorrow() ){
					$title = "amanhã";
					$labels['end'] = 'depois de amanhã';
				}else if ( $date->isYesterday() ){
					$title = "ontem";
					$labels['end'] = 'hoje';
				}else{
					$title = strftime("%d de %B", strtotime( $date ));
					$labels['end'] = strftime("%A, %d de %B", strtotime( $date->addDay() ));
				}
				break;

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
	
				$title = strftime("%a %d/%m", strtotime( $date->startOfWeek() )) . " à " . strftime("%a %d/%m", strtotime( $date->endOfWeek() ));
				$labels['end'] = strftime("%A, %d de %B", strtotime( $date->endOfWeek()->addDay() ));
				break;
			
			case 'range':

				$view = "transactions.views.index";
								
				$transactions = Transaction::where( 'date', '>=', $data['date_from'] )
											 ->where( 'date', '<=', $data['date_to'] )
											 ->where( 'user_id', Auth::id() )
											 ->orderBy( 'date' )
											 ->get();	

				$date 	= Carbon::createFromFormat( 'Y-m-d', @$data['date_to'] );	

				$title = strftime("%d de %B", strtotime( $data['date_from'] )) . " à " . strftime("%d de %B", strtotime( @$data['date_to'] ));
				$labels['end'] = strftime("%A, %d de %B", strtotime( $date ));
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

				$title = "pendentes";
				$labels['end'] = strftime("%d de %B", strtotime( $date ));
				
				break;
			
			default:
				// case 'month':

				$view = "transactions.views.month";

				$date   = Carbon::createFromFormat( 'Y-m-d', $data['date_from'] )
										->addMonths( $data['next'] )
										->subMonths( $data['prev'] );
								
				$transactions = Transaction::where( 'date', '>=', $date->startOfMonth()->format('Y-m-d') )
											 ->where( 'date', '<=', $date->endOfMonth()->format('Y-m-d') )
											 ->where( 'user_id', Auth::id() )
											 ->orderBy( 'date', 'DESC' )
											 ->get();


				$title = strftime("%B de %Y", strtotime( $date ));				
				$labels['end'] = "fim de ".strftime("%B", strtotime( $date ));	
				break;			
		}
		
				

		// STATUS NO PERÍODO
		$receitas 		= $transactions->filter(function( $transaction ){ 	if( $transaction->type == 'receita' ){ return $transaction; } });	
		$receitas_ok	= $receitas->filter(function( $transaction ){ 		if( $transaction->done == '1' ){ return $transaction; } });	
		$despesas 		= $transactions->filter(function( $transaction ){ 	if( $transaction->type == 'despesa' ){ return $transaction; } });	
		$despesas_ok	= $despesas->filter(function( $transaction ){ 		if( $transaction->done == '1' ){ return $transaction; } });			
				
		$balance['receitas'] 		= $receitas->sum('amount');
		$balance['receitas_ok'] 	= $receitas_ok->sum('amount');
		$balance['despesas'] 		= $despesas->sum('amount');
		$balance['despesas_ok'] 	= $despesas_ok->sum('amount');		
		$balance['saldo'] 			= $transactions->sum('amount'); // SALDO NO PERÍODO
											 
		// SALDO ATUAL
		$balance['saldo_atual'] = Transaction::where('done', 1)->where( 'date', '<=', date('Y-m-d') )->where( 'user_id', Auth::id() )->sum('amount');
		
		// echo '<pre>';
		// print_r( $balance );
		// exit;
		
		$transactionsOverdue  = Transaction::where('done', "!=", 1)->where( 'date', '<', date('Y-m-d') )->where( 'user_id', Auth::id() )->orderBy( 'date' )->get();
		
		if ( count( $transactionsOverdue ) > 0 && $data['view'] != 'overdue' ){
			$info[] = [  'class' 	=> 'alert-warning',
			              'message' => '<strong><i class="fa fa-warning"></i></strong> Você tem <strong>'.count( $transactionsOverdue ) . '</strong> lançamentos pendentes. <a href="'. url( "financeiro/lancamentos?view=overdue" ) .'" class="">Ver lançamentos</a>' ];
	
		}

		Session::flash('info', $info);
		
		// AGRUPA POR DIA
		$transactions_days = $transactions->groupBy( function($transaction)
		{
		    return $transaction->date;
		});
		
		// echo "<pre>";
		// print_r($transactions_days);
		// echo "</pre>";
		// exit;

		/*
			DADOS PRA NAVEGAÇÃO
		*/	
		$navigation = array();
		
		$view = 'transactions.novo.relatorios';
		return View::make( $view, compact('transactions', 'transactions_days', 'view', 'title', 'data', 'balance', 'labels'));		
			
	}

}