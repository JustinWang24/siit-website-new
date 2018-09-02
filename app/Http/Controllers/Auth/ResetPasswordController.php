<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/frontend/customers/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        parent::__construct();
    }

    public function showResetForm(Request $request, $token = null)
    {
        $this->dataForView['pageTitle'] = trans('general.Reset_password');
        $this->dataForView['metaKeywords'] = trans('general.Reset_password');
        $this->dataForView['metaDescription'] = trans('general.Reset_password');
        $this->dataForView['token'] = $token;
        $this->dataForView['email'] = $request->email;

        return view(_get_frontend_theme_path('customers.password.reset'), $this->dataForView);
    }
}
