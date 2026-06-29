<?php
declare(strict_types=1);

class IntegrityController extends Controller
{
    public function index(): void
    {
        $this->render('integrity', [
            'pageTitle'  => 'Verificador de Integridade',
            'activeMenu' => 'integrity',
        ]);
    }

    public function process(): void
    {
        $error  = null;
        $result = null;

        $file1Ok = isset($_FILES['file1']) && $_FILES['file1']['error'] === UPLOAD_ERR_OK;
        $file2Ok = isset($_FILES['file2']) && $_FILES['file2']['error'] === UPLOAD_ERR_OK;

        if (!$file1Ok || !$file2Ok) {
            $error = 'Envie os dois arquivos para comparação.';
        } else {
            $f1 = $_FILES['file1'];
            $f2 = $_FILES['file2'];

            $hash1 = hash_file('sha256', $f1['tmp_name']);
            $hash2 = hash_file('sha256', $f2['tmp_name']);

            $identical = hash_equals($hash1, $hash2);

            $result = [
                'file1'     => htmlspecialchars($f1['name'], ENT_QUOTES, 'UTF-8'),
                'file2'     => htmlspecialchars($f2['name'], ENT_QUOTES, 'UTF-8'),
                'size1'     => $this->formatBytes($f1['size']),
                'size2'     => $this->formatBytes($f2['size']),
                'hash1'     => $hash1,
                'hash2'     => $hash2,
                'identical' => $identical,
                'datetime'  => date('d/m/Y H:i:s'),
            ];
        }

        $this->render('integrity', [
            'pageTitle'  => 'Verificador de Integridade',
            'activeMenu' => 'integrity',
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
