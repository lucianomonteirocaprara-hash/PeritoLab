<?php
declare(strict_types=1);

class HashController extends Controller
{
    public function index(): void
    {
        $this->render('hash', [
            'pageTitle'  => 'Gerador de Hash',
            'activeMenu' => 'hash',
        ]);
    }

    public function process(): void
    {
        $error  = null;
        $result = null;

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $error = 'Nenhum arquivo enviado ou erro no upload.';
        } else {
            $file = $_FILES['file'];
            $tmp  = $file['tmp_name'];
            $name = htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8');
            $size = $file['size'];

            $result = [
                'filename' => $name,
                'size'     => $this->formatBytes($size),
                'md5'      => hash_file('md5',    $tmp),
                'sha1'     => hash_file('sha1',   $tmp),
                'sha256'   => hash_file('sha256', $tmp),
                'sha512'   => hash_file('sha512', $tmp),
                'datetime' => date('d/m/Y H:i:s'),
            ];
        }

        $this->render('hash', [
            'pageTitle'  => 'Gerador de Hash',
            'activeMenu' => 'hash',
            'result'     => $result,
            'error'      => $error,
        ]);
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) return round($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576)   return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)      return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }
}
