<?php



/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class UsersController extends Controller
{

    public function index()
    {
        $users = User::all();
        return View::make('users.index')->with('users', $users); 
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
        }else{
            return View::make('users.signup');
        }
    }

    /**
     * Stores new account
     *
     * @return  Illuminate\Http\Response
     */
    public function store()
    {

        if( Confide::user() ){

            $data = Input::all();

            $user                        = new User;
            $user->username              = $data['username'];
            $user->email                 = $data['email'];
            $user->password              = Hash::make( $data['password'] );
            $user->password_confirmation = $user->password;
            $user->confirmation_code     = md5(uniqid(mt_rand(), true));
            $user->confirmed             = 1;

            if( !$user->save() ) {
                $alert[] = [ 'class'    => 'alert-danger',
                             'message'  => '<strong><i class="fa fa-warning"></i></strong> Não foi possível adicionar o novo usuário!' ];
                Session::flash('alerts', $alert);                   
            } else {
                $alert[] = [ 'class'    => 'alert-success',
                             'message'  => '<strong><i class="fa fa-check"></i></strong> Usuário adicionado com sucesso!' ];
                Session::flash('alerts', $alert);   
            }
                
            return Redirect::back();

        }



        $repo = App::make('UserRepository');
        $user = $repo->signup(Input::all());

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

            return Redirect::action('UsersController@create')
                ->withInput(Input::except('password'))
                ->with('error', $error);
        }
    }



    public function update($id)
    {
        $user = User::find($id);
        $data = Input::all();
                    
        $user->username          = $data['username'];
        $user->email             = $data['email'];        
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->remember_token    = NULL;            

        if( !empty( $data['password'] ) ){
            $user->password              = $data['password'];                 
            $user->password_confirmation = $data['password'];
        }
       
        if( !$user->save() ){
            $alert[] = [  'class'   => 'alert-danger',
                        'message'   => '<strong><i class="fa fa-warning"></i></strong> Não foi possível alterar os dados do usuário.' ];
        }else{
            $alert[] = [  'class'   => 'alert-success',
                        'message'   => '<strong><i class="fa fa-check"></i></strong> Usuário alterado com sucesso!' ];
        }
        Session::flash('alerts', $alert);
        return Redirect::back()->withInput(Input::except('password'));

    }



    /**
     * Displays the login form
     *
     * @return  Illuminate\Http\Response
     */
    public function login()
    {
        if (Confide::user()) {
            return Redirect::to('/');
        } else {
            //return View::make(Config::get('confide::login_form'));
            return View::make( 'users.login' );
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
        //return View::make(Config::get('confide::forgot_password_form'));
        return View::make('users.forgot_password');
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
        //return View::make(Config::get('confide::reset_password_form'))
        //       ->with('token', $token);
        return View::make( 'users.reset_password' )
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
            return Redirect::action('UsersController@resetPassword', array('token'=>$input['token']))
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
            'message'   => '<strong><i class="fa fa-check"></i></strong> Usuário excluído!' ];
        }
        Session::flash('alerts', $alert);
        return Redirect::back()->withInput();
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



    public function checkusername()
    {               
        $user = User::where('username', Input::get('username'))->get();
        return $user->count();
    }

    public function checkmail()
    {
        $user = User::where('email', Input::get('email'))->get();
        return $user->count();
    }

}
