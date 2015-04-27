<?php

use Carbon\Carbon as Carbon;

class AgendaController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /contacts
	 *
	 * @return Response
	 */
	public function index()
	{
		// $agenda = new CreateAgendaEventsTable;
		// $agenda->down();
		// $agenda->up();
		// exit;

		$data 		= Input::get();
		$data['view'] = Input::has('view') ? Input::get('view') : 'day';
		$data['date'] = Input::has('date') ? Input::get('date') : date('Y-m-d');	
		$data['next'] = Input::has('next') ? Input::get('next') : 0;
		$data['prev'] = Input::has('prev') ? Input::get('prev') : 0;
		$data['type'] = Input::has('type') ? Input::get('type') : NULL;

		$tarefas 		= array();
		$agendaevents 	= array();

		if( $data['type'] == 'tarefa' || $data['type'] == NULL ){
			$tarefas = $this->getTarefas( $data );	
			$tarefas = $tarefas->groupBy(function( $tarefa ){				
				return date( 'Y-m-d', strtotime($tarefa->start));
			})->toArray();		
		}

		if( $data['type'] == 'agendaevent' || $data['type'] == NULL ){
			$agendaevents = $this->getAgendaEvents( $data );		
			$agendaevents = $agendaevents->groupBy(function( $agendaevent ){				
				return date( 'Y-m-d', strtotime($agendaevent->date_start));
			})->toArray();	
		}	

		// $agendaevents['date_start'] = array_merge($tarefas['start']);
		$events = array_merge_recursive($tarefas, $agendaevents);







		// $events = array_merge($agendaevents);
		ksort( $events );
		
		// print_r( $events );
		
		$navigation_links 	= $this->getNavigationLinks( $data );
		$labels 			= $this->getLabels( $data );


		if ( Route::is('agenda.print') ){
			return View::make('agenda.print', compact('events', 'navigation_links', 'labels', 'carbon'));
		}else{
	    	return View::make('agenda.index', compact('events', 'navigation_links', 'labels', 'carbon'));	    
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
		$filter_type_all['type'] 	  		 = null;
		$navigation_links['filter_type_all'] = "?" . http_build_query( $filter_type_all, '', '&amp;');

		$filter_type_tarefa 					 = $data;
		$filter_type_tarefa['type'] 	  		 = 'tarefa';
		$navigation_links['filter_type_tarefa']  = "?" . http_build_query( $filter_type_tarefa, '', '&amp;');

		$filter_type_agendaevent 					  = $data;
		$filter_type_agendaevent['type'] 	  		  = 'agendaevent';
		$navigation_links['filter_type_agendaevent']  = "?" . http_build_query( $filter_type_agendaevent, '', '&amp;');



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
			case 'tarefa':				
				$labels['filter'] = "tarefas";
				break;
			
			case 'agendaevent':
				$labels['filter'] = "eventos";
				break;
			
			default:
				$labels['filter'] = "tudo";
				break;
		}
	
		return $labels;

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /contacts/create
	 *
	 * @return Response
	 */
	public function getAgendaEvents( $data )
	{
		switch ( $data['view'] ) {

			case 'day':				
				$date = Carbon::createFromFormat( 'Y-m-d', $data['date'] )
												->addDays( $data['next'] )
												->subDays( $data['prev'] );				
				
				$events = AgendaEvent::where( 'date_start', $date->format('Y-m-d') )->where( 'user_id', Auth::id() )->orderBy( 'date_start', 'ASC' )->get();

				break;

			case 'week':								
				$date 		  		= Carbon::createFromFormat( 'Y-m-d', $data['date'] )
												->addWeeks( $data['next'] )
												->subWeeks( $data['prev'] );														
				$events = AgendaEvent::where( 'date_start', '>=', $date->startOfWeek()->format('Y-m-d') )
												 ->where( 'date_start', '<=', $date->endOfWeek()->format('Y-m-d') )
												 ->where( 'user_id', Auth::id() )
												 ->orderBy( 'date_start', 'ASC' )
												 ->get();		

				break;
						
			case 'month':		
				$date   = Carbon::createFromFormat( 'Y-m-d', $data['date'] )
										->addMonths( $data['next'] )
										->subMonths( $data['prev'] );
				$events = AgendaEvent::where( 'date_start', '>=', $date->startOfMonth()->format('Y-m-d') )
											 ->where( 'date_start', '<=', $date->endOfMonth()->format('Y-m-d') )
											 ->where( 'user_id', Auth::id() )
											 ->orderBy( 'date_start', 'ASC' )
											 ->get();							
				break;			
		}

		return $events;
	}


	/**
	 * Show the form for creating a new resource.
	 * GET /contacts/create
	 *
	 * @return Response
	 */
	public function getTarefas( $data )
	{
		switch ( $data['view'] ) {

			case 'day':				
				$date = Carbon::createFromFormat( 'Y-m-d', $data['date'] )
												->addDays( $data['next'] )
												->subDays( $data['prev'] );				
				
				$events = Tarefa::where( 'start', $date->format('Y-m-d') )->orderBy( 'start', 'ASC' )->get();

				break;

			case 'week':								
				$date 		  		= Carbon::createFromFormat( 'Y-m-d', $data['date'] )
												->addWeeks( $data['next'] )
												->subWeeks( $data['prev'] );														
				$events = Tarefa::where( 'start', '>=', $date->startOfWeek()->format('Y-m-d') )
												 ->where( 'start', '<=', $date->endOfWeek()->format('Y-m-d') )												 
												 ->orderBy( 'start', 'ASC' )
												 ->get();		

				break;
						
			case 'month':		
				$date   = Carbon::createFromFormat( 'Y-m-d', $data['date'] )
										->addMonths( $data['next'] )
										->subMonths( $data['prev'] );
				$events = Tarefa::where( 'start', '>=', $date->startOfMonth()->format('Y-m-d') )
											 ->where( 'start', '<=', $date->endOfMonth()->format('Y-m-d') )											 
											 ->orderBy( 'start', 'ASC' )
											 ->get();							
				break;			
		}

		return $events;
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /contacts
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /contacts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /contacts/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /contacts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /contacts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}