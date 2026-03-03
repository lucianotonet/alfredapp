<?php

class NotesController extends \BaseController {

	/**
	 * Display a listing of notes
	 *
	 * @return Response
	 */
	public function index()
	{
		$notes = Note::all();

		return View::make('notes.index', compact('notes'));
	}

	/**
	 * Show the form for creating a new note
	 *
	 * @return Response
	 */
	public function create()
	{
      if (Request::ajax()) {
         return View::make('notes.panels.create');
      } else {         
         return View::make('notes.create');
      }
	}

	/**
	 * Store a newly created note in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Note::$rules);

      if (Request::ajax()) {

         $note = Note::create($data);
         return View::make('notes.panels.show', compact('note'));

      } else {         

         if ($validator->fails())
         {
            return Redirect::back()->withErrors($validator)->withInput();
         }

         return View::make('notes.create');
      }

		return Redirect::route('notes.index');
	}

	/**
	 * Display the specified note.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$note = Note::findOrFail($id);

		return View::make('notes.show', compact('note'));
	}

	/**
	 * Show the form for editing the specified note.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$note = Note::find($id);

		return View::make('notes.edit', compact('note'));
	}

	/**
	 * Update the specified note in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$note = Note::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Note::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$note->update($data);

		return Redirect::route('notes.index');
	}

	/**
	 * Remove the specified note from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Note::destroy($id);

		return Redirect::route('notes.index');
	}

}
