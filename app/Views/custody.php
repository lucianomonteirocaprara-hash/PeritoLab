<div class="page-header no-print">
    <h1 class="page-title">
        <i class="bi bi-file-earmark-text me-2" style="color:var(--accent-yellow)"></i>Cadeia de Custódia
    </h1>
    <p class="page-subtitle">Gere documentos formais para registro e preservação de evidências digitais</p>
</div>

<?php if (empty($doc)): ?>
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card-dark">
            <div class="card-dark-header">
                <div class="header-icon" style="background:rgba(245,158,11,.1)">
                    <i class="bi bi-pencil-square" style="color:var(--accent-yellow)"></i>
                </div>
                <div>
                    <div class="header-title">Dados da Evidência</div>
                    <div class="header-sub">Preencha todos os campos obrigatórios</div>
                </div>
            </div>
            <div class="card-dark-body">
                <?php if (!empty($error)): ?>
                    <div class="alert-lab danger mb-3">
                        <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/custody">
                    <div class="mb-3">
                        <label class="form-label-custom">Número do Processo</label>
                        <input type="text"
                               name="process_number"
                               class="form-control form-control-dark"
                               placeholder="Ex: 0001234-56.2024.8.26.0100"
                               value="<?= htmlspecialchars($post['process_number'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Responsável pela Coleta</label>
                        <input type="text"
                               name="responsible"
                               class="form-control form-control-dark"
                               placeholder="Nome completo do perito responsável"
                               value="<?= htmlspecialchars($post['responsible'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Data e Hora da Coleta</label>
                        <input type="datetime-local"
                               name="date"
                               class="form-control form-control-dark"
                               value="<?= htmlspecialchars($post['date'] ?? date('Y-m-d\TH:i'), ENT_QUOTES, 'UTF-8') ?>"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Descrição da Evidência</label>
                        <textarea name="description"
                                  class="form-control form-control-dark"
                                  rows="5"
                                  placeholder="Descreva detalhadamente a evidência coletada: tipo, características, local de coleta, condições, etc."
                                  required><?= htmlspecialchars($post['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>

                    <button type="submit" class="btn-lab w-100">
                        <i class="bi bi-file-earmark-check me-2"></i>Gerar Documento de Custódia
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card-dark h-100 d-flex align-items-center justify-content-center" style="min-height:300px">
            <div class="text-center" style="color:var(--text-muted)">
                <i class="bi bi-file-earmark-text" style="font-size:3rem;opacity:.2;display:block;margin-bottom:1rem"></i>
                <div style="font-size:.8rem">Preencha o formulário para gerar o documento</div>
                <div style="font-size:.68rem;margin-top:.4rem;color:var(--text-dim)">O documento de custódia aparecerá aqui</div>
            </div>
        </div>
    </div>
</div>

<?php else: ?>

<!-- Action bar -->
<div class="d-flex gap-2 mb-4 no-print">
    <a href="/custody" class="btn-lab-outline">
        <i class="bi bi-arrow-left me-1"></i>Novo Documento
    </a>
    <button class="btn-lab" onclick="window.print()">
        <i class="bi bi-printer me-2"></i>Imprimir / Salvar PDF
    </button>
</div>

<!-- Document -->
<div class="custody-doc" style="background:#fff;color:#1a1a2e;max-width:800px">

    <!-- Header -->
    <div style="border-bottom:3px solid #1a1a2e;padding-bottom:1.25rem;margin-bottom:1.5rem">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem">
            <div>
                <div style="font-size:1.4rem;font-weight:800;letter-spacing:-.01em;color:#0B1220">
                    🔒 PeritoLab
                </div>
                <div style="font-size:.72rem;color:#6B7280;text-transform:uppercase;letter-spacing:.1em;margin-top:.15rem">
                    Ferramentas Profissionais para Perícia Digital
                </div>
            </div>
            <div style="text-align:right">
                <div style="font-size:.65rem;color:#6B7280;text-transform:uppercase;letter-spacing:.08em">Protocolo</div>
                <div style="font-family:monospace;font-size:.8rem;font-weight:700;color:#0B1220;background:#F3F4F6;padding:.2rem .6rem;border-radius:4px;margin-top:.2rem">
                    <?= htmlspecialchars($doc['protocol'], ENT_QUOTES, 'UTF-8') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Title -->
    <div style="text-align:center;margin-bottom:2rem">
        <div style="font-size:1.1rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#1a1a2e;border:2px solid #1a1a2e;padding:.6rem 1.5rem;display:inline-block">
            TERMO DE CADEIA DE CUSTÓDIA DE EVIDÊNCIA DIGITAL
        </div>
    </div>

    <!-- Fields -->
    <div style="margin-bottom:1.5rem">
        <table style="width:100%;border-collapse:collapse">
            <tr style="background:#F9FAFB">
                <td style="padding:.75rem 1rem;border:1px solid #E5E7EB;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#6B7280;width:35%">Número do Processo</td>
                <td style="padding:.75rem 1rem;border:1px solid #E5E7EB;font-size:.85rem;font-family:monospace;font-weight:600;color:#1a1a2e"><?= htmlspecialchars($doc['process_number'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <td style="padding:.75rem 1rem;border:1px solid #E5E7EB;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#6B7280">Responsável pela Coleta</td>
                <td style="padding:.75rem 1rem;border:1px solid #E5E7EB;font-size:.85rem;color:#1a1a2e"><?= htmlspecialchars($doc['responsible'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr style="background:#F9FAFB">
                <td style="padding:.75rem 1rem;border:1px solid #E5E7EB;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#6B7280">Data e Hora da Coleta</td>
                <td style="padding:.75rem 1rem;border:1px solid #E5E7EB;font-size:.85rem;color:#1a1a2e"><?= htmlspecialchars($doc['date'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <td style="padding:.75rem 1rem;border:1px solid #E5E7EB;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#6B7280">Gerado em</td>
                <td style="padding:.75rem 1rem;border:1px solid #E5E7EB;font-size:.85rem;font-family:monospace;color:#1a1a2e"><?= htmlspecialchars($doc['generated_at'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        </table>
    </div>

    <!-- Description -->
    <div style="margin-bottom:2rem">
        <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#6B7280;margin-bottom:.6rem">Descrição da Evidência</div>
        <div style="border:1px solid #E5E7EB;border-radius:6px;padding:1rem;font-size:.85rem;line-height:1.7;color:#1a1a2e;background:#FAFAFA;min-height:80px">
            <?= nl2br(htmlspecialchars($doc['description'], ENT_QUOTES, 'UTF-8')) ?>
        </div>
    </div>

    <!-- Declaration -->
    <div style="margin-bottom:2rem;padding:1rem;background:#F0F9FF;border:1px solid #BAE6FD;border-radius:6px;font-size:.78rem;color:#0369A1;line-height:1.7">
        <strong>Declaração:</strong> Declaro que a evidência descrita neste documento foi coletada de acordo
        com os procedimentos técnicos e legais vigentes, mantendo a cadeia de custódia e garantindo a
        integridade, autenticidade e admissibilidade da prova digital nos termos da legislação aplicável.
    </div>

    <!-- Signature -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;margin-bottom:2rem">
        <div>
            <div style="border-top:1px solid #1a1a2e;padding-top:.5rem">
                <div style="font-size:.72rem;color:#6B7280;text-align:center">Assinatura do Responsável</div>
                <div style="font-size:.78rem;font-weight:600;color:#1a1a2e;text-align:center;margin-top:.25rem">
                    <?= htmlspecialchars($doc['responsible'], ENT_QUOTES, 'UTF-8') ?>
                </div>
            </div>
        </div>
        <div>
            <div style="border-top:1px solid #1a1a2e;padding-top:.5rem">
                <div style="font-size:.72rem;color:#6B7280;text-align:center">Data e Assinatura da Testemunha</div>
                <div style="font-size:.78rem;color:#9CA3AF;text-align:center;margin-top:.25rem">________________________</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div style="border-top:1px solid #E5E7EB;padding-top:.75rem;font-size:.62rem;color:#9CA3AF;display:flex;justify-content:space-between">
        <span>PeritoLab · Sistema de Gestão de Evidências Digitais</span>
        <span>Protocolo: <?= htmlspecialchars($doc['protocol'], ENT_QUOTES, 'UTF-8') ?></span>
    </div>
</div>

<?php endif; ?>
