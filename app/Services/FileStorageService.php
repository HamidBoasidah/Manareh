<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileStorageService
{
    protected string $disk = 'public';

    /**
     * Store multiple uploaded files to the given folder on the configured disk.
     * Returns an array of stored paths.
     *
     * @param array $files Array of UploadedFile instances
     * @param string|null $folder
     * @return array
     */
    public function storeFiles(array $files, ?string $folder = null): array
    {
        $paths = [];
        foreach ($files as $f) {
            if (!$f) continue;
            try {
                if ($folder) {
                    $paths[] = Storage::disk($this->disk)->putFile($folder, $f);
                } else {
                    $paths[] = Storage::disk($this->disk)->putFile('/', $f);
                }
            } catch (\Throwable $e) {
                // rethrow to allow caller to cleanup if needed
                throw $e;
            }
        }

        return $paths;
    }

    /**
     * Delete multiple file paths safely.
     *
     * @param array $paths
     * @return void
     */
    public function deleteFiles(array $paths): void
    {
        foreach ($paths as $p) {
            try {
                if ($p && Storage::disk($this->disk)->exists($p)) {
                    Storage::disk($this->disk)->delete($p);
                }
            } catch (\Throwable $_) {
                // ignore deletion errors
            }
        }
    }
}
