<?php

class VendedorsController extends \BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        if (Request::ajax()) {
            $query = \Illuminate\Support\Facades\Request::get('query');

            // return Response::json($query);

            $vendedores = Illuminate\Support\Facades\DB::DB::table(('vendedors')
                ->select()
                ->where('nome', 'like', '%'.$query.'%')
                ->orWhere('empresa', 'like', '%'.$query.'%')
                ->orWhere('cidade', 'like', '%'.$query.'%')
                ->get();

            return Response::json($vendedores);

        } else {

            // get all the vendedors
            if (isset($_GET['orderby'])) {
                $vendedores = Vendedor::orderBy($_GET['orderby'])->get();
            } else {
                $vendedores = Vendedor::orderBy('nome')->get();
            }

            // load the view and pass the vendedors
            return ('vendedors.index')
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
        return ('vendedors.create');
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
        $rules = [
            // 'nome'       => 'required',
            // 'empresa'    => 'required'
        ];
        $validator = Validator::make(\Illuminate\Support\Facades\Request::all(), $rules);

        if ($validator->fails()) {

            return Illuminate\Support\Facades\Redirect::Redirect::to(('vendedors/create')
                ->withErrors($validator)
                ->withInput(\Illuminate\Support\Facades\Request::except('password'));

        } else {
            // store
            $vendedor = new Vendedor;

            $vendedor->nome = \Illuminate\Support\Facades\Request::get('nome');
            $vendedor->empresa = \Illuminate\Support\Facades\Request::get('empresa');
            $vendedor->endereco = \Illuminate\Support\Facades\Request::get('endereco');
            $vendedor->bairro = \Illuminate\Support\Facades\Request::get('bairro');
            $vendedor->cidade = \Illuminate\Support\Facades\Request::get('cidade');
            $vendedor->cep = \Illuminate\Support\Facades\Request::get('cep');
            $vendedor->uf = \Illuminate\Support\Facades\Request::get('uf');

            $vendedor->telefone = \Illuminate\Support\Facades\Request::get('telefone');
            $vendedor->celular = \Illuminate\Support\Facades\Request::get('celular');
            $vendedor->email = \Illuminate\Support\Facades\Request::get('email');
            $vendedor->cpf = \Illuminate\Support\Facades\Request::get('cpf');

            $vendedor->save();

            $alert[] = ['class' => 'alert-success', 'message' => '<strong><i class="fa fa-check"></i></strong> Novo vendedor adicionado!'];
            Illuminate\Support\Facades\Session::Session::flash(('alerts', $alert);

            return Illuminate\Support\Facades\Redirect::Redirect::to(('vendedors');
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

        if ($vendedor) {
            // show the view and pass the vendedor to it
            return ('vendedors.show')
                ->with('vendedor', $vendedor);
        } else {
            $alert[] = ['class' => 'alert-warning', 'message' => '<strong><i class="fa fa-warning"></i></strong> O vendedor que você procura não existe!'];
            Illuminate\Support\Facades\Session::Session::flash(('alerts', $alert);

            return Illuminate\Support\Facades\Redirect::Redirect::to(('vendedors');
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
        return ('vendedors.edit')
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
        $rules = [

        ];
        $validator = Validator::make(\Illuminate\Support\Facades\Request::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Illuminate\Support\Facades\Redirect::Redirect::to(('vendedors/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput(\Illuminate\Support\Facades\Request::except('password'));
        } else {
            // store
            $vendedor = Vendedor::find($id);

            $vendedor->nome = \Illuminate\Support\Facades\Request::get('nome');
            $vendedor->empresa = \Illuminate\Support\Facades\Request::get('empresa');
            $vendedor->endereco = \Illuminate\Support\Facades\Request::get('endereco');
            $vendedor->bairro = \Illuminate\Support\Facades\Request::get('bairro');
            $vendedor->cidade = \Illuminate\Support\Facades\Request::get('cidade');
            $vendedor->cep = \Illuminate\Support\Facades\Request::get('cep');
            $vendedor->uf = \Illuminate\Support\Facades\Request::get('uf');

            $vendedor->telefone = \Illuminate\Support\Facades\Request::get('telefone');
            $vendedor->celular = \Illuminate\Support\Facades\Request::get('celular');
            $vendedor->email = \Illuminate\Support\Facades\Request::get('email');
            $vendedor->cpf = \Illuminate\Support\Facades\Request::get('cpf');

            $vendedor->save();

            // Show success message
            $alert[] = ['class' => 'alert-success', 'message' => '<strong><i class="fa fa-check"></i></strong> Vendendor atualizado com sucesso!'];
            Illuminate\Support\Facades\Session::Session::flash(('alerts', $alert);

            // redirect
            return Illuminate\Support\Facades\Redirect::Redirect::to(('vendedors');
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
        // Illuminate\Support\Facades\Session::Session::flash(('message', 'Um vendedor randomico foi adicionado!');
        // return Illuminate\Support\Facades\Redirect::Redirect::to(('vendedores');

        // get all the vendedores
        $vendedores = Vendedor::all();

        // load the view and pass the vendedores
        return ('vendedors.index')
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

        // Show success message
        $alert[] = ['class' => 'alert-success', 'message' => '<strong><i class="fa fa-check"></i></strong> Item excluído com sucesso!'];
        Illuminate\Support\Facades\Session::Session::flash(('alerts', $alert);

        // redirect
        return Illuminate\Support\Facades\Redirect::Redirect::to(('vendedors');
    }
}
