<?php

namespace Services;

use Models\File;
use Repositories\FileRepository;
use Utils\FileHelper;

class FileService
{
    private FileRepository $fileRepository;
    private StorageService $storageService;
    private FileHelper $fileHelper;

    public function __construct()
    {
        $this->fileRepository = new FileRepository();
        $this->storageService = new StorageService();
        $this->fileHelper = new FileHelper();
    }

    public function uploadFile(array $fileData, array $formData, string $userId): array
    {
        $errors = $this->validateUpload($fileData, $formData);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        try {
            $storedName = $this->generateUniqueFileName($formData['nome'], $fileData['name']);
            $filePath = $this->storageService->uploadFile($fileData['tmp_name'], $storedName);

            $file = new File(
                $formData['nome'],
                $formData['descricao'],
                $fileData['name'],
                $storedName,
                $filePath,
                $fileData['size'],
                $this->fileHelper->formatBytes($fileData['size']),
                $fileData['type'],
                $userId
            );

            $savedFile = $this->fileRepository->create($file);

            return ['success' => true, 'file' => $savedFile];

        } catch (\Exception $e) {
            return ['success' => false, 'errors' => ['Erro ao fazer upload: ' . $e->getMessage()]];
        }
    }

    public function getFiles(int $page = 1, int $limit = 15): array
    {
        $files = $this->fileRepository->findAll($page, $limit);
        $totalFiles = $this->fileRepository->getTotalCount();
        $totalPages = ceil($totalFiles / $limit);

        return [
            'files' => $files,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_files' => $totalFiles,
                'per_page' => $limit
            ]
        ];
    }

    public function searchFiles(string $query, int $page = 1, int $limit = 15): array
    {
        $files = $this->fileRepository->search($query, $page, $limit);
        $totalFiles = $this->fileRepository->getSearchCount($query);
        $totalPages = ceil($totalFiles / $limit);

        return [
            'files' => $files,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_files' => $totalFiles,
                'per_page' => $limit,
                'query' => $query
            ]
        ];
    }

    public function downloadFile(string $fileId): array
    {
        $file = $this->fileRepository->findById($fileId);

        if (!$file) {
            return ['success' => false, 'error' => 'Arquivo não encontrado'];
        }

        try {
            $this->fileRepository->incrementDownloadCount($fileId);
            $downloadUrl = $this->storageService->getDownloadUrl($file->getStoredName());

            return [
                'success' => true,
                'file' => $file,
                'download_url' => $downloadUrl
            ];

        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Erro ao gerar download: ' . $e->getMessage()];
        }
    }

    public function deleteFile(string $fileId, string $userId): array
    {
        $file = $this->fileRepository->findById($fileId);

        if (!$file) {
            return ['success' => false, 'error' => 'Arquivo não encontrado'];
        }

        if ($file->getUserId() !== $userId) {
            return ['success' => false, 'error' => 'Você não tem permissão para deletar este arquivo'];
        }

        try {
            $this->storageService->deleteFile($file->getStoredName());
            $this->fileRepository->delete($fileId);

            return ['success' => true];

        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Erro ao deletar arquivo: ' . $e->getMessage()];
        }
    }

    private function validateUpload(array $fileData, array $formData): array
    {
        $errors = [];

        if (empty($formData['nome'])) {
            $errors[] = 'Nome do arquivo é obrigatório';
        }

        if (empty($formData['descricao'])) {
            $errors[] = 'Descrição é obrigatória';
        }

        if (!isset($fileData['tmp_name']) || empty($fileData['tmp_name'])) {
            $errors[] = 'Nenhum arquivo foi enviado';
        }

        if ($fileData['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Erro no upload do arquivo';
        }

        $extension = strtolower(pathinfo($fileData['name'], PATHINFO_EXTENSION));
        if ($extension !== 'torrent') {
            $errors[] = 'Apenas arquivos .torrent são permitidos';
        }

        $maxSize = $_ENV['UPLOAD_MAX_SIZE'] ?? 10485760; // 10MB default
        if ($fileData['size'] > $maxSize) {
            $errors[] = 'Arquivo muito grande. Tamanho máximo: ' . $this->fileHelper->formatBytes($maxSize);
        }

        return $errors;
    }

    private function generateUniqueFileName(string $title, string $originalName): string
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $cleanTitle = $this->fileHelper->sanitizeFileName($title);
        $timestamp = time();
        $random = bin2hex(random_bytes(8));

        return $cleanTitle . '_' . $timestamp . '_' . $random . '.' . $extension;
    }
}
