<?php

/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class UsersController extends Controller
{
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
        return (('confide::forgot_password_form'));
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
        return (('confide::reset_password_form'))
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
}
