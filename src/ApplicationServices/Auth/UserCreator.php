<?php

namespace Enigma\ApplicationServices\Auth;

use Enigma\ApplicationServices\Catalog\SupplierAssociateToUser;
use Enigma\ApplicationServices\Catalog\SupplierAssociateToUserCommand;
use Enigma\ApplicationServices\Catalog\SupplierAssociateToUserCommandHandler;
use Enigma\Auth\Domain\User;
use Enigma\Auth\Domain\Password;
use Enigma\Auth\Domain\UserEmail;
use Enigma\Auth\Domain\Repositories\UserRepository;
use Enigma\Catalog\Infraestructure\SupplierEloquentRepository;

class UserCreator
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return User
     */
    public function __invoke(UserEmail $email, Password $password)
    {
        $newUser = new User($email, $password);
        $newUser->getPassword()->hashPassword();
        $newUser->generateAuthToken();

        $this->userRepository->save($newUser);

        $supplierAssociate = new SupplierAssociateToUser(
            $this->userRepository,
            app(SupplierEloquentRepository::class)
        );
        $supplierAssociateHandler = new SupplierAssociateToUserCommandHandler($supplierAssociate);
        $supplierAssociateHandler(new SupplierAssociateToUserCommand($email->value()));

        $newUser = $this->userRepository->findByEmail($email);

        return $newUser;
    }
}
