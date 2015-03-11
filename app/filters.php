<?php
use Carbon\Carbon as Carbon;
/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{

	if( !Schema::hasTable('balance') ){

	};
	if( !Schema::hasTable('categories') ){

	};
	if( !Schema::hasTable('clientes') ){

	};
	if( !Schema::hasTable('contacts') ){

	};
	if( !Schema::hasTable('conversas') ){

	};
	if( !Schema::hasTable('despesas') ){

	};
	if( !Schema::hasTable('emails') ){

	};
	if( !Schema::hasTable('entries') ){

	};
	if( !Schema::hasTable('eventos') ){

	};
	if( !Schema::hasTable('fornecedores') ){

	};
	if( !Schema::hasTable('migrations') ){

	};
	if( !Schema::hasTable('despesas') ){

	};


	if( Confide::user() ){
		$configs = User::find( Confide::user()->id )->settings;
		foreach ($configs as $config) {

			if( !empty($config->setting_value) and Config::get( $config->setting_type.'.'.$config->setting_name ) ){
				if( json_decode($config->setting_value) ){
					$config->setting_value = json_decode($config->setting_value, 'T_ARRAY');
				};
				Config::set( $config->setting_type.'.'.$config->setting_name, $config->setting_value);			
			}
		}				
	}


	$notifications = Notification::where('status',0)->get();
	$notifications = $notifications->filter(function($notification){
		$date = Carbon::createFromFormat('Y-m-d H:i:s', $notification->date);
		if( $date->isToday() || $date->isPast() ){
			return $notification;
		}
	});
	if($notifications ){
		Session::put('notifications', $notifications);
	};

	  
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to( URL::previous() );
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
