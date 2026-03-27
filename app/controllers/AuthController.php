<?php
require_once 'app/models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login($error = '')
    {
        // Verificar si ya hay sesión activa (usando 'id_usuario' para consistencia)
        if (isset($_SESSION['id_usuario'])) {
            header('location: ' . BASE_URL . '/home');
            exit;
        }

        $data = [
            'title' => 'Iniciar Sesión - FisioUpa',
            'error' => $error
        ];

        // Mostrar mensaje de éxito si existe (por ejemplo tras registro)
        if (isset($_SESSION['register_success'])) {
            $data['success'] = $_SESSION['register_success'];
            unset($_SESSION['register_success']);
        }

        require_once 'app/views/layouts/header.php';
        require_once 'app/views/auth/login.php';
        require_once 'app/views/layouts/footer.php';        
    }

    public function register($error = '')
    {
        if (isset($_SESSION['id_usuario'])) {
            header('location: ' . BASE_URL . '/home');
            exit;
        }

        $data = [
            'title' => 'Registro de usuario - FisioUpa',
            'error' => $error
        ];

        require_once 'app/views/layouts/header.php';
        require_once 'app/views/auth/register.php';
        require_once 'app/views/layouts/footer.php';
    }

    public function process_login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['password']);

            if (empty($email) || empty($password)) {
                return $this->login('Por favor llene los campos.');
            }

            $user = $this->userModel->findByEmail($email);
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    if ($user['estado'] == 1) {
                        $_SESSION['id_usuario'] = $user['id_usuario'];
                        $_SESSION['nombre'] = $user['nombre'];
                        $_SESSION['apellido'] = $user['apellido'];
                        $_SESSION['correo'] = $user['correo'];
                        $_SESSION['foto_perfil'] = $user['foto_perfil'];

                        // DEPURACIÓN: verificar que se llega aquí
                        echo "Login exitoso. Redirigiendo a " . BASE_URL . "/home<br>";
                        header('location: ' . BASE_URL . '/home');
                        exit;
                    } else {
                        echo "Usuario inactivo<br>";
                        return $this->login('El usuario está inactivo.');
                    }
                } else {
                    echo "Contraseña incorrecta<br>";
                    return $this->login('Credenciales Incorrectas.');
                }
            } else {
                echo "Usuario no encontrado<br>";
                return $this->login('Credenciales Incorrectas.');
            }
        } else {
            header('location: ' . BASE_URL . '/login');
        }
    }

    public function process_register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recoger y sanitizar datos
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['password'] ?? '');

            // Validar campos obligatorios
            if (empty($nombre) || empty($apellido) || empty($email) || empty($password)) {
                return $this->register('Todos los campos son obligatorios.');
            }

            // Validar formato de email (opcional, filter_var ya lo hizo)
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->register('El correo electrónico no es válido.');
            }

            // Verificar si el email ya existe
            if ($this->userModel->findByEmail($email)) {
                return $this->register('El correo electrónico ya ha sido registrado.');
            }

            // Validar fortaleza de la contraseña (mínimo 8 caracteres, mayúscula, minúscula, número)
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
                return $this->register('La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas y números.');
            }

            // Hashear contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Preparar datos para el modelo (mapear 'email' a 'correo' y agregar password hasheada)
            $userData = [
                'nombre'   => strtoupper($nombre),
                'apellido' => strtoupper($apellido),
                'correo'   => $email,   // ← clave 'correo', no 'emails'
                'password' => $hashedPassword
            ];

            // Intentar crear el usuario
            if ($this->userModel->createUser($userData)) {
                // Registro exitoso: guardar mensaje en sesión y redirigir al login
                $_SESSION['register_success'] = 'Registro exitoso. Por favor inicie sesión.';
                header('location: ' . BASE_URL . '/login');
                exit;
            } else {
                return $this->register('Error al registrar el usuario. Intente nuevamente.');
            }
        } else {
            header('location: ' . BASE_URL . '/register');
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('location: ' . BASE_URL . '/login'); // Corregido typo "locatio"
        exit;
    }
}