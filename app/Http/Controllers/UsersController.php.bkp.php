<?php
/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class UsersController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct(){        
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    /**
     * Displays the form for account creation
     *
     * @return  Illuminate\Http\Response
     */
    public function create()
    {

        //return View::make(Config::get('confide::signup_form'));
        if( Confide::user() ){         
            if( Request::ajax() ){
                return View::make('users.panels.create');         
            }else{
                return View::make('users.create');        
            }
        }

    }

    public function signUp()
    {        
        return View::make('users.signup'); 
    }

    /**
     * Stores new account
     *
     * @return  Illuminate\Http\Response
     */
    public function store()
    {

        // Check password confirmation
        if( Input::get('password') != Input::get('password_confirmation') ){
            $alert[] = [   'class' => 'alert-danger', 'message'   => '<strong><i class="fa fa-warning"></i></strong> Os campos de senha estão diferentes!' ];
                Session::flash('alerts', $alert);
                return Redirect::to( 'users/create' )
                    ->withInput( Input::all() );
        }

        // Check username
        $username = User::where('username', Input::get('username'))->get();
        if ($username->count()){
                $alert[] = [   'class' => 'alert-warning', 'message'   => '<strong><i class="fa fa-warning"></i></strong> Nome de usuário já cadastrado!<br/>Utilize outro.' ];
                Session::flash('alerts', $alert);            
                return Redirect::to( URL::previous() );
            };

        // Check email
        $email = User::where('email', Input::get('email'))->get();
        if ($email->count()){
                $alert[] = [   'class' => 'alert-warning', 'message'   => '<strong><i class="fa fa-warning"></i></strong> O email '.$user->email.' já está cadastrado no sitema!<br/>Deseja recuperar a senha? <a href="'.url('users/reset_password').'">Clique aqui</a>.' ];
                Session::flash('alerts', $alert);            
                return Redirect::to( URL::previous() );
            }
        
        $repo = App::make('UserRepository');
        $user = $repo->signup(Input::all());

        if( Confide::user() ){
            if ($user->id){
                $alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Usuário adicionado!' ];
                Session::flash('alerts', $alert);            
                return Redirect::to( 'users/' );
            }else{
                $alert[] = [   'class' => 'alert-danger', 'message'   => '<strong><i class="fa fa-warning"></i></strong> Não foi possível criar o usuário!' ];
                Session::flash('alerts', $alert);
                return Redirect::to( URL::previous() )
                    ->withInput( Input::all() );        
            }
        }

        if ($user->id) {
            
            if (Config::get('confide::signup_email')) {
                Mail::queueOn(
                    Config::get('confide::email_queue'),
                    Config::get('confide::email_account_confirmation'),
                    compact('user'),
                    function ($message) use ($user) {
                        $message
                            ->to($user->email, $user->username)
                            ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
                    }
                );
            }

            return Redirect::action('UsersController@login')
                ->with('notice', Lang::get('confide::confide.alerts.account_created'));
        } else {
            $error = $user->errors()->all(':message');

            return Redirect::action('UsersController@signup')
                ->withInput(Input::except('password'))
                ->with('error', $error);
        }
    }

    /**
     * Displays the login form
     *
     * @return  Illuminate\Http\Response
     */
    public function login()
    {
        // $hash = Hash::make('254608');

        // $user = new User;
        // $user->organization_id   = 1;
        // $user->username          = 'tonetlds';
        // $user->email             = 'tonetlds@gmail.com';
        // $user->password              = $hash;
        // $user->password_confirmation = $hash;
        // $user->confirmation_code = NULL;
        // $user->remember_token    = NULL;            
        // $user->confirmed         = 1;  

        // $user->save();


        // User::create([
        //     'organization_id'   => 1,            
        //     'username'          => 'tonetlds',
        //     'email'             => 'tonetlds@gmail.com',
        //     'password'          => Hash::make('254608'),
        //     'confirmation_code' => NULL,
        //     'remember_token'    => NULL,            
        //     'confirmed'         => 1,  
        // ]);  

        // print_r( $user );
        // exit;


        if (Confide::user()) {
            return Redirect::to('/');
        } else {
            //return View::make(Config::get('confide::login_form'));
            return View::make('users.login'); 
        }
    }

    /**
     * Attempt to do login
     *
     * @return  Illuminate\Http\Response
     */
    public function doLogin()
    {

        $repo = App::make('UserRepository');
        $input = Input::all();

        if ($repo->login($input)) {
            return Redirect::intended('/');
        } else {
            if ($repo->isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($repo->existsButNotConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::action('UsersController@login')
                ->withInput(Input::except('password'))
                ->with('error', $err_msg);
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string $code
     *
     * @return  Illuminate\Http\Response
     */
    public function confirm($code)
    {
        if (Confide::confirm($code)) {
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
            return Redirect::action('UsersController@login')
                ->with('error', $error_msg);
        }
    }

    /**
     * Displays the forgot password form
     *
     * @return  Illuminate\Http\Response
     */
    public function forgotPassword()
    {
        return View::make(Config::get('confide::forgot_password_form'));
    }

    /**
     * Attempt to send change password link to the given email
     *
     * @return  Illuminate\Http\Response
     */
    public function doForgotPassword()
    {
        if (Confide::forgotPassword(Input::get('email'))) {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            return Redirect::action('UsersController@doForgotPassword')
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Shows the change password form with the given token
     *
     * @param  string $token
     *
     * @return  Illuminate\Http\Response
     */
    public function resetPassword($token)
    {
        return View::make(Config::get('confide::reset_password_form'))
                ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     *
     * @return  Illuminate\Http\Response
     */
    public function doResetPassword()
    {
        $repo = App::make('UserRepository');
        $input = array(
            'token'                 =>Input::get('token'),
            'password'              =>Input::get('password'),
            'password_confirmation' =>Input::get('password_confirmation'),
        );

        // By passing an array with the token, password and confirmation
        if ($repo->resetPassword($input)) {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            return Redirect::action('UsersController@reset_password', array('token'=>$input['token']))
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @return  Illuminate\Http\Response
     */
    public function logout()
    {
        Confide::logout();

        return Redirect::to('/');
    }

    public function index()
    {
        $users = User::all();
        return View::make('users.index')->with('users', $users); 
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        if( $user ){            
            if( Request::ajax() ){
                return View::make('users.panels.edit', compact('user'));
            }else{
                return View::make('users.edit', compact('user'));
            }            
        }else{
            
            $alert[] = [  'class'   => 'alert-danger',
            'message'   => '<strong><i class="fa fa-warning"></i></strong> Não foi possível encontrar o usuário!' ];
            Session::flash('alerts', $alert);
            
            if( Request::ajax() ){
                return View::make('users.panels.index');
            }else{
                return View::make('users.index');
            }            
        }

    }

    public function update($id)
    {
        $user      = User::findOrFail($id);
        $validator = Validator::make($data = Input::all(), User::$rules);
    
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
        } else {
            // UPDATE RESOURCE
            $user->update($data);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);               
        if(!$user){
            return Redirect::back()->withInput(Input::all());
        }


        if( $user->destroy($id) ){
            $alert[] = [  'class'   => 'alert-danger',
            'message'   => '<strong><i class="fa fa-warning"></i></strong> Não foi possível excluir o usuário!' ];
        }else{
            $alert[] = [  'class'   => 'alert-success',
            'message'   => '<strong><i class="fa fa-check"></i></strong> Úsuário excluído!' ];
        }
        Session::flash('alerts', $alert);
        return Redirect::back()->withInput();
    }

    public function checkusername($username)
    {
        $user = User::where('username', $username)->first();
        if( $user ){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    public function checkmail($email)
    {
        $user = User::where('email', $email)->first();
        if( $user ){
            echo 'true';
        }else{
            echo 'false';
        }
    }

}
