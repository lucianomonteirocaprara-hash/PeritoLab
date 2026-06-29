<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-search me-2" style="color:#A78BFA"></i>Metadata Inspector
    </h1>
    <p class="page-subtitle">Extraia metadados ocultos de PDF, DOCX, JPG e PNG — incluindo EXIF e coordenadas GPS</p>
</div>

<div class="row g-4">
    <!-- Form -->
    <div class="col-lg-4">
        <div class="card-dark">
            <div class="card-dark-header">
                <div class="header-icon" style="background:rgba(139,92,246,.1)">
                    <i class="bi bi-file-earmark-search" style="color:#A78BFA"></i>
                </div>
                <div>
                    <div class="header-title">Analisar Arquivo</div>
                    <div class="header-sub">PDF · DOCX · JPG · PNG</div>
                </div>
            </div>
            <div class="card-dark-body">
                <?php if (!empty($error)): ?>
                    <div class="alert-lab danger mb-3">
                        <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/metadata" enctype="multipart/form-data">
                    <div class="mb-4">
                        <div class="upload-zone">
                            <input type="file" name="file" accept=".pdf,.docx,.jpg,.jpeg,.png" required>
                            <i class="bi bi-file-earmark-search upload-icon" style="color:#A78BFA"></i>
                            <div class="upload-text">
                                <strong>Clique ou arraste o arquivo</strong>
                            </div>
                            <div class="mt-2" style="font-size:.65rem;color:var(--text-muted)">
                                PDF · DOCX · JPG · PNG
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-label-custom">Formatos suportados</div>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge-algo" style="background:rgba(139,92,246,.1);color:#A78BFA;border:1px solid rgba(139,92,246,.2)">PDF</span>
                            <span class="badge-algo" style="background:rgba(139,92,246,.1);color:#A78BFA;border:1px solid rgba(139,92,246,.2)">DOCX</span>
                            <span class="badge-algo" style="background:rgba(139,92,246,.1);color:#A78BFA;border:1px solid rgba(139,92,246,.2)">JPG</span>
                            <span class="badge-algo" style="background:rgba(139,92,246,.1);color:#A78BFA;border:1px solid rgba(139,92,246,.2)">PNG</span>
                        </div>
                    </div>

                    <button type="submit" class="btn-lab w-100" style="background:linear-gradient(135deg,#7C3AED,#A78BFA);color:#fff">
                        <i class="bi bi-search me-2"></i>Extrair Metadados
                    </button>
                </form>

                <div class="mt-3" style="font-size:.68rem;color:var(--text-muted);line-height:1.6">
                    <i class="bi bi-lock-fill me-1" style="color:var(--accent-green)"></i>
                    O arquivo é processado localmente no servidor e não é armazenado.
                </div>
            </div>
        </div>
    </div>

    <!-- Results -->
    <div class="col-lg-8">
        <?php if (!empty($result)): ?>

        <!-- File info header -->
        <div class="card-dark mb-3">
            <div class="card-dark-body" style="padding:.85rem 1.25rem">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:40px;height:40px;background:rgba(139,92,246,.1);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0">
                        <i class="bi bi-file-earmark" style="color:#A78BFA"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div style="font-size:.85rem;font-weight:600;color:var(--text-primary);word-break:break-all"><?= htmlspecialchars($result['filename'], ENT_QUOTES, 'UTF-8') ?></div>
                        <div style="font-size:.68rem;color:var(--text-muted);margin-top:.1rem">
                            <span class="badge-algo" style="background:rgba(139,92,246,.1);color:#A78BFA;border:1px solid rgba(139,92,246,.2)"><?= $result['extension'] ?></span>
                            <span class="ms-2"><?= $result['filesize'] ?></span>
                        </div>
                    </div>
                    <?php if (!empty($result['gps'])): ?>
                    <div class="gps-badge">
                        <i class="bi bi-geo-alt-fill"></i>GPS
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (!empty($result['gps'])): ?>
        <!-- GPS Alert -->
        <div class="alert-lab success mb-3">
            <i class="bi bi-geo-alt-fill me-2"></i>
            <strong>Coordenadas GPS detectadas!</strong>
            Lat: <span style="font-family:var(--font-mono)"><?= $result['gps']['lat'] ?></span> ·
            Lon: <span style="font-family:var(--font-mono)"><?= $result['gps']['lon'] ?></span>
            <a href="https://www.google.com/maps/search/?api=1&query=<?= $result['gps']['lat'] ?>,<?= $result['gps']['lon'] ?>"
               target="_blank" rel="noopener"
               style="margin-left:.75rem;color:var(--accent-green);font-size:.72rem">
                <i class="bi bi-map me-1"></i>Ver no mapa →
            </a>
        </div>
        <?php endif; ?>

        <!-- Metadata table -->
        <div class="card-dark">
            <div class="card-dark-header">
                <div class="header-title">Metadados Extraídos</div>
                <span class="ms-auto" style="font-size:.65rem;color:var(--text-muted)"><?= count($result['fields']) ?> campos</span>
            </div>
            <div class="card-dark-body" style="padding:0">
                <?php if (!empty($result['fields'])): ?>
                <table class="meta-table">
                    <?php foreach ($result['fields'] as $key => $val): ?>
                    <tr>
                        <td class="meta-key"><?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="meta-val">
                            <div class="d-flex align-items-start justify-content-between gap-2">
                                <span><?= htmlspecialchars($val, ENT_QUOTES, 'UTF-8') ?></span>
                                <button class="btn-copy flex-shrink-0"
                                        onclick="copyToClipboard('<?= htmlspecialchars($val, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?>')">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                <div style="padding:2rem;text-align:center;color:var(--text-muted);font-size:.8rem">
                    <i class="bi bi-info-circle d-block mb-2" style="font-size:1.5rem;opacity:.4"></i>
                    Nenhum metadado encontrado neste arquivo
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php else: ?>
        <div class="card-dark h-100 d-flex align-items-center justify-content-center" style="min-height:360px">
            <div class="text-center" style="color:var(--text-muted)">
                <i class="bi bi-search" style="font-size:3rem;opacity:.2;display:block;margin-bottom:1rem"></i>
                <div style="font-size:.8rem">Selecione um arquivo para extrair metadados</div>
                <div style="font-size:.68rem;margin-top:.4rem;color:var(--text-dim)">
                    Suporte a PDF, DOCX, JPG e PNG
                </div>
                <div style="font-size:.68rem;margin-top:.8rem;color:var(--text-dim);max-width:280px;margin-left:auto;margin-right:auto;line-height:1.5">
                    Informações como autor, software, datas e coordenadas GPS (quando disponíveis) serão exibidas aqui
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
