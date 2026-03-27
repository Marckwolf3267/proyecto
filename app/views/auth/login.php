<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light" style="background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row g-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <!-- Columna del formulario -->
                    <div class="col-md-6 p-4 p-lg-5">
                        <div class="text-center mb-4">
                            <a href="<?= BASE_URL ?>" class="d-inline-block">
                                <img src="<?= BASE_URL ?>/public/img/logo.png" alt="FisioUPA Logo" 
                                    style="height: 60px; width: auto;">
                            </a>
                            <h2 class="mt-3 fw-bold" style="color: #3851df;">Iniciar Sesión</h2>
                            <p class="text-muted">Ingresa a tu cuenta para gestionar tu salud</p>
                        </div>

                        <?php if (!empty($data['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($data['error']) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($data['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($data['success']) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= BASE_URL ?>/process_login" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                    placeholder="tu@email.com" required autocomplete="email">
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="password" class="form-label fw-semibold">Contraseña</label>
                                    <a href="<?= BASE_URL ?>/forgot-password" class="text-decoration-none small" 
                                        style="color: #3851df;">¿Olvidaste tu contraseña?</a>
                                </div>
                                <input type="password" class="form-control form-control-lg" id="password" name="password" 
                                    required autocomplete="current-password">
                            </div>

                            <button type="submit" class="btn btn-lg w-100 text-white fw-bold" 
                                style="background-color: #3851df; border-radius: 8px;">
                                Iniciar Sesión
                            </button>
                        </form>

                        <p class="text-center mt-4 text-muted">
                            ¿No tienes una cuenta? 
                            <a href="<?= BASE_URL ?>/register" class="fw-semibold text-decoration-none" 
                                style="color: #3851df;">Regístrate aquí</a>
                        </p>
                    </div>

                    <!-- Columna informativa -->
                    <div class="col-md-6 p-4 p-lg-5 bg-light" style="background: #f8f9fa;">
                        <div class="h-100 d-flex flex-column justify-content-center">
                            <div class="border-start border-4 ps-3 mb-4" style="border-color: #3851df !important;">
                                <h3 class="fw-bold mb-0" style="color: #3851df;">Proceso de Registro</h3>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-3 d-flex">
                                    <i class="bi bi-person-fill-check me-3 fs-5" style="color: #3851df;"></i>
                                    <div>
                                        <strong>Pacientes:</strong> Pueden registrarse directamente usando el formulario de registro.
                                    </div>
                                </li>
                                <li class="mb-3 d-flex">
                                    <i class="bi bi-shield-fill-check me-3 fs-5" style="color: #3851df;"></i>
                                    <div>
                                        <strong>Fisioterapeutas:</strong> Son registrados por un Administrador del sistema.
                                    </div>
                                </li>
                                <li class="mb-3 d-flex">
                                    <i class="bi bi-person-badge me-3 fs-5" style="color: #3851df;"></i>
                                    <div>
                                        <strong>Administradores y Superusuarios:</strong> Son creados únicamente por un Superusuario.
                                    </div>
                                </li>
                            </ul>
                            <div class="mt-4 text-muted small">
                                <i class="bi bi-info-circle me-1"></i> 
                                Para cualquier duda, contacta al soporte técnico.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>