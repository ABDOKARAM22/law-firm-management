<?php

namespace LawFirmManagement\Middleware;

use LawFirmManagement\Core\Auth;

class AuthMiddleware
{
    public function __construct(
        private Auth $auth
    ) {
    }

    public function handle(): void
    {
        if (!$this->auth->check()) {
            header('Location: ?route=login');
            exit;
        }
    }
}