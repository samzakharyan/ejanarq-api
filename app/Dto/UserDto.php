<?php

namespace App\Dto;

class UserDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $type,
        public ?string $password = null,
    ) {}
}
