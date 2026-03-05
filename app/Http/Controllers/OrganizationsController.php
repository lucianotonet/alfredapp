<?php

class OrganizationsController extends \BaseController
{
    /**
     * Display a listing of organizations
     *
     * @return Response
     */
    public function index()
    {
        $organizations = Organization::all();

        return view('organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new organization
     *
     * @return Response
     */
    public function create()
    {
        return view('organizations.create');
    }

    /**
     * Store a newly created organization in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = \Illuminate\Support\Facades\Request::all(), Organization::$rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Organization::create($data);

        return Redirect::route('organizations.index');
    }

    /**
     * Display the specified organization.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $organization = Organization::findOrFail($id);

        return view('organizations.show', compact('organization'));
    }

    /**
     * Show the form for editing the specified organization.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $organization = Organization::find($id);

        return view('organizations.edit', compact('organization'));
    }

    /**
     * Update the specified organization in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $organization = Organization::findOrFail($id);

        $validator = Validator::make($data = \Illuminate\Support\Facades\Request::all(), Organization::$rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $organization->update($data);

        return Redirect::route('organizations.index');
    }

    /**
     * Remove the specified organization from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Organization::destroy($id);

        return Redirect::route('organizations.index');
    }
}
