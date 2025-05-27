<?php

namespace Controllers;

use Services\FileService;
use Services\AuthService;
use Utils\Validator;

class FileController extends BaseController
{
    private FileService $fileService;
    private AuthService $authService;
    private Validator $validator;

    public function __construct()
    {
        $this->fileService = new FileService();
        $this->authService = new AuthService();
        $this->validator = new Validator();
    }

    public function upload(): void
    {
        $currentUser = $this->authService->getCurrentUser();
        $isLoggedIn = $this->authService->isLoggedIn();

        if (!$isLoggedIn) {
            $_SESSION['error'] = 'Você precisa fazer login para enviar arquivos!';
            $this->redirect('/auth/login');
            return;
        }

        if ($this->isPost()) {
            $this->handleUpload($currentUser->getId());
            return;
        }

        $this->view('layouts/main', [
            'title' => 'Enviar Arquivo - ShareTorrent',
            'content' => 'files/upload',
            'currentUser' => $currentUser,
            'isLoggedIn' => $isLoggedIn
        ]);
    }

    public function download(): void
    {
        $fileId = $this->getQueryParam('id');

        if (!$fileId) {
            $_SESSION['error'] = 'Arquivo não encontrado';
            $this->redirect('/');
            return;
        }

        $result = $this->fileService->downloadFile($fileId);

        if (!$result['success']) {
            $_SESSION['error'] = $result['error'];
            $this->redirect('/');
            return;
        }

        $this->redirect($result['download_url']);
    }

    public function delete(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/');
            return;
        }

        $currentUser = $this->authService->getCurrentUser();

        if (!$currentUser) {
            $this->json(['success' => false, 'error' => 'Usuário não logado'], 401);
            return;
        }

        $fileId = $this->getPostParam('file_id');

        if (!$fileId) {
            $this->json(['success' => false, 'error' => 'ID do arquivo não informado'], 400);
            return;
        }

        $result = $this->fileService->deleteFile($fileId, $currentUser->getId());

        $this->json($result);
    }

    private function handleUpload(string $userId): void
    {
        $formData = $this->validator->sanitizeInput($_POST);

        if (!isset($_FILES['arquivo'])) {
            $_SESSION['error'] = 'Nenhum arquivo foi enviado';
            $this->redirect('/files/upload');
            return;
        }

        $result = $this->fileService->uploadFile($_FILES['arquivo'], $formData, $userId);

        if ($result['success']) {
            $_SESSION['success'] = 'Arquivo enviado com sucesso!';
            $this->redirect('/');
        } else {
            $_SESSION['error'] = implode('<br>', $result['errors']);
            $this->redirect('/files/upload');
        }
    }
}
