<!-- app/views/auth/register.php -->
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
                            <h2 class="mt-3 fw-bold" style="color: #3851df;">Crear una Cuenta</h2>
                            <p class="text-muted">Completa el formulario para registrarte</p>
                        </div>

                        <?php if (!empty($data['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($data['error']) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= BASE_URL ?>/process_register" method="POST" id="registerForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fw-semibold">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required 
                                        value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="apellido" class="form-label fw-semibold">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" required 
                                        value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="mt-3">
                                <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required 
                                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                            </div>

                            <div class="mt-3">
                                <label for="password" class="form-label fw-semibold">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <!-- Validador de contraseña (JS) -->
                                <div id="password-validator" class="mt-2 small"></div>
                            </div>

                            <div class="mt-3">
                                <label for="role" class="form-label fw-semibold">Quiero registrarme como</label>
                                <select name="role" id="role" class="form-select">
                                    <option value="paciente">Paciente</option>
                                    <option value="fisioterapeuta">Fisioterapeuta</option>
                                </select>
                                <small class="text-muted">Los fisioterapeutas son registrados por un administrador.</small>
                            </div>

                            <?php if (!empty($data['error_general'])): ?>
                                <div class="alert alert-danger mt-3"><?= htmlspecialchars($data['error_general']) ?></div>
                            <?php endif; ?>

                            <button type="submit" class="btn btn-lg w-100 mt-4 text-white fw-bold" 
                                style="background-color: #3851df; border-radius: 8px;" id="register-btn">
                                Registrarse
                            </button>
                        </form>

                        <p class="text-center mt-4 text-muted">
                            ¿Ya tienes una cuenta? 
                            <a href="<?= BASE_URL ?>/login" class="fw-semibold text-decoration-none" 
                                style="color: #3851df;">Inicia sesión</a>
                        </p>
                    </div>

                    <!-- Columna informativa -->
                    <div class="col-md-6 p-4 p-lg-5 bg-light" style="background: #f8f9fa;">
                        <div class="h-100 d-flex flex-column justify-content-center">
                            <div class="border-start border-4 ps-3 mb-4" style="border-color: #3851df !important;">
                                <h3 class="fw-bold mb-0" style="color: #3851df;">Requisitos de la cuenta</h3>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-3 d-flex">
                                    <i class="bi bi-shield-lock me-3 fs-5" style="color: #3851df;"></i>
                                    <div>
                                        <strong>Contraseña segura:</strong> Mínimo 8 caracteres, una mayúscula, una minúscula y un número.
                                    </div>
                                </li>
                                <li class="mb-3 d-flex">
                                    <i class="bi bi-envelope-paper me-3 fs-5" style="color: #3851df;"></i>
                                    <div>
                                        <strong>Correo válido:</strong> Recibirás un enlace de confirmación (próximamente).
                                    </div>
                                </li>
                                <li class="mb-3 d-flex">
                                    <i class="bi bi-person-vcard me-3 fs-5" style="color: #3851df;"></i>
                                    <div>
                                        <strong>Rol:</strong> Si eres fisioterapeuta, un administrador validará tu registro.
                                    </div>
                                </li>
                            </ul>
                            <div class="mt-4 text-muted small">
                                <i class="bi bi-info-circle me-1"></i> 
                                Tus datos están protegidos conforme a la ley de protección de datos.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const validatorDiv = document.getElementById('password-validator');
    const registerBtn = document.getElementById('register-btn');

    // Definir requisitos
    const requirements = [
        { regex: /.{8,}/, text: 'Al menos 8 caracteres', icon: 'bi bi-check-circle-fill' },
        { regex: /[A-Z]/, text: 'Al menos una mayúscula', icon: 'bi bi-check-circle-fill' },
        { regex: /[a-z]/, text: 'Al menos una minúscula', icon: 'bi bi-check-circle-fill' },
        { regex: /\d/, text: 'Al menos un número', icon: 'bi bi-check-circle-fill' }
    ];

    function updatePasswordValidator() {
        const password = passwordInput.value;
        let allValid = true;
        let html = '<ul class="list-unstyled mb-0">';
        requirements.forEach(req => {
            const isValid = req.regex.test(password);
            if (!isValid) allValid = false;
            const iconClass = isValid ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger';
            html += `<li class="d-flex align-items-center small mb-1">
                        <i class="bi ${iconClass} me-2"></i>
                        <span class="${isValid ? 'text-success' : 'text-muted'}">${req.text}</span>
                    </li>`;
        });
        html += '</ul>';
        validatorDiv.innerHTML = html;
        registerBtn.disabled = !allValid;
        // Cambiar estilo del botón según estado
        if (!allValid) {
            registerBtn.classList.add('opacity-50');
        } else {
            registerBtn.classList.remove('opacity-50');
        }
    }

    passwordInput.addEventListener('input', updatePasswordValidator);
    updatePasswordValidator(); // inicializar
});
</script>