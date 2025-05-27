<?php

namespace Services;

use Models\User;
use Repositories\UserRepository;
use Utils\SessionManager;
use Utils\Validator;

class AuthService
{
    private UserRepository $userRepository;
    private SessionManager $sessionManager;
    private Validator $validator;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->sessionManager = new SessionManager();
        $this->validator = new Validator();
    }

    public function login(string $username, string $password): array
    {
        $errors = $this->validateLoginData($username, $password);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $user = $this->userRepository->findByUsername($username);

        if (!$user || !$user->verifyPassword($password)) {
            return ['success' => false, 'errors' => ['Usuário ou senha inválidos']];
        }

        $this->sessionManager->startUserSession($user);

        return ['success' => true, 'user' => $user];
    }

    public function register(string $username, string $email, string $password, string $confirmPassword): array
    {
        $errors = $this->validateRegistrationData($username, $email, $password, $confirmPassword);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $hashedPassword = User::hashPassword($password);
        $user = new User($username, $email, $hashedPassword);

        try {
            $createdUser = $this->userRepository->create($user);
            $this->sessionManager->startUserSession($createdUser);

            return ['success' => true, 'user' => $createdUser];
        } catch (\Exception $e) {
            return ['success' => false, 'errors' => ['Erro ao criar usuário: ' . $e->getMessage()]];
        }
    }

    public function logout(): void
    {
        $this->sessionManager->destroySession();
    }

    public function getCurrentUser(): ?User
    {
        $userId = $this->sessionManager->getUserId();

        if (!$userId) {
            return null;
        }

        return $this->userRepository->findById($userId);
    }

    public function isLoggedIn(): bool
    {
        return $this->sessionManager->isLoggedIn();
    }

    private function validateLoginData(string $username, string $password): array
    {
        $errors = [];

        if (empty($username)) {
            $errors[] = 'Usuário é obrigatório';
        }

        if (empty($password)) {
            $errors[] = 'Senha é obrigatória';
        }

        return $errors;
    }

    private function validateRegistrationData(string $username, string $email, string $password, string $confirmPassword): array
    {
        $errors = [];

        if (!$this->validator->isValidUsername($username)) {
            $errors[] = 'Nome de usuário deve ter entre 3 e 50 caracteres';
        }

        if ($this->userRepository->usernameExists($username)) {
            $errors[] = 'Nome de usuário já existe';
        }

        if (!$this->validator->isValidEmail($email)) {
            $errors[] = 'Email inválido';
        }

        if ($this->userRepository->emailExists($email)) {
            $errors[] = 'Email já está cadastrado';
        }

        if (!$this->validator->isValidPassword($password)) {
            $errors[] = 'Senha deve ter pelo menos 6 caracteres';
        }

        if ($password !== $confirmPassword) {
            $errors[] = 'Senhas não coincidem';
        }

        return $errors;
    }
}
