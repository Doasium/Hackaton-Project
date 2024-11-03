<?php

namespace App\Core;

use App\Controllers\UserController;
use App\Config\App;
use InvalidArgumentException;
use App\Core\Security;

class Router
{
    private $routes;
    private $maintenanceMode;

    public function __construct()
    {
        $this->routes = [];
        $this->maintenanceMode = false; // Bakım modunu başlat
    }

    public function enableMaintenanceMode()
    {
        $this->maintenanceMode = true;
    }

    public function disableMaintenanceMode()
    {
        $this->maintenanceMode = false;
    }

    public function addRoute($urls, $handler, $jsFile = null, $authRequired = false, $maintenance = true, $method = 'GET')
    {
        if (!is_array($urls)) {
            $urls = [$urls];
        }
        if (!is_callable($handler)) {
            throw new InvalidArgumentException('Handler must be a callable.');
        }
        foreach ($urls as $url) {
            $this->routes[$url] = [
                'handler' => $handler,
                'method' => strtoupper($method),
                'jsFile' => $jsFile,
                'authRequired' => $authRequired,
                'maintenance' => $maintenance,
                'params' => [], // Burada parametreleri tanımlıyoruz
            ];
        }
    }

    public function dispatch($url, $method)
    {
        $template = App::template;
        $userController = new UserController();

        if (isset($this->routes[$url])) {
            $route = $this->routes[$url];

            // HTTP metodunu kontrol et
            if ($route['method'] !== $method) {
                header($_SERVER["SERVER_PROTOCOL"] . " 405 Method Not Allowed");
                echo "405 Method Not Allowed";
                return;
            }

            // Giriş gereksinimini kontrol et
            if ($route['authRequired'] && !$userController->getLogged()) {
                header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
                require_once $_SERVER["DOCUMENT_ROOT"] . '/themes/errors/403.php';
                return;
            }

            // Bakım modunu kontrol et
            if ($this->maintenanceMode && $route['maintenance'] && !$userController->isAdmin()) {
                header($_SERVER["SERVER_PROTOCOL"] . " 503 Service Unavailable");
                require_once $_SERVER["DOCUMENT_ROOT"] . '/themes/errors/maintenance.php';
                return;
            }

            // JavaScript dosyasını kontrol et ve ekle
            $handler = $route['handler'];
            if (is_array($handler)) {
                $controller = $handler[0];
                $method = $handler[1];
                $params = array_slice($route['params'], 0); // Parametreleri al
                call_user_func_array([$controller, $method], $params);
            } else {
                call_user_func($handler);
            }
            $jsFile = $route['jsFile'];
            if ($jsFile) {
                $jsFilePath = $_SERVER["DOCUMENT_ROOT"] . '/public/themes/' . $template . '/' . $jsFile . ".js";
                if (file_exists($jsFilePath)) {
                    echo '<script src="/public/themes/' . $template . '/' . $jsFile . '.js"></script>';
                } else {
                    error_log('JS file not found: ' . $jsFilePath); // Hata kaydı
                }
            }
        } else {
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
            echo "404 Not Found";
        }
    }

    public function handleRequest($requestUrl, $method)
    {
        global $template;

        // CSRF token generation (only generate if not exists)
        if (!isset($_SESSION["csrf_token"])) {
            $_SESSION["csrf_token"] = Security::generateCsrfToken();
        }

        $matchedRoute = null;
        $params = [];

        foreach ($this->routes as $route => $routeData) {
            $pattern = str_replace('/', '\/', $route);
            $pattern = preg_replace('/\{(\w+)\}/', '([^\/]+)', $pattern);
            $pattern = '/^' . $pattern . '\/?$/' ;

            if (preg_match($pattern, $requestUrl, $matches) && $routeData['method'] === $method) {
                $matchedRoute = $route;
                $params = array_slice($matches, 1); // İlk elemanı atla, geri kalanları parametre olarak al
                $this->routes[$route]['params'] = $params; // Daha sonra kullanılmak üzere parametreleri sakla
                break;
            }
        }

        if ($matchedRoute !== null) {
            // CSRF doğrulaması
            if (in_array($method, ['POST', 'PUT', 'DELETE'])) {
                $csrfToken = $_POST['csrf_token'] ?? '';
                if (!Security::validateCsrfToken($csrfToken)) {
                    http_response_code(403);
                    echo 'Invalid CSRF token';
                    return;
                }
            }

            $this->dispatch($matchedRoute, $method);
        } else {
            http_response_code(404);
            require_once $_SERVER["DOCUMENT_ROOT"] . '/public/errors/404.php';
        }

        // CSRF token'ı temizle
        // unset($_SESSION['csrf_token']);
    }
}
