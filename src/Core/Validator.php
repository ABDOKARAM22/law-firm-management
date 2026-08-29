<?php

namespace LawFirmManagement\Core;

class Validator
{
    private array $errors = [];

    public function required(string $field, mixed $value): self
    {
        if ($value === null || trim((string) $value) === '') {
            $this->errors[$field] = "هذا الحقل مطلوب.";
        }

        return $this;
    }

    public function string(string $field, mixed $value): self
    {
        if (!is_string($value)) {
            $this->errors[$field] = "يجب أن يكون {$field} نصًا.";
        }

        return $this;
    }

    public function alpha(string $field, mixed $value): self
    {
        if (
            !is_string($value) ||
            !preg_match('/^[\p{Arabic}\p{Latin}\s]+$/u', $value)
        ) {
            $this->errors[$field] = "يجب أن يحتوي {$field} على أحرف عربية أو إنجليزية فقط.";
        }

        return $this;
    }
    
    public function email(string $field, string $value): self
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] =
                "يجب إدخال بريد إلكتروني صحيح.";
        }

        return $this;
    }

    public function minLength(
        string $field,
        string $value,
        int $length
    ): self {
        if (mb_strlen($value) < $length) {
            $this->errors[$field] =
                "يجب أن يكون {$field} على الأقل {$length} أحرف.";
        }

        return $this;
    }

    public function in(
        string $field,
        mixed $value,
        array $allowed
    ): self {
        if (!in_array($value, $allowed, true)) {
            $this->errors[$field] =
                "القيمة المحددة في {$field} غير صحيحة.";
        }

        return $this;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}