<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-shield-check me-2" style="color:var(--accent-green)"></i>Verificador de Integridade
    </h1>
    <p class="page-subtitle">Compare dois arquivos via SHA-256 para verificar se houve adulteração</p>
</div>

<div class="row g-4">
    <!-- Form -->
    <div class="col-lg-5">
        <div class="card-dark">
            <div class="card-dark-header">
                <div class="header-icon" style="background:rgba(16,185,129,.1)">
                    <i class="bi bi-files" style="color:var(--accent-green)"></i>
                </div>
                <div>
                    <div class="header-title">Comparação de Arquivos</div>
                    <div class="header-sub">Dois arquivos para cotejo SHA-256</div>
                </div>
            </div>
            <div class="card-dark-body">
                <?php if (!empty($error)): ?>
                    <div class="alert-lab danger mb-3">
                        <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/integrity" enctype="multipart/form-data">
                    <div class="mb-3">
                        <div class="form-label-custom">
                            <i class="bi bi-file-earmark me-1" style="color:var(--accent-cyan)"></i>Arquivo Original
                        </div>
                        <div class="upload-zone">
                            <input type="file" name="file1" required>
                            <i class="bi bi-file-earmark-check upload-icon" style="color:var(--accent-cyan);font-size:1.5rem"></i>
                            <div class="upload-text">
                                <strong>Arquivo 1</strong> — Original / Referência
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-label-custom">
                            <i class="bi bi-file-earmark me-1" style="color:#A78BFA"></i>Arquivo para Verificação
                        </div>
                        <div class="upload-zone">
                            <input type="file" name="file2" required>
                            <i class="bi bi-file-earmark-check upload-icon" style="color:#A78BFA;font-size:1.5rem"></i>
                            <div class="upload-text">
                                <strong>Arquivo 2</strong> — Suspeito / Cópia
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-lab w-100">
                        <i class="bi bi-shield-check me-2"></i>Verificar Integridade
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Results -->
    <div class="col-lg-7">
        <?php if (!empty($result)): ?>

        <!-- Verdict -->
        <div class="result-panel <?= $result['identical'] ? 'result-identical' : 'result-different' ?> mb-4">
            <div class="d-flex align-items-center gap-3">
                <div style="width:52px;height:52px;border-radius:12px;background:<?= $result['identical'] ? 'rgba(16,185,129,.15)' : 'rgba(239,68,68,.15)' ?>;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0">
                    <i class="bi <?= $result['identical'] ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?>" style="color:<?= $result['identical'] ? 'var(--accent-green)' : 'var(--accent-red)' ?>"></i>
                </div>
                <div>
                    <div style="font-size:1.1rem;font-weight:700;color:<?= $result['identical'] ? 'var(--accent-green)' : 'var(--accent-red)' ?>">
                        <?= $result['identical'] ? 'Arquivos Idênticos' : 'Arquivos Diferentes' ?>
                    </div>
                    <div style="font-size:.72rem;color:var(--text-muted);margin-top:.15rem">
                        <?php if ($result['identical']): ?>
                            Os hashes SHA-256 são iguais — nenhuma alteração detectada
                        <?php else: ?>
                            Os hashes SHA-256 divergem — possível adulteração ou corrupção
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- File details -->
        <div class="card-dark mb-4">
            <div class="card-dark-header">
                <div class="header-title">Detalhes da Comparação</div>
                <span class="ms-auto" style="font-family:var(--font-mono);font-size:.62rem;color:var(--text-muted)"><?= $result['datetime'] ?></span>
            </div>
            <div class="card-dark-body">

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div style="padding:.75rem;background:var(--bg-base);border-radius:7px;border:1px solid var(--border)">
                            <div style="font-size:.65rem;color:var(--accent-cyan);font-weight:700;letter-spacing:.08em;text-transform:uppercase;margin-bottom:.3rem">Arquivo 1 — Original</div>
                            <div style="font-size:.78rem;color:var(--text-primary);font-family:var(--font-mono);word-break:break-all"><?= htmlspecialchars($result['file1'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div style="font-size:.65rem;color:var(--text-muted);margin-top:.2rem"><?= $result['size1'] ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="padding:.75rem;background:var(--bg-base);border-radius:7px;border:1px solid var(--border)">
                            <div style="font-size:.65rem;color:#A78BFA;font-weight:700;letter-spacing:.08em;text-transform:uppercase;margin-bottom:.3rem">Arquivo 2 — Verificação</div>
                            <div style="font-size:.78rem;color:var(--text-primary);font-family:var(--font-mono);word-break:break-all"><?= htmlspecialchars($result['file2'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div style="font-size:.65rem;color:var(--text-muted);margin-top:.2rem"><?= $result['size2'] ?></div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="hash-label"><span class="badge-algo sha256 me-1">SHA-256</span> Arquivo 1</span>
                        <button class="btn-copy" onclick="copyToClipboard('<?= $result['hash1'] ?>')"><i class="bi bi-clipboard"></i></button>
                    </div>
                    <div class="hash-value"><?= $result['hash1'] ?></div>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="hash-label"><span class="badge-algo sha256 me-1">SHA-256</span> Arquivo 2</span>
                        <button class="btn-copy" onclick="copyToClipboard('<?= $result['hash2'] ?>')"><i class="bi bi-clipboard"></i></button>
                    </div>
                    <div class="hash-value <?= !$result['identical'] ? 'text-danger' : '' ?>"><?= $result['hash2'] ?></div>
                </div>

                <?php if (!$result['identical']): ?>
                <div class="alert-lab danger" style="margin-top:.75rem">
                    <i class="bi bi-exclamation-octagon me-2"></i>
                    <strong>Atenção:</strong> A divergência indica que os arquivos possuem conteúdo diferente.
                    Isso pode indicar adulteração, corrupção ou diferentes versões do mesmo arquivo.
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php else: ?>
        <div class="card-dark h-100 d-flex align-items-center justify-content-center" style="min-height:300px">
            <div class="text-center" style="color:var(--text-muted)">
                <i class="bi bi-shield-check" style="font-size:3rem;opacity:.2;display:block;margin-bottom:1rem"></i>
                <div style="font-size:.8rem">Faça upload dos dois arquivos para comparar</div>
                <div style="font-size:.68rem;margin-top:.4rem;color:var(--text-dim)">O laudo de integridade aparecerá aqui</div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
