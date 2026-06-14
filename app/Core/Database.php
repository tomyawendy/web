<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = sprintf(
            '%s:host=%s;port=%s;dbname=%s;charset=%s',
            $config['driver'],
            $config['host'],
            $config['port'],
            $config['database'],
            $config['charset']
        );

        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $exception) {
            throw new PDOException('Database connection failed: ' . $exception->getMessage(), (int) $exception->getCode());
        }
    }

    public function pdo(): PDO
    {
        return $this->pdo;
    }

    public function query(string $sql, array $params = []): \PDOStatement
    {
        if ($params !== []) {
            preg_match_all('/:[a-zA-Z_][a-zA-Z0-9_]*/', $sql, $matches);
            $allowed = array_map(static fn (string $name): string => substr($name, 1), array_unique($matches[0] ?? []));
            $params = array_intersect_key($params, array_flip($allowed));
        }

        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
        return $statement;
    }
}
