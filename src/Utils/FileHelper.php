<?php

namespace Utils;

class FileHelper
{
    public function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function sanitizeFileName(string $fileName): string
    {
        // Remove caracteres especiais e espaços
        $fileName = preg_replace('/[^a-zA-Z0-9\-_.]/', '_', $fileName);

        // Remove múltiplos underscores
        $fileName = preg_replace('/_+/', '_', $fileName);

        // Remove underscores no início e fim
        $fileName = trim($fileName, '_');

        return $fileName;
    }

    public function getFileExtension(string $fileName): string
    {
        return strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    }

    public function isTorrentFile(string $fileName): bool
    {
        return $this->getFileExtension($fileName) === 'torrent';
    }

    public function validateTorrentFile(string $filePath): bool
    {
        if (!file_exists($filePath)) {
            return false;
        }

        // Verificação básica do arquivo torrent
        $content = file_get_contents($filePath);

        // Arquivos torrent começam com 'd' (dictionary em bencode)
        return $content && substr($content, 0, 1) === 'd';
    }
}
