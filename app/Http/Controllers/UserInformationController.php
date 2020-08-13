<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Enigma\ApplicationServices\Auth\UserFinderByAuthTokenQuery;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Enigma\ApplicationServices\Auth\UserFinderByAuthTokenQueryHandler;
use Enigma\ApplicationServices\Auth\Exceptions\UnauthorizeUserException;
use Enigma\Auth\Domain\User;

class UserInformationController extends Controller
{
    public function __invoke(Request $request, UserFinderByAuthTokenQueryHandler $handler)
    {
        $authToken = $request->header('x-auth-token', "");
        $query = new UserFinderByAuthTokenQuery($authToken);

        try {
            /** @var User */
            $user = $handler($query);

            return response()->json([
                'email' => $user->getUserEmail()->value(),
                'supplier_id' => $user->getSupplierId()->value()
            ]);

        } catch (UnauthorizeUserException $exception) {
            throw new UnauthorizedHttpException($exception->getMessage());
        }
    }
}
