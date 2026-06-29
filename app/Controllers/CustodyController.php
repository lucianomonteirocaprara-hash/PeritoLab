<?php
declare(strict_types=1);

class CustodyController extends Controller
{
    public function index(): void
    {
        $this->render('custody', [
            'pageTitle'  => 'Cadeia de Custódia',
            'activeMenu' => 'custody',
        ]);
    }

    public function process(): void
    {
        $error = null;
        $doc   = null;

        $fields = [
            'process_number' => 'Número do Processo',
            'responsible'    => 'Responsável pela Coleta',
            'date'           => 'Data',
            'description'    => 'Descrição da Evidência',
        ];

        $data = [];
        foreach ($fields as $key => $label) {
            $val = trim($_POST[$key] ?? '');
            if ($val === '') {
                $error = "O campo \"{$label}\" é obrigatório.";
                break;
            }
            $data[$key] = htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
        }

        if (!$error) {
            $doc = [
                'process_number'  => $data['process_number'],
                'responsible'     => $data['responsible'],
                'date'            => $data['date'],
                'description'     => $data['description'],
                'generated_at'    => date('d/m/Y \à\s H:i:s'),
                'protocol'        => strtoupper(bin2hex(random_bytes(8))),
            ];
        }

        $this->render('custody', [
            'pageTitle'  => 'Cadeia de Custódia',
            'activeMenu' => 'custody',
            'doc'        => $doc,
            'error'      => $error,
            'post'       => $_POST,
        ]);
    }
}
