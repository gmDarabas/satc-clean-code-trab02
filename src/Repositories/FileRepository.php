<?php

namespace Repositories;

use Models\File;

class FileRepository extends BaseRepository
{
    public function findById(string $id): ?File
    {
        $sql = "SELECT f.*, u.username 
                FROM files f 
                JOIN users u ON f.user_id = u.id 
                WHERE f.id = :id";

        $data = $this->fetchOne($sql, ['id' => $id]);

        return $data ? $this->mapToFile($data) : null;
    }

    public function findAll(int $page = 1, int $limit = 15): array
    {
        $offset = ($page - 1) * $limit;

        $sql = "SELECT f.*, u.username 
                FROM files f 
                JOIN users u ON f.user_id = u.id 
                ORDER BY f.created_at DESC 
                LIMIT :limit OFFSET :offset";

        $data = $this->fetchAll($sql, [
            'limit' => $limit,
            'offset' => $offset
        ]);

        return array_map([$this, 'mapToFile'], $data);
    }

    public function findByUserId(string $userId, int $page = 1, int $limit = 15): array
    {
        $offset = ($page - 1) * $limit;

        $sql = "SELECT f.*, u.username 
                FROM files f 
                JOIN users u ON f.user_id = u.id 
                WHERE f.user_id = :user_id 
                ORDER BY f.created_at DESC 
                LIMIT :limit OFFSET :offset";

        $data = $this->fetchAll($sql, [
            'user_id' => $userId,
            'limit' => $limit,
            'offset' => $offset
        ]);

        return array_map([$this, 'mapToFile'], $data);
    }

    public function search(string $query, int $page = 1, int $limit = 15): array
    {
        $offset = ($page - 1) * $limit;
        $searchTerm = '%' . $query . '%';

        $sql = "SELECT f.*, u.username 
                FROM files f 
                JOIN users u ON f.user_id = u.id 
                WHERE f.title ILIKE :query OR f.description ILIKE :query
                ORDER BY f.created_at DESC 
                LIMIT :limit OFFSET :offset";

        $data = $this->fetchAll($sql, [
            'query' => $searchTerm,
            'limit' => $limit,
            'offset' => $offset
        ]);

        return array_map([$this, 'mapToFile'], $data);
    }

    public function getTotalCount(): int
    {
        $sql = "SELECT COUNT(*) as count FROM files";
        $result = $this->fetchOne($sql);

        return (int) $result['count'];
    }

    public function getSearchCount(string $query): int
    {
        $searchTerm = '%' . $query . '%';

        $sql = "SELECT COUNT(*) as count FROM files 
                WHERE title ILIKE :query OR description ILIKE :query";

        $result = $this->fetchOne($sql, ['query' => $searchTerm]);

        return (int) $result['count'];
    }

    public function create(File $file): File
    {
        $sql = "INSERT INTO files (title, description, original_name, stored_name, file_path, 
                                 file_size, file_size_formatted, mime_type, folder_id, user_id) 
                VALUES (:title, :description, :original_name, :stored_name, :file_path, 
                        :file_size, :file_size_formatted, :mime_type, :folder_id, :user_id) 
                RETURNING id, created_at, updated_at";

        $stmt = $this->executeQuery($sql, [
            'title' => $file->getTitle(),
            'description' => $file->getDescription(),
            'original_name' => $file->getOriginalName(),
            'stored_name' => $file->getStoredName(),
            'file_path' => $file->getFilePath(),
            'file_size' => $file->getFileSize(),
            'file_size_formatted' => $file->getFileSizeFormatted(),
            'mime_type' => $file->getMimeType(),
            'folder_id' => $file->getFolderId(),
            'user_id' => $file->getUserId(),
        ]);

        $result = $stmt->fetch();
        $file->setId($result['id']);

        return $file;
    }

    public function incrementDownloadCount(string $id): bool
    {
        $sql = "UPDATE files SET download_count = download_count + 1, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->executeQuery($sql, ['id' => $id]);

        return $stmt->rowCount() > 0;
    }

    public function delete(string $id): bool
    {
        $sql = "DELETE FROM files WHERE id = :id";
        $stmt = $this->executeQuery($sql, ['id' => $id]);

        return $stmt->rowCount() > 0;
    }

    private function mapToFile(array $data): File
    {
        $file = new File(
            $data['title'],
            $data['description'],
            $data['original_name'],
            $data['stored_name'],
            $data['file_path'],
            (int) $data['file_size'],
            $data['file_size_formatted'],
            $data['mime_type'],
            $data['user_id'],
            $data['folder_id'],
            $data['id'],
            (int) $data['download_count'],
            new \DateTime($data['created_at']),
            new \DateTime($data['updated_at'])
        );

        // Adiciona o username se disponível
        if (isset($data['username'])) {
            $file->username = $data['username'];
        }

        return $file;
    }
}
