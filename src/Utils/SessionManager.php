<?php

namespace Utils;

use Models\User;

class SessionManager
{
    public function __construct()
    {
        $this->startSession();
    }

    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_name($_ENV['SESSION_NAME'] ?? 'sharetorrent_session');
            session_start();
        }
    }

    public function startUserSession(User $user): void
    {
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['logged_in'] = true;

        // Regenerar ID da sessão por segurança
        session_regenerate_id(true);
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public function getUserId(): ?string
    {
        return $_SESSION['user_id'] ?? null;
    }

    public function getUsername(): ?string
    {
        return $_SESSION['username'] ?? null;
    }

    public function destroySession(): void
    {
        session_unset();
        session_destroy();
    }
}
