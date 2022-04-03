<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $user;
    protected $apiToken;

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
        $this->apiToken = $request->getContent();

        $this->user = User::whereApiToken($this->apiToken)->first();

        if(!$this->user){
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized',
                'status' => 'Unauthenticated',
            ], 401);
        }

        auth()->login($this->user);

        return response()->json([
            'error' => false,
            'message' => 'Successfully Login',
            'redirect' => route('welcome'),
            'api_token' => $this->apiToken,
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
        $user = auth()->user();

        $user->api_token = NULL;

        $user->save();

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