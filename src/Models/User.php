<?php

namespace Models;

class User
{
    public ?string $id;
    public string $username;
    public string $email;
    public string $passwordHash;
    public ?\DateTime $createdAt;
    public ?\DateTime $updatedAt;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->username = $data['username'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->passwordHash = $data['passwordHash'] ?? '';

        $this->createdAt = isset($data['createdAt'])
            ? $this->parseDate($data['createdAt'])
            : null;

        $this->updatedAt = isset($data['updatedAt'])
            ? $this->parseDate($data['updatedAt'])
            : null;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'created_at' => $this->createdAt?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt?->format('Y-m-d H:i:s'),
        ];
    }
}
