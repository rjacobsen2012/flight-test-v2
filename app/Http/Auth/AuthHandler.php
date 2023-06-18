<?php

namespace App\Http\Auth;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\StreamInterface;

trait AuthHandler
{
    protected function createUser(AuthRequest $request): ?User
    {
        $userData = [
            'name' => $request->name(),
            'email' => $request->email(),
        ];

        if (User::where($userData)->first()) {
            return null;
        }

        return User::create(array_merge($userData, [
            'password' => bcrypt($request->password())
        ]));
    }

    protected function handleLogin(AuthRequest $request): StreamInterface|JsonResponse
    {
        $requestData = $request->json()->all();
        $rules = [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ];

        $validator = Validator::make($requestData, $rules);

        if ($validator->passes()) {
            return $this->processLogin($request, new Client());
        }

        return response()->json($validator->errors());
    }

    protected function processLogin(AuthRequest $request, Client $http): StreamInterface|JsonResponse
    {
        try {

            /** @var User $user */
            $user = User::where('email', $request->email())->first();

            $response = $http->post(config('app.url').config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->email(),
                    'password' => $request->password(),
                ],
            ]);

            auth()->login($user, true);

            return $response->getBody();
        } catch (BadResponseException|GuzzleException|ModelNotFoundException $e) {
            if ($e->getCode() === 400) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid request. Please enter a valid email and password.',
                ], 400);
            } elseif ($e->getCode() === 401) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your credentials are incorrect. Please try again.',
                ], $e->getCode());
            }

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong on the server.',
            ], $e->getCode());
        }
    }
}
