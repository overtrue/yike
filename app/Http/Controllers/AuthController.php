<?php

namespace App\Http\Controllers;

use Auth;
use Lang;
use App\User;
use App\Services\Jwt;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;
use App\Http\Requests\RegisterRequest;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends ApiController
{
    use ThrottlesLogins;

    /**
     * Issue a JWT token when valid login credentials are
     * presented.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function issueToken(Request $request)
    {
        // Determine if the user has too many failed login attempts.
        if ($this->hasTooManyLoginAttempts($request)) {
            // Fire an event when a lockout occurs.
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Grab credentials from the request.
        $credentials = $request->only('email', 'password');

        // Attempt to verify the credentials and create a token for the user.
        if ($token = Auth::guard('api')->attempt($credentials)) {
            // Clear the login locks for the given user credentials.
            $this->clearLoginAttempts($request);
            // All good so return the json with token and user.
            return $this->sendLoginResponse(Auth::guard('api')->user(), $token);
        }

        // Increments login attempts.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Issue a JWT token when register a new user.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->create($request->all());

        if($token = Auth::guard('api')->fromUser($user)) {
            // All good so return the json with token and user.
            return $this->sendLoginResponse($user, $token);
        }

        // Increments login attempts.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['username'],
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Return the token and current user authenticated.
     *
     * @param App\User $user
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(User $user, $token)
    {
        // Get current user authenticated.
        $user = $this->response->transform->item($user);

        // get time to live of token form JWT service.
        $token_ttl = (new Jwt($token))->getTokenTTL();

        return $this->response->json(compact('token', 'token_ttl', 'user'));
    }

    /**
     * Return error message after determining invalid credentials.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $message = Lang::get('auth.failed');

        return $this->response->withUnauthorized($message);
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = Lang::get('auth.throttle', ['seconds' => $seconds]);

        return $this->response->withTooManyRequests($message);
    }

    /**
     * Revoke the user's token.
     *
     * @return \Illuminate\Http\Response
     */
    public function revokeToken()
    {
        Auth::guard('api')->logout();

        return $this->response->withNoContent();
    }

    /**
     * Refresh the user's token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(Request $request)
    {
        $token = Auth::guard('api')->refresh();

        // get time to live of token form JWT service.
        $token_ttl = (new Jwt($token))->getTokenTTL();

        return $this->response->json(compact('token', 'token_ttl'));
    }

    public function username()
    {
        return 'email';
    }
}
