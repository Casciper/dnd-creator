<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use PDO;

abstract class AbstractRepository
{
    public const FETCH_ASSOC = 2;
    public const FETCH_CLASS = 8;
    protected PDO $pdo;

    protected function __construct()
    {
        $this->pdo = DB::connection('raw')->getPdo();
    }

    protected function executeSelectAll(string $sql, string $fqn = null): array
    {
        $fetchType = $fqn ? self::FETCH_CLASS : self::FETCH_ASSOC;
        $query = $this->pdo->query($sql);
        if ($fqn) {
            $query->setFetchMode($fetchType, $fqn);
        } else {
            $query->setFetchMode($fetchType);
        }
        $result = $query->fetchAll();
        return $result ?: [];
    }

    protected function executeSelectOne(string $sql, string $fqn = null)
    {
        $fetchType = $fqn ? self::FETCH_CLASS : self::FETCH_ASSOC;
        $query = $this->pdo->query($sql);
        if ($fqn) {
            $query->setFetchMode($fetchType, $fqn);
        } else {
            $query->setFetchMode($fetchType);
        }
        $result = $query->fetch(self::FETCH_ASSOC);
        return $result ?: null;
    }

    protected function execute(string $sql): bool
    {
        $query = $this->pdo->query($sql);
        return $query->execute();
    }
}
