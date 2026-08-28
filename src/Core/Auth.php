<?php

namespace LawFirmManagement\Core;

use LawFirmManagement\Repositories\UserRepository;

class Auth
{
    public function __construct(
        private UserRepository $users
    ) {
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->users->findByEmail($email);

        if ($user === null) {
            return false;
        }

        if ($user['status'] !== 'active') {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        Session::start();

        session_regenerate_id(true);

        Session::set('user_id', (int) $user['id']);
        Session::set('user_role', $user['role']);

        return true;
    }

    public function check(): bool
    {
        return Session::has('user_id');
    }

    public function user(): ?array
    {
        if (!$this->check()) {
            return null;
        }

        return $this->users->findById(
            (int) Session::get('user_id')
        );
    }

    public function logout(): void
    {
        Session::destroy();
    }
}