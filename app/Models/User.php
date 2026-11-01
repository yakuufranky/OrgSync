<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;

/**
 * User Data Model
 */
class User extends Model
{
    /**
     * Find user record by email address
     *
     * @param string $email
     * @return array<string, mixed>|null
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('
            SELECT u.*, o.name AS organization_name, o.org_code, o.type AS organization_type
            FROM users u
            LEFT JOIN organizations o ON u.organization_id = o.id
            WHERE u.email = :email
            LIMIT 1
        ');
        $stmt->execute(['email' => strtolower(trim($email))]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Find user record by ID
     *
     * @param int $id
     * @return array<string, mixed>|null
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('
            SELECT u.*, o.name AS organization_name, o.org_code, o.type AS organization_type
            FROM users u
            LEFT JOIN organizations o ON u.organization_id = o.id
            WHERE u.id = :id
            LIMIT 1
        ');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Verify user credentials
     *
     * @param string $email
     * @param string $password
     * @return array<string, mixed>|null Returns user data without password hash on success
     */
    public function verifyCredentials(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if ($user === null) {
            return null;
        }

        if (!password_verify($password, $user['password_hash'])) {
            return null;
        }

        unset($user['password_hash']);
        return $user;
    }

    /**
     * Register a new user
     *
     * @param array<string, mixed> $data
     * @return int Created user ID
     */
    public function create(array $data): int
    {
        $stmt = $this->db->prepare('
            INSERT INTO users (
                organization_id, full_name, email, password_hash, course, 
                department_committee, role, position, status
            ) VALUES (
                :org_id, :full_name, :email, :password_hash, :course, 
                :department_committee, :role, :position, :status
            )
        ');

        $stmt->execute([
            'org_id' => $data['organization_id'] ?? null,
            'full_name' => trim($data['full_name']),
            'email' => strtolower(trim($data['email'])),
            'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            'course' => trim($data['course']),
            'department_committee' => !empty($data['department_committee']) ? trim($data['department_committee']) : null,
            'role' => $data['role'],
            'position' => trim($data['position']),
            'status' => $data['status'] ?? 'Active',
        ]);

        return (int) $this->db->lastInsertId();
    }
}
