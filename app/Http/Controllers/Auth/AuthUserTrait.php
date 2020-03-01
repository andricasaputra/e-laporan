<?php  

namespace App\Http\Controllers\Auth;

use App\Models\User;

trait AuthUserTrait
{
	protected $accessToken;
	protected $user;
    protected $auth;

    protected function getAuthUser()
    {
        $http = app()->make('Client');

        $response = $http->request('POST', config('auth.api_url.users'), [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '. $this->accessToken,
            ],
        ]);

        $this->user = json_decode($response->getBody()->getContents(), true);

        $this->auth = User::findOrFail($this->user['id']);

        return $this;
    }
}