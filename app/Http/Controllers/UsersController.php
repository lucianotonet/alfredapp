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

        return view('users.index')->with('users', $users);
    }

    /**
     * Displays the form for account creation
     *
     * @return Illuminate\Http\Response
     */
    public function create()
    {
        // return view(config('confide::signup_form'));

        if (Confide::user()) {
            if (Request::ajax()) {
                return view('users.panels.create');
            } else {
                return view('users.create');
            }
        } else {
            return view('users.signup');
        }
    }

    /**
     * Stores new account
     *
     * @return Illuminate\Http\Response
     */
    public function store()
    {

        if (Confide::user()) {

            $data = \Illuminate\Support\Facades\Request::all();

            $user = new User;
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->password_confirmation = $user->password;
            $user->confirmation_code = md5(uniqid(mt_rand(), true));
            $user->confirmed = 1;

            if (! $user->save()) {
                $alert[] = ['class' => 'alert-danger',
                    'message' => '<strong><i class="fa fa-warning"></i></strong> Não foi possível adicionar o novo usuário!'];
                session()->flash('alerts', $alert);
            } else {
                $alert[] = ['class' => 'alert-success',
                    'message' => '<strong><i class="fa fa-check"></i></strong> Usuário adicionado com sucesso!'];
                session()->flash('alerts', $alert);
            }

            return redirect()->back();

        }

        $repo = App::make('UserRepository');
        $user = $repo->signup(\Illuminate\Support\Facades\Request::all());

        if ($user->id) {
            if (config('confide::signup_email')) {
                Mail::queueOn(
                    config('confide::email_queue'),
                    config('confide::email_account_confirmation'),
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
                ->withInput(\Illuminate\Support\Facades\Request::except('password'))
                ->with('error', $error);
        }
    }

    public function update($id)
    {
        $user = User::find($id);
        $data = \Illuminate\Support\Facades\Request::all();

        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->remember_token = null;

        if (! empty($data['password'])) {
            $user->password = $data['password'];
            $user->password_confirmation = $data['password'];
        }

        if (! $user->save()) {
            $alert[] = ['class' => 'alert-danger',
                'message' => '<strong><i class="fa fa-warning"></i></strong> Não foi possível alterar os dados do usuário.'];
        } else {
            $alert[] = ['class' => 'alert-success',
                'message' => '<strong><i class="fa fa-check"></i></strong> Usuário alterado com sucesso!'];
        }
        session()->flash('alerts', $alert);

        return redirect()->back()->withInput(\Illuminate\Support\Facades\Request::except('password'));

    }

    /**
     * Displays the login form
     *
     * @return Illuminate\Http\Response
     */
    public function login()
    {
        if (Confide::user()) {
            return redirect()->to('/');
        } else {
            // return view(config('confide::login_form'));
            return view('users.login');
        }
    }

    /**
     * Attempt to do login
     *
     * @return Illuminate\Http\Response
     */
    public function doLogin()
    {
        $repo = App::make('UserRepository');
        $input = \Illuminate\Support\Facades\Request::all();

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
                ->withInput(\Illuminate\Support\Facades\Request::except('password'))
                ->with('error', $err_msg);
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string  $code
     * @return Illuminate\Http\Response
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
     * @return Illuminate\Http\Response
     */
    public function forgotPassword()
    {
        // return view(config('confide::forgot_password_form'));
        return view('users.forgot_password');
    }

    /**
     * Attempt to send change password link to the given email
     *
     * @return Illuminate\Http\Response
     */
    public function doForgotPassword()
    {
        if (Confide::forgotPassword(\Illuminate\Support\Facades\Request::get('email'))) {
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
     * @param  string  $token
     * @return Illuminate\Http\Response
     */
    public function resetPassword($token)
    {
        // return view(config('confide::reset_password_form'))
        //       ->with('token', $token);
        return view('users.reset_password')
            ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     *
     * @return Illuminate\Http\Response
     */
    public function doResetPassword()
    {
        $repo = App::make('UserRepository');
        $input = [
            'token' => \Illuminate\Support\Facades\Request::get('token'),
            'password' => \Illuminate\Support\Facades\Request::get('password'),
            'password_confirmation' => \Illuminate\Support\Facades\Request::get('password_confirmation'),
        ];

        // By passing an array with the token, password and confirmation
        if ($repo->resetPassword($input)) {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');

            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');

            return Redirect::action('UsersController@resetPassword', ['token' => $input['token']])
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @return Illuminate\Http\Response
     */
    public function logout()
    {
        Confide::logout();

        return redirect()->to('/');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (! $user) {
            return redirect()->back()->withInput(\Illuminate\Support\Facades\Request::all());
        }

        if ($user->destroy($id)) {
            $alert[] = ['class' => 'alert-danger',
                'message' => '<strong><i class="fa fa-warning"></i></strong> Não foi possível excluir o usuário!'];
        } else {
            $alert[] = ['class' => 'alert-success',
                'message' => '<strong><i class="fa fa-check"></i></strong> Usuário excluído!'];
        }
        session()->flash('alerts', $alert);

        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            if (Request::ajax()) {
                return view('users.panels.edit', compact('user'));
            } else {
                return view('users.edit', compact('user'));
            }
        } else {

            $alert[] = ['class' => 'alert-danger',
                'message' => '<strong><i class="fa fa-warning"></i></strong> Não foi possível encontrar o usuário!'];
            session()->flash('alerts', $alert);

            if (Request::ajax()) {
                return view('users.panels.index');
            } else {
                return view('users.index');
            }
        }

    }

    public function checkusername()
    {
        $user = User::where('username', \Illuminate\Support\Facades\Request::get('username'))->get();

        return $user->count();
    }

    public function checkmail()
    {
        $user = User::where('email', \Illuminate\Support\Facades\Request::get('email'))->get();

        return $user->count();
    }
}
