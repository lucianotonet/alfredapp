<?php

use Carbon\Carbon;

class MovimentosController extends \BaseController {

	/**
	 * Display a listing of movimentos
	 *
	 * @return Response
	 */
	public function index()
	{
		$movimentos = Movimento::all();
      $movimentos = Movimento::orderBy('id', 'DESC')->get();    

      //print_r( $this->getDates() );

      $hoje                = Carbon::now()->today();
      $ontem               = Carbon::now()->yesterday();      
      $anteontem           = Carbon::now()->subDays(2);

      $movimentos->hoje       = Movimento::where( 'data', '>=', $hoje )->orderBy('id', 'DESC')->get();
      $movimentos->ontem      = Movimento::where( 'data', '=',  $ontem )->orderBy('id', 'DESC')->get();
      $movimentos->anteontem  = Movimento::where( 'data', '=',  $anteontem )->orderBy('id', 'DESC')->get();
      $movimentos->anteriores = Movimento::where( 'data', '<',  Carbon::now()->subDays(2) )->orderBy('id', 'DESC')->get();

   
      if ($movimentos->hoje) {
         foreach ($movimentos->hoje as $movimento) {
            // Get HOUR:MINUTE from CREATED_AT
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            $date                      = Carbon::createFromFormat('Y-m-d', $movimento->data); 
            $movimento->data           = $date->formatLocalized('%A, %d de %B'); 
            $movimentos->hoje->total  += $movimento->valor;
         }
         
      }  

      if ($movimentos->ontem) {
         foreach ($movimentos->ontem as $movimento) {
            // Get HOUR:MINUTE from CREATED_AT
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            $date                       = Carbon::createFromFormat('Y-m-d', $movimento->data); 
            $movimento->data            = $date->formatLocalized('%A, %d de %B');                 
            $movimentos->ontem->total  += $movimento->valor;
         }
      }  

      return View::make('movimentos.index', compact('movimentos') );          
	}

	/**
	 * Show the form for creating a new movimento
	 *
	 * @return Response
	 */
	public function create()
	{
      if (Request::ajax()) {
         return View::make('movimentos.panels.create' );
      } else {
         return View::make('movimentos.create' );
      }		
	}

	/**
	 * Store a newly created movimento in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Movimento::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Movimento::create($data);

		return Redirect::route('movimentos.index');
	}

	/**
	 * Display the specified movimento.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$movimento = Movimento::findOrFail($id);

		return View::make('movimentos.show', compact('movimento'));
	}

	/**
	 * Show the form for editing the specified movimento.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$movimento = Movimento::find($id);

		return View::make('movimentos.edit', compact('movimento'));
	}

	/**
	 * Update the specified movimento in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$movimento = Movimento::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Movimento::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$movimento->update($data);

		return Redirect::route('movimentos.index');
	}

	/**
	 * Remove the specified movimento from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Movimento::destroy($id);

		return Redirect::route('movimentos.index');
	}

}
