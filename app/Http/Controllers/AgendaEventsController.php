<?php

class AgendaEventsController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /agendaevents
	 *
	 * @return Response
	 */
	public function index()
	{
		return "AgendaEventsontroller index.";
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /agendaevents/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$data = Input::all();
		if ( Request::ajax() ) 	return View::make('agendaevents.panels.create', compact('data'));
		else 				 	return View::make('agendaevents.create', compact('data'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /agendaevents
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), AgendaEvent::$rules, AgendaEvent::$messages);
		if ($validator->fails()){
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$data['date_start']		= Input::has('date_start')	? date('Y-m-d', strtotime( $data['date_start'] ))	: NULL;
		$data['date_end']		= Input::has('date_end')	? date('Y-m-d', strtotime( $data['date_end'] ))		: NULL;                           
		$data['time_start']		= Input::has('time_start')	? date('H:i:s', strtotime( $data['time_start'] ))	: NULL;
		$data['time_end']		= Input::has('time_end')	? date('H:i:s', strtotime( $data['time_end'] ))		: NULL;  
		$data['owner_id']  		= Auth::id();

		//dd( $data );

		// CREATE AGENDA EVENT
		$agendaevent = AgendaEvent::create( $data );

		if( $agendaevent ) {
			$alert[] = [   'class'   => 'alert-success',
                		 'message'   => 'Evento agendado com sucesso!' ];   
		}else{
			$alert[] = [   'class'   => 'alert-danger',
                		 'message'   => 'Não foi possível agendar o evento.' ];   
		}
		
        Session::flash('alerts', $alert);
		return Redirect::back()->withInput();;
	}

	/**
	 * Display the specified resource.
	 * GET /agendaevents/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$event = AgendaEvent::find($id);
		if( $event ){
			if ( Request::ajax() ) 	return View::make('agendaevents.panels.edit', compact('event'));
			else 				 	return View::make('agendaevents.edit', compact('event'));
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /agendaevents/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if ( Request::ajax() ) 	return View::make('agendaevents.panels.edit');
		else 				 	return View::make('agendaevents.edit');
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /agendaevents/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$event = AgendaEvent::find($id);
		
		$validator = Validator::make($data = Input::all(), AgendaEvent::$rules, AgendaEvent::$messages);
		if ($validator->fails()){
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$data['date_start']		= Input::has('date_start')	? date('Y-m-d', strtotime( $data['date_start'] ))	: NULL;
		$data['date_end']		= Input::has('date_end')	? date('Y-m-d', strtotime( $data['date_end'] ))		: NULL;                           
		$data['time_start']		= Input::has('time_start')	? date('H:i:s', strtotime( $data['time_start'] ))	: NULL;
		$data['time_end']		= Input::has('time_end')	? date('H:i:s', strtotime( $data['time_end'] ))		: NULL;  
		$data['owner_id']  		= Auth::id();

		//dd( $data );

		// CREATE AGENDA EVENT
		$event->update( $data );

		if( $event ) {
			$alert[] = [   'class'   => 'alert-success',
                		 'message'   => 'Evento atualizado com sucesso!' ];   
		}else{
			$alert[] = [   'class'   => 'alert-danger',
                		 'message'   => 'Não foi possível atualizar o evento.' ];   
		}
		
        Session::flash('alerts', $alert);
		return Redirect::back()->withInput();;
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /agendaevents/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$event = AgendaEvent::find($id);		
		if(!$event){
			return Redirect::back()->withInput();
		}


		if( $event->destroy($id) ){
			$alert[] = [  'class' 	=> 'alert-success',
			'message'   => '<strong><i class="fa fa-check"></i></strong> Evento excluído!' ];
		}else{
			$alert[] = [  'class' 	=> 'alert-danger',
			'message'   => '<strong><i class="fa fa-warning"></i></strong> Não foi possível excluir o evento!' ];
		}
		Session::flash('alerts', $alert);
		return Redirect::back()->withInput();
	}

}