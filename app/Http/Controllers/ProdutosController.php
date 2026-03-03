<?php

use Faker\Factory as Faker;

class ProdutosController extends \BaseController {

   /**
    * Display a listing of produtos
    *
    * @return Response
    */
   public function index()
   {   		
	   	$view  = ( Input::has('view') ) ? Input::get('view') : 'index';   		

	   	$produtos 	= Produto::orderBy('cod', 'ASC')->paginate( Input::get('paginate', 50) );  

	   	$categories = Category::where('owner_type','Produto')->get();

	   	foreach ($produtos as $produto) {
	   		$produto->cod 	= (Int)$produto->cod;
	   		$produto->preco = number_format($produto->preco, '2', ',', '.');
	   	}   
	   	$produtos->getCollection()->reverse();

	   	return View::make('produtos.index', compact('produtos','categories'));
   }

	/**
	 * Show the form for creating a new produto
	 *
	 * @return Response
	 */
	public function create()
	{
		if( Request::ajax() ){
			return View::make('produtos.panels.create');	
		}else{
			return View::make('produtos.create');
		}
	}

	/**
	 * Store a newly created produto in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Produto::$rules);

		$preco = str_replace( '.', '', $data['preco'] );
		$preco = str_replace( ',', '.', $preco );
		$data['preco'] = number_format( (float)$preco, 2, '.', '');      

		if ($validator->fails())
		{
         //Show message         
			$alert[] = [  'class' 	=> 'alert-danger',
			'message'   => '<strong><i class="fa fa-warning"></i></strong> Erros de validação!' ];
			Session::flash('alerts', $alert);
			return Redirect::back()->withErrors($validator)->withInput();
		}

		// CATEGORIA		
		if( isset( $data['category'] ) and !empty($data['category']) ){
			$category = Category::where('name', '=', $data['category'] )->first();
			if( !$category ){
				// cria se não existir
				$category = Category::create([
						'name' 			=> ucfirst( $data['category'] ),
						'owner_type' 	=> 'produto',					
					]);
			}		
			$data['category_id'] = $category->id;
		}

		$produto = Produto::create($data);

		if( $produto ){         
			$alert[] = [  'class' 	=> 'alert-success',
						'message'   => '<strong><i class="fa fa-check"></i></strong> Produto adicionado com sucesso!' ];
			Session::flash('alerts', $alert);
		};

		return Redirect::back()->withErrors($validator)->withInput(Input::all()); 
	}

	/**
	 * Display the specified produto.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$produto = Produto::find($id);

		if( $produto ){
			$produto->load('category');
			if( Request::ajax() ){
				// return Response::json( $produto );         
				return View::make('produtos.panels.edit', compact('produto'));         
			}else{
				return View::make('produtos.edit', compact('produto'));         
			}			
		}
		
		$alert[] = [  'class' 	=> 'alert-danger',
					'message'   => '<strong><i class="fa fa-warning"></i></strong> Produto não encontrado!' ];
		Session::flash('alerts', $alert);
		return Redirect::back()->withInput(Input::all());

	}

	/**
	 * Show the form for editing the specified produto.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$produto  	= Produto::find($id);        
		$categories = Category::where('owner_type','Produto')->get();

		if( Request::ajax() ){			
			return View::make('produtos.panels.edit', compact('produto','categories'));
		}else{
			return View::make('produtos.edit', compact('produto','categories'));			
		}
	}

	/**
	 * Update the specified produto in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$produto = Produto::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Produto::$rules);
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$preco = str_replace( '.', '', $data['preco'] );
		$preco = str_replace( ',', '.', $preco );
		$data['preco'] = number_format( $preco, 2, '.', '');      

		// CATEGORIA
		if( isset( $data['category'] ) and !empty($data['category']) ){
			$category = Category::where('name', '=', $data['category'] )->first();
			if( !$category ){
				// cria se não existir
				$category = Category::create([
						'name' 			=> ucfirst( $data['category'] ),
						'owner_type' 	=> 'produto',					
					]);
			}		
			$data['category_id'] = $category->id;
		};

		// UPDATE RESOURCE
		$produto->update($data);

		return Redirect::route('produtos.index');
	}

	/**
	 * Remove the specified produto from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{		
		$produto = Produto::find($id);		
		if(!$produto){
			return Redirect::back()->withInput();
		}


		if( $produto->destroy($id) ){
			$alert[] = [  'class' 	=> 'alert-success',
			'message'   => '<strong><i class="fa fa-check"></i></strong> Produto excluído!' ];
		}else{
			$alert[] = [  'class' 	=> 'alert-danger',
			'message'   => '<strong><i class="fa fa-warning"></i></strong> Não foi possível excluir o produto!' ];
		}
		Session::flash('alerts', $alert);
		return Redirect::back()->withInput();
	}


	public function categories(){
		$categories = Category::where('owner_type','Produto')->get();
		if( Request::ajax() ){
			// return Response::json( $produto );         
			return View::make('produtos.panels.categories', compact('categories'));         
		}else{
			return View::make('produtos.categories', compact('categories'));         
		}
	}

	

	public function acabamentos(){
		$produtos 	= Produto::all();  	   
	   	foreach ($produtos as $produto) {
	   		$produto->cod 	= (Int)$produto->cod;
	   		$produto->preco = number_format($produto->preco, '2', ',', '.');
	   	}   
	   	$produtos->reverse();	   	

		$acabamentos = Category::where('owner_type','Produto')->paginate( Input::get('paginate', 10) );
		if( $acabamentos ){

			if( Request::ajax() ){
				// return Response::json( $produto );         
				return View::make('produtos.panels.acabamentos', compact('produtos','acabamentos'));         
			}else{
				return View::make('produtos.index', compact('produtos','acabamentos'));         
			}
		}
		$alert[] = [  'class' 	=> 'alert-danger',
					'message'   => '<strong><i class="fa fa-warning"></i></strong> Acabamento não encontrado!' ];
		Session::flash('alerts', $alert);
		return Redirect::back()->withInput(Input::all());
	}

}
