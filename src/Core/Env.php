<?php

namespace LawFirmManagement\Core;

class Env
{
    public function load(): void
    {
        $file = __DIR__ . '/../../.env';

        if (!file_exists($file)) {
            throw new \RuntimeException('.env file not found.');
        }

        $handle = fopen($file, 'r');

        if ($handle === false) {
            throw new \RuntimeException('Unable to open .env file.');
        }

        while (($line = fgets($handle)) !== false) {

            $line = trim($line);

            // Ignore empty lines and comments
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);

            $_ENV[trim($key)] = trim($value);
        }

        fclose($handle);
    }
}