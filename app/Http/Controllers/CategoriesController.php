<?php

class CategoriesController extends \BaseController
{
    /**
     * Display a listing of categories
     *
     * @return Response
     */
    public function index()
    {
        $data = \Illuminate\Support\Facades\Request::all();
        $categories = Category::where(function ($query) {
            if (\Illuminate\Support\Facades\Request::has('owner_type')) {
                $query->where('owner_type', \Illuminate\Support\Facades\Request::get('owner_type'));
            }
            if (\Illuminate\Support\Facades\Request::has('query')) {
                $query->where('name', 'like', '%'.\Illuminate\Support\Facades\Request::get('query').'%');
            }
        });
        $types = Category::get(['owner_type']);
        $types = $types->groupBy(function ($category) {
            return $category->owner_type;
        })->toArray();

        if (Request::ajax()) {

            // SUGGESTIONS FOR AUTOCOMPLETE
            $categories = $categories->get();

            if (\Illuminate\Support\Facades\Request::has('query')) {
                $suggestions = [];

                foreach ($categories as $category) {
                    $suggestions[] = [
                        'value' => $category->name,
                        'data' => [
                            'owner_type' => $category->owner_type,
                        ],
                    ];
                }
                $categories = ['suggestions' => $suggestions];

                return Response::json($categories);
            }

            // RETURN INDEX PANEL
            return view('categories.panels.index', compact('categories', 'types'));

        } else {
            $categories = $categories->paginate(\Illuminate\Support\Facades\Request::get('paginate', 10));

            return view('categories.index', compact('categories', 'types'));
        }
    }

    /**
     * Show the form for creating a new category
     *
     * @return Response
     */
    public function create()
    {
        $types = [
            'tarefa' => 'Tarefas',
            'agedaevent' => 'Evento',
            'produto' => 'Produtos',
            'transaction' => 'Lanç. financeiro',
        ];

        if (Request::ajax()) {
            return view('categories.panels.create', compact('types'));
        } else {
            return view('categories.create', compact('types'));
        }
    }

    /**
     * Store a newly created category in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = \Illuminate\Support\Facades\Request::all(), Category::$rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = Category::create($data);
        if ($category) {
            $alert[] = ['class' => 'alert-success',
                'message' => '<strong><i class="fa fa-check"></i></strong> Adicionado com sucesso!'];
        } else {
            // Show message
            $alert[] = ['class' => 'alert-danger',
                'message' => '<strong><i class="fa fa-warning"></i></strong> Erro ao salvar o item'];
        }
        session()->flash('alerts', $alert);

        return redirect()->back();
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

        if (! $category) {
            $alert[] = ['class' => 'alert-danger',
                'message' => '<strong><i class="fa fa-warning"></i></strong> A categoria não existe'];
            session()->flash('alerts', $alert);

            return redirect()->to(URL::previous());
        }

        return view('categories.show', compact('category'));
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
        if (! $category) {
            $alert[] = ['class' => 'alert-danger',
                'message' => '<strong><i class="fa fa-warning"></i></strong> A categoria não existe'];
            session()->flash('alerts', $alert);

            return redirect()->to(URL::previous());
        } else {
            if (Request::ajax()) {
                return view('categories.panels.edit', compact('category'));
            } else {
                return view('categories.edit', compact('category'));
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

        $validator = Validator::make($data = \Illuminate\Support\Facades\Request::all(), Category::$rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($category->update($data)) {
            // Show message
            $alert[] = ['class' => 'alert-success',
                'message' => '<strong><i class="fa fa-check"></i></strong> Atualizado!'];
            session()->flash('alerts', $alert);
        }

        return redirect()->to(URL::previous());

    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if (Category::destroy($id)) {
            // Show message
            $alert[] = ['class' => 'alert-success',
                'message' => '<strong><i class="fa fa-check"></i></strong> Excluído!'];
            session()->flash('alerts', $alert);
        }

        return redirect()->to(URL::previous());
    }
}
