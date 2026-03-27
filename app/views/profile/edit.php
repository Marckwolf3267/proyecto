<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark shadow" style="background-color: #3851df;">
    <div class="container">
        <span class="navbar-brand d-flex align-items-center mb-0 h1 fs-5 text-uppercase" style="cursor: default;">
            <i class="bi bi-person-circle me-3 fs-2"></i>
            <span class="d-none d-md-inline ms-2">Mi perfil</span>
        </span>
        <div class="collapse navbar-collapse justify-content-end">
            <div class="d-flex align-items-center">
                <span class="navbar-text text-light fw-medium me-4" style="line-height: 1;">
                    <?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario') ?>
                </span>
                <a href="<?= BASE_URL ?>/logout"
                    class="btn btn-outline-light btn-sm rounded-circle d-flex justify-content-center align-items-center"
                    style="width: 35px; height: 35px;" title="Cerrar sesión">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</nav>

<div class="container my-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
                <div class="p-4 p-md-5 text-white" style="background: linear-gradient(135deg, #3851df, #5c74f7);">
                    <p class="mb-1 text-white-50 text-uppercase fw-semibold" style="letter-spacing: 1px;">Cuenta</p>
                    <h2 class="fw-bold mb-0">Editar perfil</h2>
                </div>

                <div class="card-body p-4 p-md-5">
                    <?php if (!empty($data['flash'])): ?>
                        <div class="alert alert-<?= htmlspecialchars($data['flash']['type']) ?> alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($data['flash']['message']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= BASE_URL ?>/profile/update" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre(s)</label>
                            <input type="text" name="first_name" class="form-control" required
                                value="<?= htmlspecialchars($data['user']['nombre'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Apellidos</label>
                            <input type="text" name="last_name" class="form-control" required
                                value="<?= htmlspecialchars($data['user']['apellido'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Contraseña actual</label>
                            <input type="password" name="current_password" class="form-control"
                                placeholder="Requerida solo si cambiarás la contraseña">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nueva contraseña</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Déjalo vacío si no deseas cambiarla">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirmar contraseña</label>
                            <input type="password" name="password_confirm" class="form-control"
                                placeholder="Repite la nueva contraseña">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold d-block">Foto de perfil</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-light d-flex justify-content-center align-items-center shadow-sm"
                                    style="width: 72px; height: 72px; overflow: hidden;">
                                    <?php if (!empty($data['user']['foto_perfil'])): ?>
                                        <img src="<?= htmlspecialchars($data['user']['foto_perfil']) ?>" alt="Foto actual"
                                            class="w-100 h-100 object-fit-cover">
                                    <?php else: ?>
                                        <i class="bi bi-person-fill fs-1" style="color: #1134f8;"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="profile_photo" accept="image/png, image/jpeg, image/webp"
                                        class="form-control">
                                    <small class="text-muted">Formatos permitidos: JPG, PNG, WEBP. Máx 2MB.</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= BASE_URL ?>/home" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn text-white" style="background-color: #3851df;">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>