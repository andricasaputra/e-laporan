<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers, AuthUserTrait;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/intern/welcome';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    public function autoLogin(Request $request)
    {
        $this->accessToken = $request->getContent();

        $this->getAuthUser();

        if(!$this->auth){
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized',
                'status' => 'Unauthenticated',
            ], 401);
        }

        auth()->login($this->auth);

        return response()->json([
            'error' => false,
            'message' => 'Successfully Login',
            'redirect' => route('welcome'),
            'access_token' => $this->accessToken,
            'token_type' => 'Bearer',
            'status' => 'Authenticated'
        ], 200);

    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        session()->flash('logout', 'logout');

        return response()->json([
            'redirect' => route('login'),
            'action' => 'logout',
            'message' => 'Successfully logged out'
        ]);
    }
    
}