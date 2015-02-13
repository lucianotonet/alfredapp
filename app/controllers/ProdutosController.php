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
   		// $produtos = new CreateProdutosTable;
   		// $produtos->down();
   		// $produtos->up();
   		// echo "OK";
   		// exit;

		$produtos 	= Produto::all();  
		$categories = Category::where('owner_type','Produto')->get();

		foreach ($produtos as $produto) {
           	$produto->preco = number_format($produto->preco, '2', ',', '.');
        }   
      
		return View::make('produtos.index', compact('produtos','categories'));
	}

	/**
	 * Show the form for creating a new produto
	 *
	 * @return Response
	 */
	public function create()
	{
		$categories = Category::where('owner_type','Produto')->get();
		return View::make('produtos.create', compact('categories'));
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

		$produto = Produto::create($data);
      if( $produto ){         
         $alert[] = [  'class' 	=> 'alert-success',
		                'message'   => '<strong><i class="fa fa-check"></i></strong> Produto adicionado om sucesso!' ];
         Session::flash('alerts', $alert);
      };

		return Redirect::route('produtos.index');
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

      if( Request::ajax() ){
         return Response::json( $produto );         
      }else{
		   return View::make('produtos.show', compact('produto'));         
      }
      
   }

	/**
	 * Show the form for editing the specified produto.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$produto  = Produto::find($id);
        $produtos = Produto::all();

		return View::make('produtos.edit', compact('produto', 'produtos'));
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

      $preco = str_replace( '.', '', $data['preco'] );
      $preco = str_replace( ',', '.', $preco );
      $data['preco'] = number_format( $preco, 2, '.', '');      

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

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
		if( Produto::destroy($id) ){
			$alert[] = [  'class' 	=> 'alert-success',
			              'message'   => '<strong><i class="fa fa-check"></i></strong> Produto excluído!' ];
		}else{
			$alert[] = [  'class' 	=> 'alert-danger',
 			              'message'   => '<strong><i class="fa fa-warning"></i></strong> Não foi possível excluir o produto!' ];
		}
	    Session::flash('alerts', $alert);


		return Redirect::route('produtos.index');
	}

}
