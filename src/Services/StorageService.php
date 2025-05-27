<?php

namespace Services;

use Config\Storage;
use Aws\S3\Exception\S3Exception;

class StorageService
{
    private $s3Client;
    private string $bucket;

    public function __construct()
    {
        $this->s3Client = Storage::getClient();
        $this->bucket = Storage::getBucket();
    }

    public function uploadFile(string $filePath, string $fileName): string
    {
        try {
            $result = $this->s3Client->putObject([
                'Bucket' => $this->bucket,
                'Key' => $fileName,
                'SourceFile' => $filePath,
                'ContentType' => mime_content_type($filePath),
            ]);

            return $result['ObjectURL'];

        } catch (S3Exception $e) {
            throw new \Exception('Erro ao fazer upload para o storage: ' . $e->getMessage());
        }
    }

    public function getDownloadUrl(string $fileName, int $expiresIn = 3600): string
    {
        try {
            $cmd = $this->s3Client->getCommand('GetObject', [
                'Bucket' => $this->bucket,
                'Key' => $fileName
            ]);

            $request = $this->s3Client->createPresignedRequest($cmd, '+' . $expiresIn . ' seconds');

            return (string) $request->getUri();

        } catch (S3Exception $e) {
            throw new \Exception('Erro ao gerar URL de download: ' . $e->getMessage());
        }
    }

    public function deleteFile(string $fileName): bool
    {
        try {
            $this->s3Client->deleteObject([
                'Bucket' => $this->bucket,
                'Key' => $fileName
            ]);

            return true;

        } catch (S3Exception $e) {
            throw new \Exception('Erro ao deletar arquivo do storage: ' . $e->getMessage());
        }
    }

    public function fileExists(string $fileName): bool
    {
        try {
            $this->s3Client->headObject([
                'Bucket' => $this->bucket,
                'Key' => $fileName
            ]);

            return true;

        } catch (S3Exception $e) {
            return false;
        }
    }
}
