<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    protected $user;
    protected $apiToken;

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required']
        ]);
        
        if (str_contains($credentials['username'], '@pertanian.go.id')) {
            $credentials['username'] = str_replace('@pertanian.go.id', '', $credentials['username']);
        }

        if (str_contains($credentials['username'], '-')) {
            $credentials['username'] = str_replace('-', '_', $credentials['username']);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = auth()->user();

            if (is_null($user->api_token)) {
                $user->api_token = Str::random(80);
                $user->save();
            }
 
            return redirect()->intended(route('welcome'));
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'username' => [trans('auth.failed')],
        ]);
    }

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

        Auth::logout();

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