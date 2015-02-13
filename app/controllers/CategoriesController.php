<?php

class CategoriesController extends \BaseController {

	/**
	 * Display a listing of categories
	 *
	 * @return Response
	 */
	public function index()
	{

		// $categories = new CreateCategoriesTable;
		// $categories->down();
		// $categories->up();
		// echo "ok";
		// exit;


		$categories = Category::all();
		$category 	= new Category;
		return View::make('categories.index', compact('categories', 'category'));
	}

	/**
	 * Show the form for creating a new category
	 *
	 * @return Response
	 */
	public function create()
	{
		$category = new Category;
		return View::make('categories.create', compact('category'));
	}

	/**
	 * Store a newly created category in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Category::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		
		$category = Category::create($data);
		if( $category ){         
			$alert[] = [  'class' 	=> 'alert-success',
			            	'message'   => '<strong><i class="fa fa-check"></i></strong> Adicionado com sucesso!' ];		
		}else{
			//Show message         
	        $alert[] = [  'class' 	=> 'alert-danger',
			              'message'   => '<strong><i class="fa fa-warning"></i></strong> Erro ao salvar o item' ];
		}
	    Session::flash('alerts', $alert);
		return Redirect::back();
	}

	/**
	 * Display the specified category.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$category = Category::find($id);

		if( !$category ){
			$alert[] = [ 'class' 	=> 'alert-danger',
     	    			 'message'  => '<strong><i class="fa fa-warning"></i></strong> A categoria não existe' ];
            Session::flash('alerts', $alert);	
		
			return Redirect::to( URL::previous() ); 
		}

		return View::make('categories.show', compact('category'));
	}

	/**
	 * Show the form for editing the specified category.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$category = Category::find($id);

		return View::make('categories.edit', compact('category'));
	}

	/**
	 * Update the specified category in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$category = Category::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Category::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		if( $category->update($data) ){
			//Show message         
	        $alert[] = [  'class' 	=> 'alert-success',
			              'message' => '<strong><i class="fa fa-check"></i></strong> Atualizado!' ];
		    Session::flash('alerts', $alert);
		}
		return Redirect::to( URL::previous() ); 

	}

	/**
	 * Remove the specified category from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if( Category::destroy($id) ){
			//Show message         
	        $alert[] = [  'class' 	=> 'alert-success',
			              'message' => '<strong><i class="fa fa-check"></i></strong> Excluído!' ];
		    Session::flash('alerts', $alert);
		}
		return Redirect::to( URL::previous() ); 
	}

}
