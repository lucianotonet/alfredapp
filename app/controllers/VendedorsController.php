<?php

class VendedorsController extends \BaseController {

   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function index()
   {     

       if( Request::ajax() ){
         $query = Input::get('query');         

         //return Response::json($query);

         $vendedores = DB::table('vendedors')
                                 ->select()
                                 ->where('nome', 'like', '%'.$query.'%')                               
                                 ->orWhere('empresa', 'like', '%'.$query.'%')
                                 ->orWhere('cidade', 'like', '%'.$query.'%')                                 
                                 ->get();

         return Response::json($vendedores);

      }else{

         // get all the vendedors
         if( isset( $_GET['orderby'] ) ){
            $vendedores = Vendedor::orderBy( $_GET['orderby'] )->get();               
         }else{
            $vendedores = Vendedor::orderBy( 'nome' )->get(); 
         }
         // load the view and pass the vendedors
         return View::make('vendedors.index')
            ->with('vendedores', $vendedores);
      }

      


      

   }


   /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
   public function create()
   {
      // load the create form (app/views/vendedores/create.blade.php)
      return View::make('vendedors.create');
   }


   /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
   public function store()
   {
      // Validator
      // leia mais sobre Validator em http://laravel.com/docs/validation      
      $rules = array(
         // 'nome'       => 'required',
         // 'empresa'    => 'required'       
      );
      $validator = Validator::make(Input::all(), $rules);
      
      if ($validator->fails()) {

         return Redirect::to('vendedors/create')
            ->withErrors($validator)
            ->withInput(Input::except('password'));


      } else {
         // store
         $vendedor = new Vendedor;

         $vendedor->nome       = Input::get('nome');
         $vendedor->empresa    = Input::get('empresa');
         $vendedor->endereco   = Input::get('endereco');
         $vendedor->bairro     = Input::get('bairro');
         $vendedor->cidade     = Input::get('cidade');
         $vendedor->cep        = Input::get('cep');
         $vendedor->uf         = Input::get('uf');

         $vendedor->telefone   = Input::get('telefone');
         $vendedor->celular    = Input::get('celular');
         $vendedor->email      = Input::get('email');
         $vendedor->cpf       = Input::get('cpf');

         $vendedor->save();

                
         $alert[] = [ 'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Novo vendedor adicionado!' ];
         Session::flash('alerts', $alert);
         return Redirect::to('vendedores');
      }
   }


   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function show($id)
   {
      // get the vendedor
      $vendedor = Vendedor::find($id);

      if($vendedor){
         // show the view and pass the vendedor to it
         return View::make('vendedors.show')
            ->with('vendedor', $vendedor);
      }else{                  
         $alert[] = [ 'class' => 'alert-warning', 'message'   => '<strong><i class="fa fa-warning"></i></strong> O vendedor que você procura não existe!' ];
         Session::flash('alerts', $alert);
         return Redirect::to('vendedores');
      }

   }


   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function edit($id)
   {
      // get the vendedor
      $vendedor = Vendedor::find($id);

      // show the edit form and pass the vendedor
      return View::make('vendedors.edit')
         ->with('vendedor', $vendedor);
   }


   /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function update($id)
   {
      // validate
      // read more on validation at http://laravel.com/docs/validation
      $rules = array(
         
      );
      $validator = Validator::make(Input::all(), $rules);

      // process the login
      if ($validator->fails()) {
         return Redirect::to('vendedores/' . $id . '/edit')
            ->withErrors($validator)
            ->withInput(Input::except('password'));
      } else {
         // store
         $vendedor = Vendedor::find($id);
         
         $vendedor->nome       = Input::get('nome');
         $vendedor->empresa    = Input::get('empresa');
         $vendedor->endereco   = Input::get('endereco');
         $vendedor->bairro     = Input::get('bairro');
         $vendedor->cidade     = Input::get('cidade');
         $vendedor->cep        = Input::get('cep');
         $vendedor->uf         = Input::get('uf');

         $vendedor->telefone   = Input::get('telefone');
         $vendedor->celular    = Input::get('celular');
         $vendedor->email      = Input::get('email');         
         $vendedor->cpf       = Input::get('cpf');

         $vendedor->save();

         //Show success message
         $alert[] = [ 'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Vendendor atualizado com sucesso!' ];
         Session::flash('alerts', $alert);

         // redirect
         return Redirect::to('vendedores');
      }
   }
   

   /**
    * Adiciona um item randomico
    *
    * @return Response
    */
   public function add()
   {
         

         // // redirect
         // Session::flash('message', 'Um vendedor randomico foi adicionado!');
         // return Redirect::to('vendedores');

         // get all the vendedores
         $vendedores = Vendedor::all();      

         // load the view and pass the vendedores
         return View::make('vendedors.index')
            ->with('vendedores', $vendedores);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function destroy($id)
   {
      // delete
      $vendedor = Vendedor::find($id);
      $vendedor->delete();

      //Show success message         
         $alert[] = [ 'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Item excluído com sucesso!' ];
         Session::flash('alerts', $alert);
      
      // redirect
      return Redirect::to('vendedores');
   }


}
