<?php

namespace Controllers;

use Services\AuthService;
use Utils\Validator;

class AuthController extends BaseController
{
    private AuthService $authService;
    private Validator $validator;

    public function __construct()
    {
        $this->authService = new AuthService();
        $this->validator = new Validator();
    }

    public function login(): void
    {
        if ($this->authService->isLoggedIn()) {
            $this->redirect('/');
            return;
        }

        if ($this->isPost()) {
            $this->handleLogin();
            return;
        }

        $this->view('layouts/main', [
            'title' => 'Login - ShareTorrent',
            'content' => 'auth/login',
            'isLoggedIn' => false,
            'currentUser' => null
        ]);
    }

    public function register(): void
    {
        if ($this->authService->isLoggedIn()) {
            $this->redirect('/');
            return;
        }

        if ($this->isPost()) {
            $this->handleRegister();
            return;
        }

        $this->view('layouts/main', [
            'title' => 'Cadastro - ShareTorrent',
            'content' => 'auth/register',
            'isLoggedIn' => false,
            'currentUser' => null
        ]);
    }

    public function logout(): void
    {
        $this->authService->logout();
        $_SESSION['success'] = 'Logout realizado com sucesso!';
        $this->redirect('/');
    }

    public function profile(): void
    {
        $currentUser = $this->authService->getCurrentUser();

        if (!$currentUser) {
            $_SESSION['error'] = 'Você precisa estar logado para acessar esta página';
            $this->redirect('/auth/login');
            return;
        }

        $this->view('layouts/main', [
            'title' => 'Perfil - ShareTorrent',
            'content' => 'auth/profile',
            'currentUser' => $currentUser,
            'isLoggedIn' => true
        ]);
    }

    private function handleLogin(): void
    {
        $username = $this->getPostParam('username', '');
        $password = $this->getPostParam('password', '');

        $result = $this->authService->login($username, $password);

        if ($result['success']) {
            $_SESSION['success'] = 'Login realizado com sucesso!';
            $this->redirect('/');
        } else {
            $_SESSION['error'] = implode('<br>', $result['errors']);
            $this->redirect('/auth/login');
        }
    }

    private function handleRegister(): void
    {
        $data = $this->validator->sanitizeInput($_POST);

        $username = $data['username'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $confirmPassword = $data['confirm_password'] ?? '';

        $result = $this->authService->register($username, $email, $password, $confirmPassword);

        if ($result['success']) {
            $_SESSION['success'] = 'Cadastro realizado com sucesso!';
            $this->redirect('/');
        } else {
            $_SESSION['error'] = implode('<br>', $result['errors']);
            $this->redirect('/auth/register');
        }
    }
}
