<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-hash me-2" style="color:var(--accent-cyan)"></i>Gerador de Hash
    </h1>
    <p class="page-subtitle">Calcule hashes criptográficos de arquivos — MD5, SHA-1, SHA-256 e SHA-512</p>
</div>

<div class="row g-4">
    <!-- Form -->
    <div class="col-lg-5">
        <div class="card-dark">
            <div class="card-dark-header">
                <div class="header-icon" style="background:rgba(0,229,255,.1)">
                    <i class="bi bi-upload" style="color:var(--accent-cyan)"></i>
                </div>
                <div>
                    <div class="header-title">Upload de Arquivo</div>
                    <div class="header-sub">Qualquer tipo de arquivo</div>
                </div>
            </div>
            <div class="card-dark-body">
                <?php if (!empty($error)): ?>
                    <div class="alert-lab danger mb-3">
                        <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/hash" enctype="multipart/form-data">
                    <div class="mb-4">
                        <div class="upload-zone" id="uploadZone">
                            <input type="file" name="file" id="fileInput" required>
                            <i class="bi bi-cloud-upload upload-icon"></i>
                            <div class="upload-text">
                                Arraste e solte ou<br>
                                <strong>Clique para selecionar arquivo</strong>
                            </div>
                            <div class="mt-2" style="font-size:.65rem;color:var(--text-muted)">
                                Qualquer tipo · Sem limite de formato
                            </div>
                        </div>
                        <div id="fileInfo" class="mt-2" style="display:none;font-size:.72rem;font-family:var(--font-mono);color:var(--accent-green)">
                            <i class="bi bi-file-check me-1"></i><span id="fileName"></span>
                            <span id="fileSize" class="ms-2 text-muted"></span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-label-custom">Algoritmos</div>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge-algo md5">MD5</span>
                            <span class="badge-algo sha1">SHA-1</span>
                            <span class="badge-algo sha256">SHA-256</span>
                            <span class="badge-algo sha512">SHA-512</span>
                        </div>
                        <div style="font-size:.68rem;color:var(--text-muted);margin-top:.5rem">
                            Todos os algoritmos serão calculados simultaneamente
                        </div>
                    </div>

                    <button type="submit" class="btn-lab w-100">
                        <i class="bi bi-calculator me-2"></i>Calcular Hashes
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Results -->
    <div class="col-lg-7">
        <?php if (!empty($result)): ?>
        <div class="card-dark">
            <div class="card-dark-header">
                <div class="header-icon" style="background:rgba(16,185,129,.1)">
                    <i class="bi bi-check-circle" style="color:var(--accent-green)"></i>
                </div>
                <div>
                    <div class="header-title">Resultado</div>
                    <div class="header-sub"><?= htmlspecialchars($result['filename'], ENT_QUOTES, 'UTF-8') ?> · <?= $result['size'] ?></div>
                </div>
                <div class="ms-auto">
                    <span style="font-family:var(--font-mono);font-size:.62rem;color:var(--text-muted)"><?= $result['datetime'] ?></span>
                </div>
            </div>
            <div class="card-dark-body">

                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="hash-label"><span class="badge-algo md5 me-1">MD5</span> Hash</span>
                        <button class="btn-copy" onclick="copyToClipboard('<?= $result['md5'] ?>')"><i class="bi bi-clipboard"></i></button>
                    </div>
                    <div class="hash-value"><?= $result['md5'] ?></div>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="hash-label"><span class="badge-algo sha1 me-1">SHA-1</span> Hash</span>
                        <button class="btn-copy" onclick="copyToClipboard('<?= $result['sha1'] ?>')"><i class="bi bi-clipboard"></i></button>
                    </div>
                    <div class="hash-value"><?= $result['sha1'] ?></div>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="hash-label"><span class="badge-algo sha256 me-1">SHA-256</span> Hash</span>
                        <button class="btn-copy" onclick="copyToClipboard('<?= $result['sha256'] ?>')"><i class="bi bi-clipboard"></i></button>
                    </div>
                    <div class="hash-value"><?= $result['sha256'] ?></div>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="hash-label"><span class="badge-algo sha512 me-1">SHA-512</span> Hash</span>
                        <button class="btn-copy" onclick="copyToClipboard('<?= $result['sha512'] ?>')"><i class="bi bi-clipboard"></i></button>
                    </div>
                    <div class="hash-value"><?= $result['sha512'] ?></div>
                </div>

                <hr style="border-color:var(--border);margin:1rem 0">
                <div style="font-size:.68rem;color:var(--text-muted);font-family:var(--font-mono)">
                    <i class="bi bi-info-circle me-1"></i>
                    Gerado em <?= $result['datetime'] ?> · Processado localmente no servidor
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="card-dark h-100 d-flex align-items-center justify-content-center" style="min-height:300px">
            <div class="text-center" style="color:var(--text-muted)">
                <i class="bi bi-hash" style="font-size:3rem;opacity:.2;display:block;margin-bottom:1rem"></i>
                <div style="font-size:.8rem">Faça upload de um arquivo para calcular os hashes</div>
                <div style="font-size:.68rem;margin-top:.4rem;color:var(--text-dim)">Os resultados aparecerão aqui</div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.getElementById('fileInput')?.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    document.getElementById('fileInfo').style.display = 'block';
    document.getElementById('fileName').textContent = file.name;
    const size = file.size;
    let sizeStr;
    if (size >= 1048576) sizeStr = (size/1048576).toFixed(2) + ' MB';
    else if (size >= 1024) sizeStr = (size/1024).toFixed(2) + ' KB';
    else sizeStr = size + ' B';
    document.getElementById('fileSize').textContent = '(' + sizeStr + ')';
});
</script>
