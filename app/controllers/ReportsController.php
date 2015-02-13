<?php

use Carbon\Carbon;

class ReportsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /reports
	 *
	 * @return Response
	 */
	public function index()
	{

      $reports = Report::orderBy('id', 'DESC')->get();    

      echo "<pre>";
      print_r( $reports );
      echo "</pre>";
      exit;

      $hoje                = Carbon::now()->today();
      $ontem               = Carbon::now()->yesterday();      
      $anteontem           = Carbon::now()->subDays(2);

      $reports->hoje       = Report::where('created_at', '>=', $hoje )->orderBy('id', 'DESC')->get();
      $reports->ontem      = Report::where('created_at', '=',  $ontem )->orderBy('id', 'DESC')->get();
      $reports->anteontem  = Report::where('created_at', '=',  $anteontem )->orderBy('id', 'DESC')->get();
      $reports->anteriores = Report::where('created_at', '<',  Carbon::now()->subDays(2) )->orderBy('id', 'DESC')->get();

   
      if ($reports->hoje) {
         foreach ($reports->hoje as $report) {
            // Get HOUR:MINUTE from CREATED_AT
            $date         = Carbon::createFromFormat('Y-m-d H:i:s', $report->created_at);            
            $report->date = $date->hour . ':' . $date->minute;            
         }
         
      }  

      if ($reports->ontem) {
         foreach ($reports->ontem as $report) {
            // Get HOUR:MINUTE from CREATED_AT
            $date         = Carbon::createFromFormat('Y-m-d H:i:s', $report->created_at);            
            $report->date = $date->hour . ':' . $date->minute;            
         }
      }  

       return View::make('reports.index', compact('reports') );          


	}

	/**
	 * Show the form for creating a new resource.
	 * GET /reports/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /reports
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /reports/{id}
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
	 * GET /reports/{id}/edit
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
	 * PUT /reports/{id}
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
	 * DELETE /reports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}