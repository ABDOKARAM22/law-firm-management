<?php

namespace LawFirmManagement\Middleware;

use LawFirmManagement\Core\Authorization;

class RoleMiddleware
{
    public function __construct(
        private Authorization $authorization
    ) {
    }

    public function handle(string ...$roles): void
    {
        if (!$this->authorization->hasRole(...$roles)) {
            http_response_code(403);
            echo '403 - Forbidden';
            exit;
        }
    }
}