<?php

class SettingsController extends \BaseController {

	/**
	 * Display a listing of settings
	 *
	 * @return Response
	 */
	public function index( $module = 'general' )
	{

		// $settings = new CreateSettingsTable;
		// $settings->down();
		// $settings->up();

		$settings  	   = Config::get('settings');
		$user_settings = Confide::user()->settings;

		// Check if view exists
		if( !View::exists('settings.'.$module) ){
			
			$alert[] = [  	'class' 	=> 'alert-warning',
		              		'message' 	=> '<strong><i class="fa fa-warning"></i></strong> Módulo de configurações não encontrado!' ];		
		    Session::flash('alerts', $alert);

			if ( Request::header('referer') ) {
				return Redirect::back();				    	
			}else{			
				$module = 'general';
			}
		}


		// echo "<pre>"; print_r( Config::get('settings') ); echo "</pre>"; exit;
		// echo "<pre>"; print_r( $requested_page ); echo "</pre>"; exit;

		return View::make('settings.index', compact('settings', 'module'));
	}

	/**
	 * Show the form for creating a new setting
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('settings.create');
	}

	/**
	 * Store a newly created setting in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Setting::$rules);

		// echo "<pre>"; print_r( $data ); echo "</pre>"; exit;

		foreach ( $data['settings'] as $config => $value) {
			
			$settings = Setting::where( 'setting_name', $config )->
								where( 'setting_type', 'settings' )->
								where( 'user_id', Confide::user()->id )->
								orderBy('id','DESC')->get();
			
			if( Config::has( 'settings.'. $config )){

				if( empty($value) ){
					foreach ($settings as $setting) {
						$setting->delete();
					}					
				}else{				
					$setting = $settings->first();
					$setting = (!$setting) ? new Setting : $setting;
				}

				$setting->setting_type 	= 'settings';
				$setting->setting_name 	= $config;
			
				if( !empty($value) and $setting->setting_value != $value ){
					$setting->setting_value = $value;					
					$setting->user_id 	= Confide::user()->id;
					$setting->save();
				}
			}
		}

		if( isset( $data['mail'] ) ){

			$data['mail']['pretend'] 	 = ( @$data['mail']['pretend'] 	  == 'on' ) ? true : false;			
			
			foreach ( $data['mail'] as $config => $value) {
				
				if( Config::has( 'mail.'. $config ) ){
					$setting = Setting::where( 'setting_name', $config )->
										where( 'setting_type', 'mail' )->
										where( 'user_id', Confide::user()->id )->
										orderBy('id','DESC')->first();
					if( !$setting ){					
						$setting 		  		= new Setting;
						$setting->setting_type 	= 'mail';
						$setting->setting_name 	= $config;
					}
					
					if( is_array($value) ){ $value = json_encode($value); }
					// echo "<pre>"; print_r( $value ); echo "</pre>"; exit;				

					if( $value != $setting->setting_value ){
						$setting->setting_value = (String)$value;					
						$setting->user_id 	= Confide::user()->id;
						$setting->save();
					}
				}
				// echo "<pre>"; print_r( $setting ); echo "</pre>";
			}						
			// echo "<pre>"; print_r( $data ); echo "</pre>";exit;
		}

		
		
		$alert[] = [  'class' 	=> 'alert-success',
		              'message' => '<strong><i class="fa fa-check"></i></strong> Configurações salvas!' ];
	
	    Session::flash('alerts', $alert);

		if ( Request::header('referer') ) {
			return Redirect::back();				    	
		}else{			
			return Redirect::route('settings.index');
		}

	}

	/**
	 * Display the specified setting.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$setting = Setting::findOrFail($id);

		return View::make('settings.show', compact('setting'));
	}

	/**
	 * Show the form for editing the specified setting.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$setting = Setting::find($id);

		return View::make('settings.edit', compact('setting'));
	}

	/**
	 * Update the specified setting in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$setting = Setting::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Setting::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$setting->update($data);

		return Redirect::route('settings.index');
	}

	/**
	 * Remove the specified setting from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Setting::destroy($id);

		return Redirect::route('settings.index');
	}


	public function reset()
	{
		$settings = Setting::where( 'user_id', Confide::user()->id )->get();
		foreach ($settings as $setting) {
			Setting::destroy( $setting->id );
		}

		$alert[] = [  'class' 	=> 'alert-success',
		              'message' => '<strong><i class="fa fa-check"></i></strong> Configurações restauradas com sucesso!' ];
	    Session::flash('alerts', $alert);

		if ( Request::header('referer') ) {
			return Redirect::back();				    	
		}else{			
			return Redirect::route('settings.index');
		}

	}

}
