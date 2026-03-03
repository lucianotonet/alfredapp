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

        return ('users.index')->with('users', $users);
    }

    /**
     * Displays the form for account creation
     *
     * @return Illuminate\Http\Response
     */
    public function create()
    {
        // return (('confide::signup_form'));

        if (Confide::user()) {
            if (Request::ajax()) {
                return ('users.panels.create');
            } else {
                return ('users.create');
            }
        } else {
            return ('users.signup');
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
                Illuminate\Support\Facades\Session::Session::flash(('alerts', $alert);
            } else {
                $alert[] = ['class' => 'alert-success',
                    'message' => '<strong><i class="fa fa-check"></i></strong> Usuário adicionado com sucesso!'];
                Illuminate\Support\Facades\Session::Session::flash(('alerts', $alert);
            }

            return Illuminate\Support\Facades\Redirect::Redirect::back(();

        }

        $repo = ('UserRepository');
        $user = $repo->signup(\Illuminate\Support\Facades\Request::all());

        if ($user->id) {
            if (('confide::signup_email')) {
                Mail::queueOn(
                    ('confide::email_queue'),
                    ('confide::email_account_confirmation'),
                    compact('user'),
                    function ($message) use ($user) {
                        $message
                            ->to($user->email, $user->username)
                            ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
                    }
                );
            }

            return Illuminate\Support\Facades\Redirect::Redirect::action(('UsersController@login')
                ->with('notice', Lang::get('confide::confide.alerts.account_created'));
        } else {
            $error = $user->errors()->all(':message');

            return Illuminate\Support\Facades\Redirect::Redirect::action(('UsersController@create')
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
        Illuminate\Support\Facades\Session::Session::flash(('alerts', $alert);

        return Illuminate\Support\Facades\Redirect::Redirect::back(()->withInput(\Illuminate\Support\Facades\Request::except('password'));

    }

    /**
     * Displays the login form
     *
     * @return Illuminate\Http\Response
     */
    public function login()
    {
        if (Confide::user()) {
            return Illuminate\Support\Facades\Redirect::Redirect::to(('/');
        } else {
            // return (('confide::login_form'));
            return ('users.login');
        }
    }

    /**
     * Attempt to do login
     *
     * @return Illuminate\Http\Response
     */
    public function doLogin()
    {
        $repo = ('UserRepository');
        $input = \Illuminate\Support\Facades\Request::all();

        if ($repo->login($input)) {
            return Illuminate\Support\Facades\Redirect::Redirect::intended(('/');
        } else {
            if ($repo->isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($repo->existsButNotConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Illuminate\Support\Facades\Redirect::Redirect::action(('UsersController@login')
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

            return Illuminate\Support\Facades\Redirect::Redirect::action(('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');

            return Illuminate\Support\Facades\Redirect::Redirect::action(('UsersController@login')
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
        // return (('confide::forgot_password_form'));
        return ('users.forgot_password');
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

            return Illuminate\Support\Facades\Redirect::Redirect::action(('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');

            return Illuminate\Support\Facades\Redirect::Redirect::action(('UsersController@doForgotPassword')
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
        // return (('confide::reset_password_form'))
        //       ->with('token', $token);
        return ('users.reset_password')
            ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     *
     * @return Illuminate\Http\Response
     */
    public function doResetPassword()
    {
        $repo = ('UserRepository');
        $input = [
            'token' => \Illuminate\Support\Facades\Request::get('token'),
            'password' => \Illuminate\Support\Facades\Request::get('password'),
            'password_confirmation' => \Illuminate\Support\Facades\Request::get('password_confirmation'),
        ];

        // By passing an array with the token, password and confirmation
        if ($repo->resetPassword($input)) {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');

            return Illuminate\Support\Facades\Redirect::Redirect::action(('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');

            return Illuminate\Support\Facades\Redirect::Redirect::action(('UsersController@resetPassword', ['token' => $input['token']])
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

        return Illuminate\Support\Facades\Redirect::Redirect::to(('/');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (! $user) {
            return Illuminate\Support\Facades\Redirect::Redirect::back(()->withInput(\Illuminate\Support\Facades\Request::all());
        }

        if ($user->destroy($id)) {
            $alert[] = ['class' => 'alert-danger',
                'message' => '<strong><i class="fa fa-warning"></i></strong> Não foi possível excluir o usuário!'];
        } else {
            $alert[] = ['class' => 'alert-success',
                'message' => '<strong><i class="fa fa-check"></i></strong> Usuário excluído!'];
        }
        Illuminate\Support\Facades\Session::Session::flash(('alerts', $alert);

        return Illuminate\Support\Facades\Redirect::Redirect::back(()->withInput();
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            if (Request::ajax()) {
                return ('users.panels.edit', compact('user'));
            } else {
                return ('users.edit', compact('user'));
            }
        } else {

            $alert[] = ['class' => 'alert-danger',
                'message' => '<strong><i class="fa fa-warning"></i></strong> Não foi possível encontrar o usuário!'];
            Illuminate\Support\Facades\Session::Session::flash(('alerts', $alert);

            if (Request::ajax()) {
                return ('users.panels.index');
            } else {
                return ('users.index');
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
