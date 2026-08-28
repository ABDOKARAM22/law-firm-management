<?php

namespace LawFirmManagement\Core;

class Csrf
{
    private const SESSION_KEY = '_csrf_token';

    public static function token(): string
    {
        Session::start();

        if (!Session::has(self::SESSION_KEY)) {
            Session::set(
                self::SESSION_KEY,
                bin2hex(random_bytes(32))
            );
        }

        return Session::get(self::SESSION_KEY);
    }

    public static function verify(?string $token): bool
    {
        if ($token === null) {
            return false;
        }

        $sessionToken = Session::get(self::SESSION_KEY);

        if ($sessionToken === null) {
            return false;
        }

        return hash_equals($sessionToken, $token);
    }
}