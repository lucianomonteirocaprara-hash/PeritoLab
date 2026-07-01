<?php
declare(strict_types=1);

class MetadataController extends Controller
{
    public function index(): void
    {
        $this->render('metadata', [
            'pageTitle'  => 'Metadata Inspector',
            'activeMenu' => 'metadata',
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
            $name = $file['name'];
            $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));

            $allowed = ['pdf', 'docx', 'jpg', 'jpeg', 'png'];
            if (!in_array($ext, $allowed, true)) {
                $error = 'Formato não suportado. Use PDF, DOCX, JPG ou PNG.';
            } else {
                $result = $this->extractMetadata($tmp, $ext, $name);
            }
        }

        $this->render('metadata', [
            'pageTitle'  => 'Metadata Inspector',
            'activeMenu' => 'metadata',
            'result'     => $result,
            'error'      => $error,
        ]);
    }

    private function extractMetadata(string $tmp, string $ext, string $filename): array
    {
        $meta = [
            'filename'  => htmlspecialchars($filename, ENT_QUOTES, 'UTF-8'),
            'extension' => strtoupper($ext),
            'filesize'  => $this->formatBytes(filesize($tmp)),
            'fields'    => [],
            'gps'       => null,
        ];

        match ($ext) {
            'jpg', 'jpeg' => $this->readJpegMeta($tmp, $meta),
            'png'         => $this->readPngMeta($tmp, $meta),
            'pdf'         => $this->readPdfMeta($tmp, $meta),
            'docx'        => $this->readDocxMeta($tmp, $meta),
            default       => null,
        };

        return $meta;
    }

    private function readJpegMeta(string $tmp, array &$meta): void
    {
        $info = @getimagesize($tmp);
        if ($info) {
            $meta['fields']['Dimensões']    = $info[0] . ' x ' . $info[1] . ' px';
            $meta['fields']['Tipo MIME']    = $info['mime'];
        }

        if (!function_exists('exif_read_data')) {
            $meta['fields']['EXIF'] = 'Este arquivo não contém informações EXIF.';
            return;
        }

        $exif = @exif_read_data($tmp, null, false);
        if (!$exif) {
            $meta['fields']['EXIF'] = 'Sem dados EXIF';
            return;
        }

        $map = [
            'Make'             => 'Fabricante',
            'Model'            => 'Modelo da Câmera',
            'Software'         => 'Software',
            'Artist'           => 'Autor',
            'Copyright'        => 'Copyright',
            'DateTime'         => 'Data de Criação',
            'DateTimeOriginal' => 'Data Original',
            'DateTimeDigitized'=> 'Data Digitalização',
            'ExposureTime'     => 'Tempo de Exposição',
            'FNumber'          => 'Abertura (f)',
            'ISOSpeedRatings'  => 'ISO',
            'Flash'            => 'Flash',
            'FocalLength'      => 'Distância Focal',
            'MeteringMode'     => 'Modo de Medição',
            'Orientation'      => 'Orientação',
            'XResolution'      => 'Resolução X',
            'YResolution'      => 'Resolução Y',
        ];

        foreach ($map as $key => $label) {
            if (!empty($exif[$key])) {
                $val = $exif[$key];
                if (is_array($val)) {
                    $val = implode(', ', $val);
                }
                $meta['fields'][$label] = htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8');
            }
        }

        if (!empty($exif['GPSLatitude']) && !empty($exif['GPSLongitude'])) {
            $lat = $this->gpsToDecimal($exif['GPSLatitude'], $exif['GPSLatitudeRef'] ?? 'N');
            $lon = $this->gpsToDecimal($exif['GPSLongitude'], $exif['GPSLongitudeRef'] ?? 'E');
            $meta['gps'] = ['lat' => $lat, 'lon' => $lon];
            $meta['fields']['GPS Latitude']  = $lat;
            $meta['fields']['GPS Longitude'] = $lon;
            if (!empty($exif['GPSAltitude'])) {
                $parts = explode('/', $exif['GPSAltitude']);
                $alt   = count($parts) === 2 ? round((float)$parts[0] / (float)$parts[1], 2) : $exif['GPSAltitude'];
                $meta['fields']['GPS Altitude'] = $alt . ' m';
            }
        }
    }

    private function readPngMeta(string $tmp, array &$meta): void
    {
        $info = @getimagesize($tmp);
        if ($info) {
            $meta['fields']['Dimensões'] = $info[0] . ' x ' . $info[1] . ' px';
            $meta['fields']['Tipo MIME'] = $info['mime'];
        }

        $raw = file_get_contents($tmp);
        if ($raw === false) return;

        $pos = 8;
        $len = strlen($raw);

        while ($pos < $len - 8) {
            $chunkLen  = unpack('N', substr($raw, $pos, 4))[1];
            $chunkType = substr($raw, $pos + 4, 4);
            $chunkData = substr($raw, $pos + 8, $chunkLen);

            if ($chunkType === 'tEXt') {
                $parts = explode("\0", $chunkData, 2);
                if (count($parts) === 2) {
                    $key = htmlspecialchars($parts[0], ENT_QUOTES, 'UTF-8');
                    $val = htmlspecialchars($parts[1], ENT_QUOTES, 'UTF-8');
                    $meta['fields'][$key] = $val;
                }
            } elseif ($chunkType === 'iTXt') {
                $null1 = strpos($chunkData, "\0");
                if ($null1 !== false) {
                    $key = substr($chunkData, 0, $null1);
                    $val = substr($chunkData, $null1 + 3);
                    $meta['fields'][htmlspecialchars($key, ENT_QUOTES, 'UTF-8')] =
                        htmlspecialchars(trim($val), ENT_QUOTES, 'UTF-8');
                }
            }

            $pos += 12 + $chunkLen;
        }

        if (count($meta['fields']) <= 2) {
            $meta['fields']['Metadados Adicionais'] = 'Nenhum chunk de texto encontrado';
        }
    }

    private function readPdfMeta(string $tmp, array &$meta): void
    {
        $raw = file_get_contents($tmp, false, null, 0, 65536);
        if ($raw === false) {
            $meta['fields']['Erro'] = 'Não foi possível ler o arquivo PDF';
            return;
        }

        if (!str_starts_with($raw, '%PDF')) {
            $meta['fields']['Erro'] = 'Arquivo inválido ou corrompido';
            return;
        }

        preg_match('/%PDF-(\d+\.\d+)/', $raw, $ver);
        $meta['fields']['Versão PDF'] = $ver[1] ?? 'Desconhecida';

        $pdfMap = [
            '/Title'    => 'Título',
            '/Author'   => 'Autor',
            '/Subject'  => 'Assunto',
            '/Keywords' => 'Palavras-chave',
            '/Creator'  => 'Criado por',
            '/Producer' => 'Gerado por',
            '/CreationDate' => 'Data de Criação',
            '/ModDate'      => 'Última Modificação',
        ];

        foreach ($pdfMap as $key => $label) {
            if (preg_match('/' . preg_quote($key, '/') . '\s*\(([^)]+)\)/', $raw, $m)) {
                $val = $this->decodePdfString($m[1]);
                if ($val !== '') {
                    $meta['fields'][$label] = htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
                }
            }
        }

        if (count($meta['fields']) <= 1) {
            $meta['fields']['Metadados'] = 'Nenhum metadado encontrado no PDF';
        }
    }

    private function readDocxMeta(string $tmp, array &$meta): void
    {
        if (!class_exists('ZipArchive')) {
            $meta['fields']['Erro'] = 'Extensão ZipArchive não disponível';
            return;
        }

        $zip = new ZipArchive();
        if ($zip->open($tmp) !== true) {
            $meta['fields']['Erro'] = 'Não foi possível abrir o arquivo DOCX';
            return;
        }

        $coreXml = $zip->getFromName('docProps/core.xml');
        $appXml  = $zip->getFromName('docProps/app.xml');
        $zip->close();

        if ($coreXml) {
            $xml = @simplexml_load_string($coreXml);
            if ($xml) {
                $ns   = $xml->getNamespaces(true);
                $dc   = $xml->children($ns['dc'] ?? 'http://purl.org/dc/elements/1.1/');
                $cp   = $xml->children($ns['cp'] ?? 'http://schemas.openxmlformats.org/package/2006/metadata/core-properties');
                $dcterms = $xml->children($ns['dcterms'] ?? 'http://purl.org/dc/terms/');

                $map = [
                    (string)($dc->title      ?? '') => 'Título',
                    (string)($dc->creator    ?? '') => 'Autor',
                    (string)($dc->subject    ?? '') => 'Assunto',
                    (string)($dc->description?? '') => 'Descrição',
                    (string)($cp->keywords   ?? '') => 'Palavras-chave',
                    (string)($cp->lastModifiedBy ?? '') => 'Última Modificação por',
                    (string)($cp->revision   ?? '') => 'Revisão',
                    (string)($dcterms->created  ?? '') => 'Data de Criação',
                    (string)($dcterms->modified ?? '') => 'Última Modificação',
                ];

                foreach ($map as $val => $label) {
                    if ($val !== '') {
                        $meta['fields'][$label] = htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
                    }
                }
            }
        }

        if ($appXml) {
            $xml = @simplexml_load_string($appXml);
            if ($xml) {
                $appMap = [
                    'Application'   => 'Aplicativo',
                    'AppVersion'    => 'Versão do Aplicativo',
                    'Company'       => 'Empresa',
                    'Pages'         => 'Páginas',
                    'Words'         => 'Palavras',
                    'Characters'    => 'Caracteres',
                ];
                foreach ($appMap as $tag => $label) {
                    $val = (string)($xml->$tag ?? '');
                    if ($val !== '') {
                        $meta['fields'][$label] = htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
                    }
                }
            }
        }

        if (count($meta['fields']) === 0) {
            $meta['fields']['Metadados'] = 'Nenhum metadado encontrado no documento';
        }
    }

    private function gpsToDecimal(array $coords, string $ref): float
    {
        $deg = $this->fracToFloat($coords[0] ?? '0/1');
        $min = $this->fracToFloat($coords[1] ?? '0/1');
        $sec = $this->fracToFloat($coords[2] ?? '0/1');

        $decimal = $deg + ($min / 60) + ($sec / 3600);

        if (in_array(strtoupper($ref), ['S', 'W'], true)) {
            $decimal *= -1;
        }

        return round($decimal, 6);
    }

    private function fracToFloat(string $frac): float
    {
        $parts = explode('/', $frac);
        if (count($parts) === 2 && (float)$parts[1] !== 0.0) {
            return (float)$parts[0] / (float)$parts[1];
        }
        return (float)$frac;
    }

    private function decodePdfString(string $str): string
    {
        if (str_starts_with($str, "\xfe\xff")) {
            return mb_convert_encoding(substr($str, 2), 'UTF-8', 'UTF-16BE');
        }
        $str = preg_replace('/D:(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2}).*/', '$1-$2-$3 $4:$5:$6', $str);
        return $str ?? '';
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) return round($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576)   return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)      return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }
}
