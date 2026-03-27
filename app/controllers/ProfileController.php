<?php
require_once 'app/models/User.php';

class ProfileController
{
    private $userModel;

    public function __construct()
    {
        // Verificar sesión con la variable correcta (id_usuario)
        if (!isset($_SESSION['id_usuario'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $this->userModel = new User();
    }

    /**
     * Mostrar formulario de edición de perfil
     */
    public function edit()
    {
        $user = $this->userModel->getById($_SESSION['id_usuario']);

        $data = [
            'title' => 'Mi perfil - Fisioupa',
            'user'  => $user,
            'flash' => $_SESSION['flash'] ?? null
        ];

        unset($_SESSION['flash']);

        require_once 'app/views/layouts/header.php';
        require_once 'app/views/profile/edit.php';
        require_once 'app/views/layouts/footer.php';
    }

    /**
     * Procesar actualización de perfil
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/profile');
            exit;
        }

        $id = $_SESSION['id_usuario'];
        $user = $this->userModel->getById($id);

        // Datos del formulario
        $nombre   = trim($_POST['first_name'] ?? '');    // el formulario usa first_name
        $apellido = trim($_POST['last_name'] ?? '');     // el formulario usa last_name
        $currentPassword = trim($_POST['current_password'] ?? '');
        $newPassword = trim($_POST['password'] ?? '');
        $confirm   = trim($_POST['password_confirm'] ?? '');

        // Validaciones básicas
        if (empty($nombre) || empty($apellido)) {
            return $this->flashBack('danger', 'Nombre y apellidos son obligatorios.');
        }

        // Procesar cambio de contraseña si se proporcionó la actual
        $passwordHash = null;
        if (!empty($currentPassword)) {
            if (empty($newPassword)) {
                return $this->flashBack('danger', 'Debes ingresar una nueva contraseña para cambiarla.');
            }

            // Verificar contraseña actual
            if (!password_verify($currentPassword, $user['password'])) {
                return $this->flashBack('danger', 'La contraseña actual no es correcta.');
            }

            // Confirmación
            if ($newPassword !== $confirm) {
                return $this->flashBack('danger', 'Las contraseñas nuevas no coinciden.');
            }

            // Validar fortaleza (8 caracteres, mayúscula, minúscula, número)
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $newPassword)) {
                return $this->flashBack('danger', 'La contraseña debe tener mínimo 8 caracteres, incluir una mayúscula, una minúscula y un número.');
            }

            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // Procesar foto de perfil (si se subió)
        $photoPath = $this->handlePhotoUpload();

        // Actualizar en la base de datos
        $updated = $this->userModel->updateProfile($id, [
            'nombre'      => strtoupper($nombre),
            'apellido'    => strtoupper($apellido),
            'password'    => $passwordHash,  // o null si no se cambia
            'foto_perfil' => $photoPath      // o null si no se sube
        ]);

        if ($updated) {
            // Actualizar variables de sesión para reflejar los cambios
            $_SESSION['nombre']      = strtoupper($nombre);
            $_SESSION['apellido']    = strtoupper($apellido);
            if ($photoPath) {
                $_SESSION['foto_perfil'] = $photoPath;
            }

            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Perfil actualizado correctamente.'];
            header('Location: ' . BASE_URL . '/profile');
            exit;
        } else {
            $this->flashBack('danger', 'No se pudieron guardar los cambios.');
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/profile');
            exit;
        }

        $id = $_SESSION['id_usuario'];
        echo "ID de usuario: " . $id . "<br>";
        var_dump($_POST);
        var_dump($_FILES);
    
    }

    /**
     * Maneja la subida de la foto de perfil
     * @return string|null Ruta pública de la imagen o null si no se subió
     */
    private function handlePhotoUpload()
    {
        if (empty($_FILES['profile_photo']['name'])) {
            return null;
        }

        $file = $_FILES['profile_photo'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->flashBack('danger', 'Error al subir la imagen.');
        }

        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowed)) {
            $this->flashBack('danger', 'Formato de imagen no permitido. Usa JPG, PNG o WEBP.');
        }

        $uploadDir = 'public/uploads/profile_photos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'user_' . $_SESSION['id_usuario'] . '_' . time() . '.' . strtolower($extension);
        $destination = $uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            $this->flashBack('danger', 'No se pudo guardar la foto. Intenta de nuevo.');
        }

        // Retornar la ruta pública (para guardar en BD y mostrar)
        return BASE_URL . '/' . $destination;
    }

    /**
     * Redirige al perfil con un mensaje flash
     */
    private function flashBack($type, $message)
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
        header('Location: ' . BASE_URL . '/profile');
        exit;
    }
}