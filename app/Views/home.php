<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-shield-lock me-2" style="color:var(--accent-cyan)"></i>Dashboard
    </h1>
    <p class="page-subtitle">Ferramentas Profissionais para Perícia Digital e Preservação de Evidências</p>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-box">
            <div class="stat-val">4</div>
            <div class="stat-lbl">Ferramentas</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-box">
            <div class="stat-val" style="color:var(--accent-green)">Online</div>
            <div class="stat-lbl">Status</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-box">
            <div class="stat-val" style="color:var(--accent-yellow)">4</div>
            <div class="stat-lbl">Algoritmos Hash</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-box">
            <div class="stat-val" style="font-size:.9rem">PHP <?= PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION ?></div>
            <div class="stat-lbl">Engine</div>
        </div>
    </div>
</div>

<!-- Alert banner -->
<div class="alert-lab success mb-4 d-flex align-items-center gap-2">
    <i class="bi bi-shield-check-fill"></i>
    <span>Sistema PeritoLab operacional. Todas as ferramentas estão disponíveis e prontas para uso forense.</span>
</div>

<!-- Tools Grid -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
        <a href="/hash" class="tool-card h-100">
            <i class="bi bi-arrow-up-right-circle tool-card-arrow"></i>
            <div class="tool-card-icon" style="background:rgba(0,229,255,.1);color:var(--accent-cyan)">
                <i class="bi bi-hash"></i>
            </div>
            <div class="tool-card-title">Gerador de Hash</div>
            <p class="tool-card-desc">
                Calcule hashes criptográficos de arquivos para garantir autenticidade e integridade.
                Suporte a MD5, SHA-1, SHA-256 e SHA-512.
            </p>
            <div class="mt-3 d-flex gap-2 flex-wrap">
                <span class="badge-algo md5">MD5</span>
                <span class="badge-algo sha1">SHA-1</span>
                <span class="badge-algo sha256">SHA-256</span>
                <span class="badge-algo sha512">SHA-512</span>
            </div>
        </a>
    </div>

    <div class="col-12 col-md-6">
        <a href="/integrity" class="tool-card h-100">
            <i class="bi bi-arrow-up-right-circle tool-card-arrow"></i>
            <div class="tool-card-icon" style="background:rgba(16,185,129,.1);color:var(--accent-green)">
                <i class="bi bi-shield-check"></i>
            </div>
            <div class="tool-card-title">Verificador de Integridade</div>
            <p class="tool-card-desc">
                Compare dois arquivos utilizando SHA-256 para verificar se houve alteração ou adulteração
                de evidências digitais.
            </p>
            <div class="mt-3">
                <span class="badge-algo sha256">SHA-256</span>
                <span class="ms-2" style="font-size:.68rem;color:var(--text-muted)">Comparação byte a byte</span>
            </div>
        </a>
    </div>

    <div class="col-12 col-md-6">
        <a href="/custody" class="tool-card h-100">
            <i class="bi bi-arrow-up-right-circle tool-card-arrow"></i>
            <div class="tool-card-icon" style="background:rgba(245,158,11,.1);color:var(--accent-yellow)">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div class="tool-card-title">Cadeia de Custódia</div>
            <p class="tool-card-desc">
                Gere documentos formais de cadeia de custódia para registrar o processo de coleta
                e preservação de evidências digitais com protocolo único.
            </p>
            <div class="mt-3">
                <span style="font-size:.68rem;color:var(--text-muted)">
                    <i class="bi bi-file-pdf me-1" style="color:var(--accent-yellow)"></i>Exportação para impressão / PDF
                </span>
            </div>
        </a>
    </div>

    <div class="col-12 col-md-6">
        <a href="/metadata" class="tool-card h-100">
            <i class="bi bi-arrow-up-right-circle tool-card-arrow"></i>
            <div class="tool-card-icon" style="background:rgba(139,92,246,.1);color:#A78BFA">
                <i class="bi bi-search"></i>
            </div>
            <div class="tool-card-title">Metadata Inspector</div>
            <p class="tool-card-desc">
                Extraia e analise metadados ocultos de arquivos PDF, DOCX, JPG e PNG.
                Revele autor, software, datas e coordenadas GPS quando disponíveis.
            </p>
            <div class="mt-3 d-flex gap-2 flex-wrap">
                <span class="badge-algo" style="background:rgba(139,92,246,.1);color:#A78BFA;border:1px solid rgba(139,92,246,.2)">PDF</span>
                <span class="badge-algo" style="background:rgba(139,92,246,.1);color:#A78BFA;border:1px solid rgba(139,92,246,.2)">DOCX</span>
                <span class="badge-algo" style="background:rgba(139,92,246,.1);color:#A78BFA;border:1px solid rgba(139,92,246,.2)">JPG</span>
                <span class="badge-algo" style="background:rgba(139,92,246,.1);color:#A78BFA;border:1px solid rgba(139,92,246,.2)">PNG</span>
            </div>
        </a>
    </div>
</div>

<!-- Info bar -->
<div class="card-dark">
    <div class="card-dark-body">
        <div class="row align-items-center g-3">
            <div class="col-md-8">
                <div class="d-flex align-items-start gap-3">
                    <div style="width:36px;height:36px;background:rgba(0,229,255,.1);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi bi-info-circle" style="color:var(--accent-cyan)"></i>
                    </div>
                    <div>
                        <div style="font-size:.8rem;font-weight:600;margin-bottom:.2rem">Aviso Legal</div>
                        <div style="font-size:.72rem;color:var(--text-muted);line-height:1.6">
                            PeritoLab é uma plataforma destinada exclusivamente a profissionais de perícia digital e
                            forense computacional. O uso deve estar em conformidade com a legislação vigente e
                            procedimentos legais aplicáveis.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <div style="font-family:var(--font-mono);font-size:.65rem;color:var(--text-muted)">
                    <div>Sessão iniciada: <span style="color:var(--accent-green)"><?= date('d/m/Y H:i:s') ?></span></div>
                    <div>IP: <span style="color:var(--accent-green)"><?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1', ENT_QUOTES, 'UTF-8') ?></span></div>
                </div>
            </div>
        </div>
    </div>
</div>
