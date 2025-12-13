<?php
namespace Controllers;

class LabController
{
    public function open()
    {
        $buoi = $_GET['buoi'] ?? null;
        $file = $_GET['file'] ?? null;

        if (!$buoi || !$file) {
            die("Thiếu tham số");
        }

        // chống ../ hack
        $file = basename($file);

        // đường dẫn vật lý tới file
       $path = dirname(__DIR__, 2) . "/lab/Buoi {$buoi}/{$file}";

        if (!file_exists($path)) {
            die("File không tồn tại");
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        // ===== PHP → CHẠY FILE =====
        if ($ext === 'php') {
            require $path;
            exit;
        }

        // ===== FILE KHÁC → MỞ =====
        $mime = mime_content_type($path);
        header("Content-Type: {$mime}");
        readfile($path);
        exit;
    }
}
