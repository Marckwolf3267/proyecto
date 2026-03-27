<?php
class HomeController
{
    public function __construct()
    {
        if (!isset($_SESSION['id_usuario'])) {
            header('location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Inicio - FisioUpa',
            'first_name' => $_SESSION['nombre'] ?? '',          // ← nombre real
            'last_name' => $_SESSION['apellido'] ?? '',        // ← apellido real
            'profile_photo' => $_SESSION['foto_perfil'] ?? null // ← foto real
        ];

        require_once 'app/views/layouts/header.php';
        require_once 'app/views/home/home.php';
        require_once 'app/views/layouts/footer.php';
    }
}