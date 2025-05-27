<?php

namespace Repositories;

use Models\User;

class UserRepository extends BaseRepository
{
    public function findById(string $id): ?User
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $data = $this->fetchOne($sql, ['id' => $id]);

        return $data ? $this->mapToUser($data) : null;
    }

    public function findByUsername(string $username): ?User
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $data = $this->fetchOne($sql, ['username' => $username]);

        return $data ? $this->mapToUser($data) : null;
    }

    public function findByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $data = $this->fetchOne($sql, ['email' => $email]);

        return $data ? $this->mapToUser($data) : null;
    }

    public function create(User $user): User
    {
        $sql = "INSERT INTO users (username, email, password_hash) 
                VALUES (:username, :email, :password_hash) 
                RETURNING id, created_at, updated_at";

        $stmt = $this->executeQuery($sql, [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password_hash' => $user->getPasswordHash(),
        ]);

        $result = $stmt->fetch();
        $user->setId($result['id']);

        return $user;
    }

    public function update(User $user): bool
    {
        $sql = "UPDATE users 
                SET username = :username, email = :email, updated_at = CURRENT_TIMESTAMP 
                WHERE id = :id";

        $stmt = $this->executeQuery($sql, [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
        ]);

        return $stmt->rowCount() > 0;
    }

    public function delete(string $id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->executeQuery($sql, ['id' => $id]);

        return $stmt->rowCount() > 0;
    }

    public function usernameExists(string $username): bool
    {
        return $this->findByUsername($username) !== null;
    }

    public function emailExists(string $email): bool
    {
        return $this->findByEmail($email) !== null;
    }

    private function mapToUser(array $data): User
    {
        return new User(
            $data['username'],
            $data['email'],
            $data['password_hash'],
            $data['id'],
            new \DateTime($data['created_at']),
            new \DateTime($data['updated_at'])
        );
    }
}
