<?php

namespace App\Services;

use App\Dto\UserDto;
use App\Repositories\UserRepository;
use App\UserTypeEnum;
use Illuminate\Auth\Events\Registered;

class UserService
{
    public function __construct(
        private UserRepository $repository
    ) {}

    /**
     * Creates a user from the provided DTO.
     * 
     * @param UserDto $userDto
     * @return string|null
     */
    public function createUser(UserDto $userDto): ?string
    {
        $user = $this->repository->createUser([
            'first_name' => $userDto->firstName ?? null,
            'last_name' => $userDto->lastName ?? null,
            'name' => $userDto->name ?? null,
            'tax_id' => $userDto->taxId ?? null,
            'email' => $userDto->email,
            'type' => $userDto->type,
            'password' => $userDto->password,
        ]);

        if ($userDto->type === UserTypeEnum::USER) {
            event(new Registered($userDto));

            return $user->createToken('api-token')->accessToken;
        }

        return null;
    }
}
