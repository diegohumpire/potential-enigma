<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Enigma\ApplicationServices\Auth\UserFinderByAuthTokenQuery;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Enigma\ApplicationServices\Auth\UserFinderByAuthTokenQueryHandler;
use Enigma\ApplicationServices\Auth\Exceptions\UnauthorizeUserException;
use Enigma\ApplicationServices\Catalog\ProductsByUserFinderQuery;
use Enigma\ApplicationServices\Catalog\ProductsByUserFinderQueryHandler;
use Enigma\Auth\Domain\User;

class GetCatalogByUserController extends Controller
{
    public function __invoke(
        Request $request, 
        UserFinderByAuthTokenQueryHandler $handlerUser, 
        ProductsByUserFinderQueryHandler $handler
    ) {
        
        $authToken = $request->header('x-auth-token', "");
        $query = new UserFinderByAuthTokenQuery($authToken);

        try {
            /** @var User */
            $user = $handlerUser($query);

            $queryCatalog = new ProductsByUserFinderQuery($user->getUserEmail(), $request->query('name'));
            $catalog = $handler($queryCatalog);
            $catalog = collect($catalog);
            $catalog = $catalog->transform(function ($element) {
                return [
                    "name" => $element->getProductName()->value(),
                    'supplier' => $element->getSupplierId()->value(),
                    'price' => $element->getProductPrice()->value()
                ];
            });

            return response()->json([
                'data' => $catalog
            ]);

        } catch (UnauthorizeUserException $exception) {
            throw new UnauthorizedHttpException($exception->getMessage());
        }
    }
}
