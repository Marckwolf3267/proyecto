<?php

class Router{
    public function __construct()
    {
        $url = $this->getUrl();
        $ruta = empty($url) ? 'login' : strtolower($url[0]);

        switch ($ruta){
            case 'login':
                require_once 'app/controllers/AuthController.php';
                $controlador = new AuthController();
                $controlador->login();
                break;
            case 'register':
                require_once 'app/controllers/AuthController.php';
                $controlador = new AuthController();
                $controlador->register();
                break;
            case 'process_login':
                require_once 'app/controllers/AuthController.php';
                $controlador = new AuthController();
                $controlador->process_login();
                break;
            case 'process_register':
                require_once 'app/controllers/AuthController.php';
                $controlador = new AuthController();
                $controlador->process_register();
                break;
            case 'logout':
                require_once 'app/controllers/AuthController.php';
                $controlador = new AuthController();
                $controlador->logout();
                break;
            case 'home':
                require_once 'app/controllers/HomeController.php';
                $controlador = new HomeController();
                $controlador->index();
                break;
            case 'profile':
                require_once 'app/controllers/ProfileController.php';
                $controlador = new ProfileController();
                // Verificar si hay un segundo segmento (update)
                if (isset($url[1]) && $url[1] == 'update') {
                    $controlador->update();
                } else {
                    $controlador->edit();
                }
                break;
            case 'profile/update':
                require_once 'app/controllers/ProfileController.php';
                $controlador = new ProfileController();
                $controlador->update();
                break;
            default:
                require_once 'app/controllers/AuthController.php';
                $controlador = new AuthController();
                $controlador->login();
                break;
        }
    }
    private function getUrl()
    {
        if (isset($_GET['url'])) {
            // Elimina la barra final para evitar elementos vacíos en el array
            $url = rtrim($_GET['url'], '/');
            // Filtra caracteres no permitidos en una URL
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // Divide la URL en segmentos
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
    
}