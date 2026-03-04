<?php

class EventosController extends \BaseController
{
    /**
     * Display a listing of eventos
     *
     * @return Response
     */
    public function index()
    {
        // CreateEventosTable::up();
        $eventos = Evento::all();

        if (Request::ajax()) {
            return $eventos;
        } else {
            return view('eventos.index', compact('eventos'));
        }

    }

    /**
     * Show the form for creating a new evento
     *
     * @return Response
     */
    public function create()
    {
        return view('eventos.create');
    }

    /**
     * Store a newly created evento in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = \Illuminate\Support\Facades\Request::all(), Evento::$rules);

        print_r($data);
        exit;

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Evento::create($data);

        return redirect()->route('eventos.index');
    }

    /**
     * Display the specified evento.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $evento = Evento::findOrFail($id);

        return view('eventos.show', compact('evento'));
    }

    /**
     * Show the form for editing the specified evento.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $evento = Evento::find($id);

        return view('eventos.edit', compact('evento'));
    }

    /**
     * Update the specified evento in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $evento = Evento::findOrFail($id);

        $validator = Validator::make($data = \Illuminate\Support\Facades\Request::all(), Evento::$rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $evento->update($data);

        return redirect()->route('eventos.index');
    }

    /**
     * Remove the specified evento from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Evento::destroy($id);

        return redirect()->route('eventos.index');
    }
}
