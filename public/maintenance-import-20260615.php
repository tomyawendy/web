<?php

declare(strict_types=1);

$root = __DIR__;
$dbConfigPath = $root . '/config/database.php';
$patches = [
    $root . '/database/patches/2026_06_15_spanish_completion.sql',
];

header('Content-Type: text/plain; charset=utf-8');

if (!is_file($dbConfigPath)) {
    http_response_code(500);
    echo "Database config not found.\n";
    exit;
}

$db = require $dbConfigPath;
$expectedKey = hash('sha256', (string) ($db['password'] ?? '') . '|planet-cms-import-20260615');
$providedKey = (string) ($_POST['key'] ?? $_GET['key'] ?? '');

if ($providedKey === '' || !hash_equals($expectedKey, $providedKey)) {
    http_response_code(403);
    echo "Forbidden.\n";
    exit;
}

try {
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=%s',
        $db['host'] ?? 'localhost',
        $db['port'] ?? '3306',
        $db['database'] ?? '',
        $db['charset'] ?? 'utf8mb4'
    );
    $pdo = new PDO($dsn, (string) ($db['username'] ?? ''), (string) ($db['password'] ?? ''), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    foreach ($patches as $patch) {
        if (!is_file($patch)) {
            throw new RuntimeException('Patch not found: ' . basename($patch));
        }

        echo "Importing " . basename($patch) . "...\n";
        foreach (split_sql_file((string) file_get_contents($patch)) as $statement) {
            try {
                $pdo->exec($statement);
            } catch (PDOException $exception) {
                $code = (int) ($exception->errorInfo[1] ?? 0);
                if (in_array($code, [1060, 1061, 1062], true)) {
                    echo "Skipped already-applied statement ({$code}).\n";
                    continue;
                }

                throw $exception;
            }
        }
    }

    @unlink(__FILE__);
    echo "Import completed. Import script removed.\n";
} catch (Throwable $exception) {
    http_response_code(500);
    echo "Import failed: " . $exception->getMessage() . "\n";
}

function split_sql_file(string $sql): array
{
    $statements = [];
    $buffer = '';
    $inSingle = false;
    $inDouble = false;
    $length = strlen($sql);

    for ($i = 0; $i < $length; $i++) {
        $char = $sql[$i];
        $next = $sql[$i + 1] ?? '';

        if (!$inSingle && !$inDouble && $char === '-' && $next === '-') {
            while ($i < $length && $sql[$i] !== "\n") {
                $i++;
            }
            continue;
        }

        if ($char === "'" && !$inDouble) {
            $backslashes = 0;
            for ($j = $i - 1; $j >= 0 && $sql[$j] === '\\'; $j--) {
                $backslashes++;
            }
            if ($backslashes % 2 === 0) {
                $inSingle = !$inSingle;
            }
        } elseif ($char === '"' && !$inSingle) {
            $inDouble = !$inDouble;
        }

        if ($char === ';' && !$inSingle && !$inDouble) {
            $statement = trim($buffer);
            if ($statement !== '') {
                $statements[] = $statement;
            }
            $buffer = '';
            continue;
        }

        $buffer .= $char;
    }

    $statement = trim($buffer);
    if ($statement !== '') {
        $statements[] = $statement;
    }

    return $statements;
}
