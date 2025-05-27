<?php

namespace Models;

class File
{
    public ?string $id;
    public string $title;
    public string $description;
    public string $originalName;
    public string $storedName;
    public string $filePath;
    public int $fileSize;
    public string $fileSizeFormatted;
    public string $mimeType;
    public ?string $folderId;
    public string $userId;
    public int $downloadCount;
    public ?\DateTime $createdAt;
    public ?\DateTime $updatedAt;

    public function __construct(
        string $title,
        string $description,
        string $originalName,
        string $storedName,
        string $filePath,
        int $fileSize,
        string $fileSizeFormatted,
        string $mimeType,
        string $userId,
        ?string $folderId = null,
        ?string $id = null,
        int $downloadCount = 0,
        ?\DateTime $createdAt = null,
        ?\DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->originalName = $originalName;
        $this->storedName = $storedName;
        $this->filePath = $filePath;
        $this->fileSize = $fileSize;
        $this->fileSizeFormatted = $fileSizeFormatted;
        $this->mimeType = $mimeType;
        $this->folderId = $folderId;
        $this->userId = $userId;
        $this->downloadCount = $downloadCount;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function incrementDownloadCount(): void
    {
        $this->downloadCount++;
    }

    public function isTorrentFile(): bool
    {
        return strtolower(pathinfo($this->originalName, PATHINFO_EXTENSION)) === 'torrent';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'original_name' => $this->originalName,
            'stored_name' => $this->storedName,
            'file_path' => $this->filePath,
            'file_size' => $this->fileSize,
            'file_size_formatted' => $this->fileSizeFormatted,
            'mime_type' => $this->mimeType,
            'folder_id' => $this->folderId,
            'user_id' => $this->userId,
            'download_count' => $this->downloadCount,
            'created_at' => $this->createdAt?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt?->format('Y-m-d H:i:s'),
        ];
    }
}
