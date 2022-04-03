<?php  

namespace App\Http\Controllers\Auth;

use App\Models\User;

trait AuthUserTrait
{
	protected $apiToken;
	protected $user;
    protected $auth;

    protected function getAuthUser()
    {
        $http = app()->make('Client');

        /*$response = $http->request('POST', config('auth.api_url.users'), [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '. $this->apiToken,
            ],
            'body' => ['token' => $this->apiToken]
        ]);*/

        $response = $http->request('POST', config('auth.api_url.users'), [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'form_params' => [
                'api_token' => $this->apiToken,
            ],
        ]);

        $this->user = json_decode($response->getBody()->getContents(), true);

        //dd($this->user);

        $this->auth = User::findOrFail($this->user['id']);

        return $this;
    }
}