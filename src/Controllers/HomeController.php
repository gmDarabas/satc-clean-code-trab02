<?php

namespace Controllers;

use Services\FileService;
use Services\AuthService;

class HomeController extends BaseController
{
    private FileService $fileService;
    private AuthService $authService;

    public function __construct()
    {
        $this->fileService = new FileService();
        $this->authService = new AuthService();
    }

    public function index(): void
    {
        $page = (int) $this->getQueryParam('pagina', 1);
        $search = $this->getQueryParam('pesquisar');

        if ($search) {
            $result = $this->fileService->searchFiles($search, $page);
        } else {
            $result = $this->fileService->getFiles($page);
        }

        $currentUser = $this->authService->getCurrentUser();
        $isLoggedIn = $this->authService->isLoggedIn();

        $this->view('layouts/main', [
            'title' => 'ShareTorrent',
            'content' => 'files/index',
            'files' => $result['files'],
            'pagination' => $result['pagination'],
            'currentUser' => $currentUser,
            'isLoggedIn' => $isLoggedIn,
            'search' => $search
        ]);
    }

    public function search(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/');
            return;
        }

        $query = $this->getPostParam('pesquisar');

        if (empty($query)) {
            $this->redirect('/');
            return;
        }

        $this->redirect('/?pesquisar=' . urlencode($query));
    }
}
