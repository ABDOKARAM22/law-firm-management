<?php

namespace LawFirmManagement\Core;

class Authorization
{
    public function __construct(
        private Auth $auth
    ) {
    }

    public function hasRole(string ...$roles): bool
    {
        if (!$this->auth->check()) {
            return false;
        }

        $user = $this->auth->user();

        if ($user === null) {
            return false;
        }

        return in_array($user['role'], $roles, true);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isLawyer(): bool
    {
        return $this->hasRole('lawyer');
    }

    public function isStaff(): bool
    {
        return $this->hasRole('staff');
    }
}