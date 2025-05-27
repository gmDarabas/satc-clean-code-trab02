<?php

namespace Utils;

class Validator
{
    public function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function isValidUsername(string $username): bool
    {
        return strlen($username) >= 3 && strlen($username) <= 50 &&
               preg_match('/^[a-zA-Z0-9_-]+$/', $username);
    }

    public function isValidPassword(string $password): bool
    {
        return strlen($password) >= 6;
    }

    public function sanitizeString(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public function sanitizeInput(array $data): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $sanitized[$key] = $this->sanitizeString($value);
            } else {
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }

    public function validateRequired(array $data, array $requiredFields): array
    {
        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[] = ucfirst($field) . ' é obrigatório';
            }
        }

        return $errors;
    }
}
