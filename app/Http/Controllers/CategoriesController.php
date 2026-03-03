<?php

class CategoriesController extends \BaseController {

	/**
	 * Display a listing of categories
	 *
	 * @return Response
	 */
	public function index()
	{
		$data 		= Input::all();
		$categories = Category::where( function( $query ){
										if( Input::has('owner_type') ){
						                	$query->where('owner_type', Input::get('owner_type') );	                
										}
										if( Input::has('query') ){
        									$query->where('name', 'like', '%'. Input::get('query') .'%');	                
        								}
        							});				            
		$types 		= Category::get(['owner_type']);
		$types 		= $types->groupBy(function( $category ){
			return $category->owner_type;
		})->toArray();

		if( Request::ajax() ) { 
			
			// SUGGESTIONS FOR AUTOCOMPLETE
			$categories = $categories->get();	

			if( Input::has('query') ){
				$suggestions = array();	

				foreach ($categories as $category) {
					$suggestions[] = array(
					                       	"value"  => $category->name,
					                       	"data"	 => array(
					                       	               'owner_type' => $category->owner_type
					                       	            )		 							
					                    );				
				}
	 			$categories = array( 'suggestions' => $suggestions );			
			 	return Response::json($categories);
			}			

			// RETURN INDEX PANEL
			return View::make('categories.panels.index', compact('categories', 'types')); 

		} else { 
			$categories = $categories->paginate( Input::get('paginate', 10) );	
			return View::make('categories.index', compact('categories', 'types')); 
		}
	}

	/**
	 * Show the form for creating a new category
	 *
	 * @return Response
	 */
	public function create()
	{
		$types = array(
					'tarefa' 		=> 'Tarefas',
					'agedaevent' 	=> 'Evento',
					'produto' 		=> 'Produtos',
					'transaction' 	=> 'Lanç. financeiro',
				);

		if( Request::ajax() ) { 
			return View::make('categories.panels.create', compact('types'));
		}else{
			return View::make('categories.create', compact('types'));
		}
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
		if( !$category ){
			$alert[] = [ 'class' 	=> 'alert-danger',
     	    			 'message'  => '<strong><i class="fa fa-warning"></i></strong> A categoria não existe' ];
            Session::flash('alerts', $alert);	
		
			return Redirect::to( URL::previous() ); 
		}else{
			if( Request::ajax() ) { 
				return View::make('categories.panels.edit', compact('category'));
			}else{
				return View::make('categories.edit', compact('category'));
			}
		}
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
