<?php

namespace LawFirmManagement\Core;

class Flash
{
    private const SESSION_KEY = '_flash';

    public static function set(string $key, mixed $value): void
    {
        Session::start();

        $messages = Session::get(self::SESSION_KEY, []);

        $messages[$key] = $value;

        Session::set(self::SESSION_KEY, $messages);
    }

    public static function get(string $key): mixed
    {
        Session::start();

        $messages = Session::get(self::SESSION_KEY, []);

        if (!isset($messages[$key])) {
            return null;
        }

        $message = $messages[$key];

        unset($messages[$key]);

        Session::set(self::SESSION_KEY, $messages);

        return $message;
    }
}