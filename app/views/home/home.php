<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark shadow" style="background-color: #3851df;">
    <div class="container">
        <span class="navbar-brand d-flex align-items-center mb-0 h1 fs-5 text-uppercase" style="cursor: default;">
            <i class="bi bi-heart-pulse me-3 fs-2"></i>
            <span class="d-none d-md-inline ms-2">FISIOUPA - Área de Pacientes</span>
        </span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <div class="d-flex align-items-center">
                <!-- Foto de perfil -->
                <?php if (!empty($data['profile_photo'])): ?>
                    <img src="<?= htmlspecialchars($data['profile_photo']) ?>" alt="Foto de Perfil"
                        class="rounded-circle me-2 object-fit-cover shadow-sm"
                        style="width: 38px; height: 38px; border: 2px solid white;">
                <?php else: ?>
                    <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2 shadow-sm"
                        style="width: 38px; height: 38px; color: #3851df; border: 2px solid white;">
                        <i class="bi bi-person-fill fs-5"></i>
                    </div>
                <?php endif; ?>
                <span class="navbar-text text-light fw-medium me-4" style="line-height: 1;">
                    ¡Hola, <?= htmlspecialchars($data['first_name']) ?>!
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

<!-- Panel principal -->
<div class="container my-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
                <!-- Encabezado con saludo personalizado -->
                <div class="p-5 text-white" style="background: linear-gradient(135deg, #3851df, #6e83f8);">
                    <h2 class="fw-bold mb-2">Bienvenido a tu área de salud, <?= htmlspecialchars($data['first_name']) ?> </h2>
                    <p class="lead mb-0">Gestiona tus citas, accede a tu historial clínico y mantente al día con tus tratamientos.</p>
                </div>

                <!-- Cuerpo con opciones del paciente -->
                <div class="card-body p-5 bg-white">
                    <h4 class="fw-bold mb-4" style="color: #333;">¿Qué deseas hacer hoy?</h4>

                    <div class="row g-4">
                        <?php
                        // Opciones adaptadas a un paciente
                        $opciones = [
                            ['titulo' => 'Mis citas', 'icono' => 'bi-calendar-check', 'link' => '#'],
                            ['titulo' => 'Agendar cita', 'icono' => 'bi-calendar-plus', 'link' => '#'],
                            ['titulo' => 'Historial clínico', 'icono' => 'bi-file-medical', 'link' => '#'],
                            ['titulo' => 'Recetas activas', 'icono' => 'bi-prescription', 'link' => '#'],
                            ['titulo' => 'Resultados de laboratorio', 'icono' => 'bi-file-earmark-text', 'link' => '#'],
                            ['titulo' => 'Mensajes', 'icono' => 'bi-envelope', 'link' => '#'],
                            ['titulo' => 'Mi perfil', 'icono' => 'bi-person-gear', 'link' => BASE_URL . '/profile'],
                            ['titulo' => 'Soporte', 'icono' => 'bi-question-circle', 'link' => '#']
                        ];

                        foreach ($opciones as $opcion): ?>
                            <div class="col-md-3 col-sm-6">
                                <a href="<?= $opcion['link'] ?>" class="text-decoration-none">
                                    <div class="card h-100 text-center menu-card shadow-sm border-0 transition-hover"
                                        style="border-radius: 12px; cursor: pointer; transition: transform 0.2s;">
                                        <div class="card-body py-4 d-flex flex-column justify-content-center align-items-center">
                                            <div class="icon-circle mb-3 d-flex justify-content-center align-items-center"
                                                style="width: 60px; height: 60px; border-radius: 50%; background-color: rgba(56, 81, 223, 0.1); color: #3851df;">
                                                <i class="bi <?= htmlspecialchars($opcion['icono']) ?> fs-2"></i>
                                            </div>
                                            <h6 class="fw-bold mb-0" style="color: #333;">
                                                <?= htmlspecialchars($opcion['titulo']) ?>
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Sección de consejos de salud (opcional) -->
                    <div class="mt-5 pt-4 border-top">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info bg-light border-0 shadow-sm" role="alert">
                                    <i class="bi bi-info-circle-fill me-2" style="color: #3851df;"></i>
                                    <strong>Consejo de salud:</strong> Recuerda mantenerte hidratado y realizar actividad física regularmente. Tu bienestar es nuestra prioridad.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilo adicional para efecto hover (puedes moverlo a style.css si prefieres) -->
<style>
    .menu-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .transition-hover {
        transition: transform 0.2s;
    }
</style>