<?php

use Carbon\Carbon as Carbon;

class NotificationsController extends \BaseController {

	/**
	 * Display a listing of notifications
	 *
	 * @return Response
	 */
	public function index()
	{

		$data 			= Input::all();
		$pagination 	= Input::has('pagination') ? Input::get('pagination') : 10;	

		// FILTRA RESULTADOS
		$notifications = Notification::where( function ( $query ){
			switch ( Input::get('view') ) {				
				case 'next':
					// AGENDADAS
					$query->where( 'date', '>', date('Y-m-d H:i:s') );		 			  
					break;
				case 'all':
					// $query->where( 'user_id', Confide::user()->id );
					break;
				default: 
					// NÃO LIDAS
					$query->where( 'date', '<', date('Y-m-d H:i:s') )
			 			  ->where( 'status', 0);				 			  
					break;						
			}

			if( Input::has('type') ){
				$query->where( 'type', Input::get('type') );
			}
			if( Input::has('owner_type') ){
				$query->where( 'owner_type', Input::get('owner_type') );
			}
			if( Input::has('owner_id') ){
				$query->where( 'owner_id', Input::get('owner_id') );
			}
			if( Input::has('order') ){
				$query->orderBy( 'date', Input::get('order') );
			}

		} )
		->where( 'user_id', Confide::user()->id )
		->orderBy( 'date', Input::get('order', 'DESC') )
		->paginate( $pagination );
		
		
		switch ( Input::get('view', 'unread') ) {
			case 'next':		 										  
				$labels['nothing'] 	= 'Nenhuma notificação agendada';
				break;
			
			case 'all':
				$labels['nothing'] 	= 'Nenhuma notificação ainda';
				break;
				
			default: // case 'unread'
				$labels['nothing'] 	= 'Nenhuma notificação não lida';
				break;
		}		
		$labels['count_next'] 	= Notification::where( 'user_id', Confide::user()->id )
					 						  ->where( 'date', '>', date('Y-m-d H:i:s') )
					 						  ->count();
		$labels['count_all'] 	= Notification::where( 'user_id', Confide::user()->id )
		                                      ->count();
		$labels['count_unread'] = Notification::where( 'user_id', Confide::user()->id )
					 						  ->where( 'date', '<', date('Y-m-d H:i:s') )
		 									  ->where( 'status', false)
	 										  ->count();

		//$notifications->getCollection()->paginate( $pagination );//->paginate( $pagination ;


		if ( Request::ajax() ) {
			return View::make('notifications.panels.index', compact('notifications','labels'));
		}else{
			return View::make('notifications.index', compact('notifications','labels'));
		}	

	}



	public function getNavigationLinks(Array $data){		

        $prev_link 					= $data;
        $prev_link['prev'] 			= isset( $prev_link['prev'] ) ? ( $prev_link['prev'] + 1 ) : 0;
        $navigation_links['prev']	= "?" . http_build_query( $prev_link, '', '&amp;');

        $next_link 					= $data;            
        $next_link['next'] 			= isset( $next_link['next'] ) ? ( $next_link['next'] + 1 ) : 0;
        $navigation_links['next'] 	= "?" . http_build_query( $next_link, '', '&amp;');

		$filter_type_all 					 = $data;
		$filter_type_all['type'] 	  		 = 'all';
		$navigation_links['filter_type_all'] = "?" . http_build_query( $filter_type_all, '', '&amp;');

		$filter_type_tarefa 					 = $data;
		$filter_type_tarefa['type'] 	  		 = 'email';
		$navigation_links['filter_type_email']  = "?" . http_build_query( $filter_type_tarefa, '', '&amp;');

		$filter_type_agendaevent 					  = $data;
		$filter_type_agendaevent['type'] 	  		  = 'notification';
		$navigation_links['filter_type_notification']  = "?" . http_build_query( $filter_type_agendaevent, '', '&amp;');



		$view_today_link		= $data;
		$view_thisweek_link		= $data;
		$view_thismonth_link	= $data;
		
		$view_today_link['view']				= 'day';
		unset( $view_today_link['next'], $view_today_link['prev'], $view_today_link['date'] );		
		$navigation_links['view_today_link']    = "?" . http_build_query( $view_today_link, '', '&amp;');

		$view_thisweek_link['view']				= 'week';
		unset( $view_thisweek_link['next'], $view_thisweek_link['prev'], $view_thisweek_link['date'] );		
		$navigation_links['view_thisweek_link'] = "?" . http_build_query( $view_thisweek_link, '', '&amp;');

		$view_thismonth_link['view']			= 'month';
		unset( $view_thismonth_link['next'], $view_thismonth_link['prev'], $view_thismonth_link['date'] );		
		$navigation_links['view_thismonth_link'] = "?" . http_build_query( $view_thismonth_link, '', '&amp;');



		// echo "<pre>";
		return $navigation_links;
	}




	public function getLabels(Array $data){

		/*
			LABELS
		*/			
		$labels 			= array();
		$labels['title'] 	= "HOJE";
		switch ( $data['view'] ) {

			case 'day':				
				$date = Carbon::createFromFormat( 'Y-m-d', $data['date'] )
												->addDays( $data['next'] )
												->subDays( $data['prev'] );				
				if ( $date->isToday() ){
					$labels['title'] = "hoje";
				}else if ( $date->isYesterday() ){
					$labels['title'] = "ontem";
				}else if ( $date->isTomorrow() ){
					$labels['title'] = "amanhã";
				}else{
					$labels['title'] = strftime("%d de %B", strtotime( $date ));
				}

				break;

			case 'week':								
				$date 		  		= Carbon::createFromFormat( 'Y-m-d', $data['date'] )
												->addWeeks( $data['next'] )
												->subWeeks( $data['prev'] );														
				$labels['title'] = strftime("%a %d/%m", strtotime( $date->startOfWeek() )) . " à " . strftime("%a %d/%m", strtotime( $date->endOfWeek() ));

				break;
						
			case 'month':		
				$date   = Carbon::createFromFormat( 'Y-m-d', $data['date'] )
										->addMonths( $data['next'] )
										->subMonths( $data['prev'] );
				$labels['title'] = strftime("%B de %Y", strtotime( $date ));				
				break;			
		}

		
		switch ( @$data['type'] ) {
			case 'email':				
				$labels['filter'] = "e-mail";
				break;
			
			case 'notification':		
				$labels['filter'] = "notificação";
				break;
			
			default:
				$labels['filter'] = "todas";
				break;
		}
	
		return $labels;

	}



	/**
	 * Show the form for creating a new notification
	 *
	 * @return Response
	 */
	public function create()
	{
		if ( Request::ajax() ) {
			return View::make('notifications.panels.create');
		}else{
			return View::make('notifications.create');
		}
	}

	/**
	 * Store a newly created notification in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
   //    	if( isset( $_POST['mandrill_events'] ) ){
   //    		// NOTIFICAÇÃO DO MANDRILL
			// $msg     = array();
			// $dados   = @$_POST['mandrill_events'];

			// $dados   = json_decode($dados);

			// // Mail Defaults
			// $msg['from']      = 'contato@lucianotonet.com';
			// $msg['from_name'] = 'L. Tonet';
			// $msg['to']        = 'tonetlds@gmail.com';

			// // SEND THE MAIL
			// Mail::send('notifications.email', compact('dados'), function($message)use($msg){
			// //$message->from('contato@lucianotonet.com', 'L. Tonet');
			// //$message->from( $msg['from'], @$msg['from_name'] );
			// $message->to( $msg['to'] );

			// $message->subject('Notificação do Mandrill');
			// });

			// // NOTIFICATION
			// $notification          = new Notification;
			// $notification->title   = 'E-mail aberto';
			// $dados                 = '<pre>'.$dados.'</pre>';
			// $notification->message = $dados;
			// $notification->save();

			// return;
   //    	}


		$validator = Validator::make($data = Input::all(), Notification::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		// echo "<pre>";
  //       print_r($data);
  //       echo "</pre>";
  //       exit;


		Notification::create($data);

		// $alert = array(                     
		// 	'alert-success' => '<strong><i class="fa fa-check"></i></strong> Notificação criada!'
		// );
		$alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Notificação criada!' ];
		Session::flash('alerts', $alert);	
		return Redirect::to( URL::previous() );  
	}

	/**
	 * Display the specified notification.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$notification = Notification::find($id);

		if( count( $notification ) < 1 ){
			$alert[] = [  'class' 	=> 'alert-danger',
			              'message' => '<strong><i class="fa fa-warning"></i></strong> Notificação não encontrado!' ];
		    Session::flash('alerts', $alert);
		    
			return Redirect::to( URL::previous() );  			    			    
		}

		if( !$notification->status ){
			$alert[] = [  'class' 	=> 'alert-success',
			              'message' => '<strong><i class="fa fa-thumbs-up"></i></strong> Notificação marcada como <strong>lida</strong>!' ];
		    Session::flash('alerts', $alert);			
			$notification->status = true;
		}
		$notification->save();


		if( !empty( $notification->owner_type ) and !empty( $notification->owner_id ) ){
			switch ( $notification->owner_type ) {
				case 'tarefa':
					return Redirect::to( 'tarefas/' . $notification->owner_id );  
					break;
				
				case 'agendaevent':
					return Redirect::to( 'agenda/' . $notification->owner_id );  
					break;

				case 'cliente':
					return Redirect::to( 'clientes/' . $notification->owner_id );  
					break;
			}
		}
		if( Request::ajax() ){
			return View::make('notifications.panels.show', compact('notification'));
		}else{
			return View::make('notifications.show', compact('notification'));
		}
	}

	/**
	 * Show the form for editing the specified notification.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$notification = Notification::find($id);

		return View::make('notifications.edit', compact('notification'));
	}

	/**
	 * Update the specified notification in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$notification = Notification::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Notification::$rules);


		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$notification->update($data);

		// $alert = array(                     
		// 	'alert-success' => '<strong><i class="fa fa-check"></i></strong> Notificação atualizada!'
		// );
		$alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Notificação atualizada!' ];
		Session::flash('alerts', $alert);	
		return Redirect::to( URL::previous() );  
	}

	/**
	 * Remove the specified notification from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{      	
	   	Notification::destroy($id);

		$alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Notificação excluída!' ];
		Session::flash('alerts', $alert);	
	
		return Redirect::to( URL::previous() );  
	}



   /**
    *    NOTIFICAÇÕES LIDAS
    *
    * @param  int  $id
    * @return Response
    */
   public function unread()
   {
      // $schema = new CreateNotificationsTable;
      // $schema->up();
      $notifications = Notification::where('status', 0)->orderBy('id','DESC')->get();

      // $notifications->filter(function($notification) {
      //    if ($notification->status) {
      //       return true;
      //    }
      // });

      print_r( count($notifications) );


      return $notifications;

   }



   /**
    * CLOSE NOTIFICATION (no destroy)
    *
    * @param  int  $id
    * @return Response
    */
   public static function fechar($id)
   {
      if(!isset($id)){
         return Response::json(array('error' => 'ID não informado'));
      }

      if( $notification = Notification::find($id) ){

      	if( $notification->status ) {
			$notification->status = 0;      		
			$notification->save();			
			$alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Notificação marcada como não lida!'];
			Session::flash('alerts', $alert);	
		
			return Redirect::to( URL::previous() );  
      	}

         $notification->close();         
      }


      return Response::json(array('success' => true));
   }



   /**
    *   EXCLUI TODAS NOTIFICAÇÔES LIDAS
    *
    * @param  int  $id
    * @return Response
    */
    public function clean()
    {
		// $schema = new CreateNotificationsTable;
		// $schema->up();
		$notifications = Notification::where('status', 1)->get();
		$total = count($notifications);

		foreach ($notifications as $notification) {
			$notification->destroy( $notification->id );
		}
     	
		$alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong>'.$total.' notificações excluídas!' ];
		Session::flash('alerts', $alert);	
	
		return Redirect::to( URL::previous() );        

    }


    /**
     * [filterResults description]
     * @return [type] [description]
     */		
    public function filterResults(){

    	$data 		  = Input::all();
		$data['view'] = isset( $data['view'] ) ? $data['view'] : 'day';
		$data['date'] = isset( $data['date'] ) ? $data['date'] : date('Y-m-d');	
		$data['next'] = isset( $data['next'] ) ? $data['next'] : 0;
		$data['prev'] = isset( $data['prev'] ) ? $data['prev'] : 0;
		$data['type'] = isset( $data['type'] ) ? $data['type'] : 'all';


    	/*
			FILTROS DE EXIBIÇÃO
		*/	
		switch ( $data['view'] ) {

			// DAY
			default:				
				$date = Carbon::createFromFormat( 'Y-m-d', $data['date_from'] )
												->addDays( $data['next'] )
												->subDays( $data['prev'] );

				$notifications = Notification::where( 'date', $date->format('Y-m-d') )->where( 'user_id', Auth::id() )->orderBy( 'date' )->get();
				break;

			case 'week':				
				$date 		  		= Carbon::createFromFormat( 'Y-m-d', $data['date_from'] )
												->addWeeks( $data['next'] )
												->subWeeks( $data['prev'] );										
										
				$notifications 		= Notification::where( 'date', '>=', $date->startOfWeek()->format('Y-m-d') )
												 ->where( 'date', '<=', $date->endOfWeek()->format('Y-m-d') )
												 ->where( 'user_id', Auth::id() )
												 ->orderBy( 'date' )
												 ->get();				
				break;
			
			case 'range':								
				$notifications = Notification::where( 'date', '>=', $data['date_from'] )
											 ->where( 'date', '<=', $data['date_to'] )
											 ->where( 'user_id', Auth::id() )
											 ->orderBy( 'date' )
											 ->get();		

				break;			
						
			case 'month':

				$view = "notifications.views.month";

				$date   = Carbon::createFromFormat( 'Y-m-d', $data['date_from'] )
										->addMonths( $data['next'] )
										->subMonths( $data['prev'] );
								
				$notifications = Notification::where( 'date', '>=', $date->startOfMonth()->format('Y-m-d') )
											 ->where( 'date', '<=', $date->endOfMonth()->format('Y-m-d') )
											 ->where( 'user_id', Auth::id() )
											 ->orderBy( 'date', 'DESC' )
											 ->get();


				$title = strftime("%B de %Y", strtotime( $date ));				
				break;			
		}
		


		// FILTERS
		if( isset( $data['filter_order'] ) and $data['filter_order'] == 'desc'){
			$notifications->sortByDesc('date'); // sort using collection method
			$labels['filter_order'] = '<i class="fa fa-chevron-down"></i>';
		}else{
			$notifications->sortBy('date'); // sort using collection method
			$labels['filter_order'] = '<i class="fa fa-chevron-up"></i>';
		}

		
		if( $data['filter_done'] ){
			$notifications = $notifications->filter( function ( $transaction ) use ($data) {
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
			$notifications = $notifications->filter( function ( $transaction ) use ($data) {
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
    }


}
