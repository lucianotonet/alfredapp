<?php

use Carbon\Carbon;

class ClienteController extends \BaseController
{
    protected $table_fields = [
        'nome',
        'empresa',
        'endereco',
        'bairro',
        'cidade',
        'cep',
        'uf',
        'telefone',
        'celular',
        'email',
        'ie',
        'cnpj',
    ];

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

            $clientes = Cliente::with('pedidos', 'conversas')
                ->where('nome', 'like', '%'.$query.'%')
                ->orWhere('empresa', 'like', '%'.$query.'%')
                ->orWhere('cidade', 'like', '%'.$query.'%')
                ->get();

            return Response::json($clientes);

        } else {

            $customers = Cliente::paginate(\Illuminate\Support\Facades\Request::get('paginate', 10));

            // get all the clientes
            if (isset($_GET['orderby'])) {
                $clientes = Cliente::with('pedidos', 'conversas')->orderBy($_GET['orderby'])->get();
            } else {
                $clientes = Cliente::with('pedidos', 'conversas')->orderBy('nome')->get();

            }

            // $pedidos = Pedido::sortBy('cliente_id')->

            $topten = Illuminate\Support\Facades\DB::DB::table(('pedidos')
                ->select('cliente_id', Illuminate\Support\Facades\DB::DB::raw(('count(*) as total'))
                ->groupBy('cliente_id')
                ->orderBy('total', 'DESC')
                ->take(10)
                ->get();

            if (count($topten)) {
                $itemIds = [];
                foreach ($topten as $cliente) {
                    $itemIds[] = $cliente->cliente_id;
                }
                $ids = implode(',', $itemIds);

                $clientes->topten = Cliente::whereIn('id', $itemIds)
                    ->orderByRaw(Illuminate\Support\Facades\DB::DB::raw(("FIELD(id, $ids)"))
                    ->take(10)
                    ->get();
            } else {
                $clientes->topten = [];
            }

            return ('clientes.index')
                ->with('clientes', $clientes)
                ->with('customers', $customers);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // load the create form (app/views/clientes/create.blade.php)
        return ('clientes.create');

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

            return Illuminate\Support\Facades\Redirect::Redirect::to(('clientes/create')
                ->withErrors($validator)
                ->withInput(\Illuminate\Support\Facades\Request::except('password'));

        } else {
            // store
            Cliente::create($this->post_to_array($this->table_fields));
            // Illuminate\Support\Facades\Session::Session::flush(();
            $alert[] = ['class' => 'alert-success', 'message' => 'Novo cliente adicionado!'];
            Illuminate\Support\Facades\Session::Session::flash(('alerts', $alert);

            return Illuminate\Support\Facades\Redirect::Redirect::to(('clientes');
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

        // Cliente
        $cliente = Cliente::find($id);
        $pedidos = Pedido::where('cliente_id', $cliente->id)->orderBy('created_at', 'desc')->with(['fornecedor'])->get();
        $conversas = Conversa::where('cliente_id', $cliente->id)->orderBy('created_at', 'desc')->get();
        $cliente->pedidos = $pedidos;
        $cliente->conversas = $conversas;

        if ($cliente) {
            $pedidos = $cliente->pedidos();

            $tarefas = Tarefa::where('cliente_id', $cliente->id)->paginate(\Illuminate\Support\Facades\Request::get('perpage', 10));
            $tarefas->days = $tarefas->groupBy(function ($tarefa) {
                return date('Y-m-d', strtotime($tarefa->start));
            });

            $hoje = date('Y-m-d');
            $ontem = Carbon::create(date('Y'), date('m'), date('d'))->subDay();
            $amanha = Carbon::create(date('Y'), date('m'), date('d'))->addDay();
            $proximo = Carbon::create(date('Y'), date('m'), date('d'))->addDay(); // Igual amanhã
            if ($proximo->isWeekend()) {
                $proximo = new Carbon('next monday');
            }

            $tarefas->pendentes = Tarefa::where('cliente_id', $cliente->id)->where('date', '<', $hoje)->where('done', 0)->orderBy('date', 'DESC')->get();
            $tarefas->hoje = Tarefa::where('cliente_id', $cliente->id)->where('date', '<', $amanha->startOfDay())->where('date', '>', $ontem)->where('done', 0)->get();

            $tarefas->nextDay = Tarefa::where('cliente_id', $cliente->id)
                ->where('done', 0)
                ->where('date', '>=', $amanha)
                ->where('date', '<', $proximo->addDay())
                ->orderBy('date', 'DESC')
                ->get();
            $tarefas->proximas = Tarefa::where('cliente_id', $cliente->id)->where('date', '>=', $amanha->startOfDay())->where('done', 0)->orderBy('date', 'ASC')->get();
            $tarefas->concluidas = Tarefa::where('cliente_id', $cliente->id)->where('done', 1)->orderBy('updated_at', 'DESC')->get();

            // show the view and pass the cliente to it
            return ('clientes.show', compact('cliente', 'tarefas'));
            // ->with( 'pedidos', $cliente->pedidos() );
        } else {
            $alert[] = ['class' => 'alert-warning', 'message' => 'O cliente que você procura não existe!'];
            Illuminate\Support\Facades\Session::Session::flash(('alerts', $alert);

            return Illuminate\Support\Facades\Redirect::Redirect::to(('clientes');
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
        // get the cliente
        $cliente = Cliente::find($id);

        // show the edit form and pass the cliente
        return ('clientes.edit')
            ->with('cliente', $cliente);
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
            return Illuminate\Support\Facades\Redirect::Redirect::to(('clientes/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput(\Illuminate\Support\Facades\Request::except('password'));
        } else {
            // store
            Cliente::where('id', $id)->update($this->post_to_array($this->table_fields));
            // Show success message
            $alert[] = ['class' => 'alert-success', 'message' => 'Cliente atualizado com sucesso!'];
            Illuminate\Support\Facades\Session::Session::flash(('alerts', $alert);

            // redirect
            return Illuminate\Support\Facades\Redirect::Redirect::to(('clientes');
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
        // Illuminate\Support\Facades\Session::Session::flash(('message', 'Um cliente randomico foi adicionado!');
        // return Illuminate\Support\Facades\Redirect::Redirect::to(('clientes');

        // get all the clientes
        $clientes = Cliente::all();

        // load the view and pass the clientes
        return ('clientes.index')
            ->with('clientes', $clientes);
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
        $cliente = Cliente::find($id);
        $cliente->delete();

        // Show success message
        $alert[] = ['class' => 'alert-success', 'message' => 'O item foi excluído com sucesso!'];
        Illuminate\Support\Facades\Session::Session::flash(('alerts', $alert);

        // redirect
        return Illuminate\Support\Facades\Redirect::Redirect::to(('clientes');
    }

    /**
     * Enviar dados do cliente por email
     *
     * @param  int  $id
     * @return Response
     */
    public function enviarcontato($id)
    {
        // delete
        $cliente = Cliente::find($id);
        echo '<pre>';
        print_r($cliente);
        echo '</pre>';
        // exit;

        $resource = Cliente::find($id);
        $email['resourcename'] = 'cliente';
        $email['fornecedores'] = Fornecedor::all();
        $email['to'] = [
            'nome' => 'Luciano T.',
            'email' => 'tonetlds@gmail.com',
        ];
        $email['cc'] = [
            'nome' => '',
            'email' => 'contato@lucianotonet.com',
        ];
        $email['content'] = 'Teste';
        $email['message'] = 'Olá, segue os dados do cliente.';

        return ('emails.create', compact('email', 'resource'));

    }

    public function getConversas($id)
    {
        return Cliente::find($id)->conversas()->get();
    }

    public function getTarefas($id)
    {
        return Cliente::find($id)->tarefas()->get();
    }

    /*

     GET Costumers
        via AJAX



    */
    public function getCostumers()
    {
        // if( Request::ajax() ){
        $query = \Illuminate\Support\Facades\Request::get('query');

        $clientes = Cliente::where('nome', 'like', '%'.$query.'%')->orWhere('empresa', 'like', '%'.$query.'%')->get();
        $fornecedores = Fornecedor::where('nome', 'like', '%'.$query.'%')->orWhere('empresa', 'like', '%'.$query.'%')->get();
        $vendedores = Vendedor::where('nome', 'like', '%'.$query.'%')->orWhere('empresa', 'like', '%'.$query.'%')->get();

        foreach ($clientes as $cliente) {
            $suggestions[] = [
                'value' => $cliente->nome.' ['.$cliente->empresa.']',
                'data' => [
                    'type' => 'Clientes ('.count($clientes).')',
                    'obj' => json_encode($cliente),
                ],
            ];
        }
        foreach ($fornecedores as $fornecedor) {
            $suggestions[] = [
                'value' => $fornecedor->nome.' ['.$fornecedor->empresa.']',
                'data' => [
                    'type' => 'Fornecedores ('.count($fornecedores).')',
                ],
            ];
        }
        foreach ($vendedores as $vendedor) {
            $suggestions[] = [
                'value' => $vendedor->nome.' ['.$vendedor->empresa.']',
                'data' => [
                    'type' => 'Vendedores ('.count($vendedores).')',
                ],
            ];
        }

        $costumers = ['suggestions' => $suggestions];

        // $costumers = Cliente::all();
        return Response::json($costumers);
        // }
    }

    public function mini($id = 0)
    {
        $costumer = Cliente::find($id);
        if ($costumer) {
            return ('clientes.panels.item', ['cliente' => $costumer]);
        } else {
            return Response::json(['error' => 'true']);
        }
    }
}
