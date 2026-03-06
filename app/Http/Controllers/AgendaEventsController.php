<?php

class AgendaEventsController extends BaseController
{
    /**
     * Display a listing of the resource.
     * GET /agendaevents
     *
     * @return Response
     */
    public function index()
    {
        return 'AgendaEventsontroller index.';
    }

    /**
     * Show the form for creating a new resource.
     * GET /agendaevents/create
     *
     * @return Response
     */
    public function create()
    {
        $data = \Illuminate\Support\Facades\Request::all();
        if (Request::ajax()) {
            return view('agendaevents.panels.create', compact('data'));
        } else {
            return view('agendaevents.create', compact('data'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /agendaevents
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = \Illuminate\Support\Facades\Request::all(), AgendaEvent::$rules, AgendaEvent::$messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['date_start'] = \Illuminate\Support\Facades\Request::has('date_start') ? date('Y-m-d', strtotime($data['date_start'])) : null;
        $data['date_end'] = \Illuminate\Support\Facades\Request::has('date_end') ? date('Y-m-d', strtotime($data['date_end'])) : null;
        $data['time_start'] = \Illuminate\Support\Facades\Request::has('time_start') ? date('H:i:s', strtotime($data['time_start'])) : null;
        $data['time_end'] = \Illuminate\Support\Facades\Request::has('time_end') ? date('H:i:s', strtotime($data['time_end'])) : null;
        $data['owner_id'] = Auth::id();

        // dd( $data );

        // CREATE AGENDA EVENT
        $agendaevent = AgendaEvent::create($data);

        if ($agendaevent) {
            $alert[] = ['class' => 'alert-success',
                'message' => 'Evento agendado com sucesso!'];
        } else {
            $alert[] = ['class' => 'alert-danger',
                'message' => 'Não foi possível agendar o evento.'];
        }

        session()->flash('alerts', $alert);

        return redirect()->back()->withInput();
    }

    /**
     * Display the specified resource.
     * GET /agendaevents/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $event = AgendaEvent::find($id);
        if ($event) {
            if (Request::ajax()) {
                return view('agendaevents.panels.edit', compact('event'));
            } else {
                return view('agendaevents.edit', compact('event'));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     * GET /agendaevents/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        if (Request::ajax()) {
            return view('agendaevents.panels.edit');
        } else {
            return view('agendaevents.edit');
        }
    }

    /**
     * Update the specified resource in storage.
     * PUT /agendaevents/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $event = AgendaEvent::find($id);

        $validator = Validator::make($data = \Illuminate\Support\Facades\Request::all(), AgendaEvent::$rules, AgendaEvent::$messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['date_start'] = \Illuminate\Support\Facades\Request::has('date_start') ? date('Y-m-d', strtotime($data['date_start'])) : null;
        $data['date_end'] = \Illuminate\Support\Facades\Request::has('date_end') ? date('Y-m-d', strtotime($data['date_end'])) : null;
        $data['time_start'] = \Illuminate\Support\Facades\Request::has('time_start') ? date('H:i:s', strtotime($data['time_start'])) : null;
        $data['time_end'] = \Illuminate\Support\Facades\Request::has('time_end') ? date('H:i:s', strtotime($data['time_end'])) : null;
        $data['owner_id'] = Auth::id();

        // dd( $data );

        // CREATE AGENDA EVENT
        $event->update($data);

        if ($event) {
            $alert[] = ['class' => 'alert-success',
                'message' => 'Evento atualizado com sucesso!'];
        } else {
            $alert[] = ['class' => 'alert-danger',
                'message' => 'Não foi possível atualizar o evento.'];
        }

        session()->flash('alerts', $alert);

        return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /agendaevents/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $event = AgendaEvent::find($id);
        if (! $event) {
            return redirect()->back()->withInput();
        }

        if ($event->destroy($id)) {
            $alert[] = ['class' => 'alert-success',
                'message' => '<strong><i class="fa fa-check"></i></strong> Evento excluído!'];
        } else {
            $alert[] = ['class' => 'alert-danger',
                'message' => '<strong><i class="fa fa-warning"></i></strong> Não foi possível excluir o evento!'];
        }
        session()->flash('alerts', $alert);

        return redirect()->back()->withInput();
    }
}
