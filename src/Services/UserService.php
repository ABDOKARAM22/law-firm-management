<?php

namespace LawFirmManagement\Services;

use InvalidArgumentException;
use LawFirmManagement\Core\Auth;
use LawFirmManagement\Core\ValidationException;
use LawFirmManagement\Core\Validator;
use LawFirmManagement\Repositories\UserRepository;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private Auth $auth
    ) {
    }

    public function getAll(): array
    {
        return $this->userRepository->all();
    }


    public function find(int $id): ?array
    {
        return $this->userRepository->findById($id);
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
            ->alpha('name', $name)
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


        public function update(
        int $id,
        string $name,
        string $email,
        string $role,
        string $status
    ): void {
        $validator = new Validator();

        $validator
            ->required('name', $name)
            ->string('name', $name)
            ->alpha('name', $name)
            ->required('email', $email)
            ->email('email', $email)
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

        if (
            $this->userRepository->existsByEmailExceptId(
                $email,
                $id
            )
        ) {
            throw new ValidationException([
                'email' => 'هذا البريد الإلكتروني مستخدم بالفعل.'
            ]);
        }



    $currentUser = $this->userRepository->findById($id);

    if ($currentUser === null) {
        throw new ValidationException([
            'user' => 'المستخدم غير موجود.'
        ]);
    }

    $isCurrentUserActiveAdmin =
        $currentUser['role'] === 'admin'
        && $currentUser['status'] === 'active';

    $isRemovingAdminRole =
        $currentUser['role'] === 'admin'
        && $role !== 'admin';

    $isDeactivatingAdmin =
        $currentUser['role'] === 'admin'
        && $status === 'inactive';

    if (
        $isCurrentUserActiveAdmin
        && ($isRemovingAdminRole || $isDeactivatingAdmin)
    ) {
        $activeAdmins =
            $this->userRepository->countActiveAdminsExcept($id);

        if ($activeAdmins === 0) {
            throw new ValidationException([
                'role' => 'لا يمكن إزالة صلاحيات آخر مدير نشط في النظام.'
            ]);
        }
    }
        if ($id === $this->auth->id() && $status === 'inactive') {
            throw new ValidationException([
                'status' => 'لا يمكنك تعطيل حسابك الحالي.'
            ]);
        }
        
        $this->userRepository->update(
            $id,
            $name,
            $email,
            $role,
            $status
        );
    }
}