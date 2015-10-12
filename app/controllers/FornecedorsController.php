<?php

class FornecedorsController extends \BaseController {

	/**
	 * Display a listing of fornecedors
	 *
	 * @return Response
	 */
	public function index()
	{
		$fornecedores = Fornecedor::all();      
		return View::make('fornecedors.index', compact('fornecedores'));
	}

	/**
	 * Show the form for creating a new fornecedor
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('fornecedors.create');
	}

	/**
	 * Store a newly created fornecedor in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Fornecedor::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Fornecedor::create($data);

		return Redirect::route('fornecedors.index');
	}

	/**
	 * Display the specified fornecedor.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if( Request::ajax() ){
         $fornecedor = Fornecedor::find($id);
         return Response::json($fornecedor);
      }else{
         $fornecedor = Fornecedor::find($id);
         return View::make('fornecedors.show', compact('fornecedor'));
      }
	}

	/**
	 * Show the form for editing the specified fornecedor.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$fornecedor = Fornecedor::find($id);

		return View::make('fornecedors.edit', compact('fornecedor'));
	}

	/**
	 * Update the specified fornecedor in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$fornecedor = Fornecedor::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Fornecedor::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$fornecedor->update($data);

		return Redirect::route('fornecedors.index');
	}

	/**
	 * Remove the specified fornecedor from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Fornecedor::destroy($id);

		return Redirect::route('fornecedors.index');
	}

}
