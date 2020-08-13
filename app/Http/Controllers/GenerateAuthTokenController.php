<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Enigma\ApplicationServices\Auth\UserAuthenticateCommand;
use Enigma\ApplicationServices\Auth\UserAuthenticateCommandHandler;
use Enigma\ApplicationServices\Auth\Exceptions\UnauthorizeUserException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class GenerateAuthTokenController extends Controller
{
    public function __invoke(Request $request, UserAuthenticateCommandHandler $handler)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'string|required|min:8'
        ]);

        $command = new UserAuthenticateCommand($request->input('email'), $request->input('password'));

        try {

            // Get result from command handler
            $response = $handler($command);

            return response()->json([
                'auth_token' => $response->getAuthToken()->value()
            ])->setStatusCode(200);

        } catch(UnauthorizeUserException $exception) {
            throw new UnauthorizedHttpException($exception->getMessage(), $exception->getMessage());
        }
    }
}
