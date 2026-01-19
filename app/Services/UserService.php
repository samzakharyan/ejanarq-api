<?php

namespace App\Services;

use App\Dto\UserDto;
use App\Repositories\UserRepository;
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
     * @return string
     */
    public function createUser(UserDto $userDto): string
    {
        $user = $this->repository->createUser([
            'first_name' => $userDto->firstName,
            'last_name' => $userDto->lastName,
            'email' => $userDto->email,
            'type' => $userDto->type,
            'password' => $userDto->password,
        ]);
        event(new Registered($userDto));

        return $user->createToken('api-token')->accessToken;
    }
}
