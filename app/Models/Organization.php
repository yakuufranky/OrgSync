<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;

/**
 * Organization Data Model
 */
class Organization extends Model
{
    /**
     * Find organization by unique organization code
     *
     * @param string $code
     * @return array<string, mixed>|null
     */
    public function findByCode(string $code): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM organizations WHERE org_code = :code LIMIT 1');
        $stmt->execute(['code' => trim($code)]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Find organization by primary key
     *
     * @param int $id
     * @return array<string, mixed>|null
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM organizations WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Create a new organization
     *
     * @param array{name: string, type: string, school_name?: string} $data
     * @return array{id: int, org_code: string}
     */
    public function create(array $data): array
    {
        $code = $this->generateUniqueCode();
        $schoolName = $data['school_name'] ?? 'Quezon City University';

        $stmt = $this->db->prepare('
            INSERT INTO organizations (org_code, name, type, school_name)
            VALUES (:org_code, :name, :type, :school_name)
        ');

        $stmt->execute([
            'org_code' => $code,
            'name' => trim($data['name']),
            'type' => $data['type'],
            'school_name' => trim($schoolName),
        ]);

        return [
            'id' => (int) $this->db->lastInsertId(),
            'org_code' => $code,
        ];
    }

    /**
     * Generate unique organization code
     *
     * @return string
     */
    private function generateUniqueCode(): string
    {
        do {
            $randomPart = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
            $code = 'ORG-' . $randomPart;
            $exists = $this->findByCode($code);
        } while ($exists !== null);

        return $code;
    }
}
