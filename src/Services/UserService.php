<?php

namespace LawFirmManagement\Services;

use LawFirmManagement\Core\Validator;
use LawFirmManagement\Core\ValidationException;
use LawFirmManagement\Repositories\UserRepository;
use InvalidArgumentException;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function getAll(): array
    {
        return $this->userRepository->all();
    }

    public function create(
        string $name,
        string $email,
        string $password,
        string $role,
        string $status
    ): void {
        $validator = new Validator();
        
        $validator
            ->required('name', $name)
            ->string('name', $name)
            ->required('email', $email)
            ->email('email', $email)
            ->required('password', $password)
            ->minLength('password', $password, 8)
            ->in('role', $role, [
                'admin',
                'lawyer',
                'staff',
            ])
            ->in('status', $status, [
                'active',
                'inactive',
            ]);

        if ($validator->fails()) {
            throw new ValidationException(
                $validator->errors()
            );
        }
        
        if ($this->userRepository->findByEmail($email)) {
            throw new ValidationException([
                'email' => 'هذا البريد الإلكتروني مستخدم بالفعل.'
            ]);
        }

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $this->userRepository->create(
            $name,
            $email,
            $hashedPassword,
            $role,
            $status
        );
    }
}