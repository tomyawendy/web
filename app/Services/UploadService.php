<?php

declare(strict_types=1);

namespace App\Services;

class UploadService
{
    public function store(?array $file, string $type = 'images'): ?array
    {
        if (!$file || (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ((int) $file['error'] !== UPLOAD_ERR_OK) {
            throw new \RuntimeException(file_upload_failed_message());
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = config('app.uploads.' . $type, []);
        if (!in_array($extension, $allowed, true)) {
            throw new \RuntimeException(unsupported_file_type_message());
        }

        $folder = date('Y/m');
        $directory = upload_path($folder);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $name = uniqid('media_', true) . '.' . $extension;
        $target = $directory . DIRECTORY_SEPARATOR . $name;
        if (!move_uploaded_file($file['tmp_name'], $target)) {
            throw new \RuntimeException(file_move_failed_message());
        }

        return [
            'file_name' => $file['name'],
            'file_path' => 'assets/uploads/' . $folder . '/' . $name,
            'mime_type' => $file['type'] ?? 'application/octet-stream',
            'file_size' => (int) ($file['size'] ?? 0),
            'file_type' => $type,
        ];
    }
}
