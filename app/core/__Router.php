<?php

    if ( !function_exists('assets') ) {
        function assets() {
            return __Base_Url() . 'src/assets/';
        }
    }

    if ( !function_exists('redirect') ) {
        function redirect( $url, $errorCode = null, $message = null) {
            header("Location: " . $url);
            exit();
        }
    }

    if ( !function_exists('url') ) {
        function url($path) {
            return rtrim(__Path(), '/') . '/' . ltrim($path, '/');
        }
    }

    if ( !function_exists('view') ) {
        function view($view, $data = []) {
            $path = dirname(__DIR__, 2) . '/public/' . $view . '.php';
            if (file_exists($path)) {
                extract($data);
                require_once $path;
            } else {
                require_once dirname(__DIR__, 2) . '__error.php';
            }
        }
    }
    
    
    class Router {
        private $routes = [
            'GET' => [],
            'POST' => []
        ];

        public function get($uri, $action) {
            $this->addRoute('GET', $uri, $action);
        }

        public function post($uri, $action) {
            $this->addRoute('POST', $uri, $action);
        }

        private function addRoute($method, $uri, $action) {
            // $pattern = preg_replace('#\{([\w]+)\}#', '(?P<\1>[^/]+)', $uri);
            // $pattern = '#^' . rtrim($pattern, '/') . '$#';
            $pattern = preg_replace('#\{([^}]+)\}#', '([^/]+)', $uri);
            $pattern = '#^' . $pattern . '$#';
            $this->routes[$method][$pattern] = $action;
        }

        public function dispatch() {
            $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $requestMethod = $_SERVER['REQUEST_METHOD'];

            // Hapus base path jika ada
            $requestUri = str_replace(__Path(), '', $requestUri);

            foreach ($this->routes[$requestMethod] as $pattern => $action) {
                if (preg_match($pattern, $requestUri, $matches)) {

                    array_shift($matches); 
                    list($controllerName, $method) = $action;

                    if (!$this->loadController($controllerName)) {
                        return $this->error("Controller '$controllerName' tidak ditemukan.");
                    } 

                    $controller = new $controllerName(); 
                    if (!method_exists($controller, $method)) {
                        return $this->error("Method '$method' tidak ditemukan.");
                    }

                    // Bersihkan parameter hanya yang bernama (named parameters)
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                    if ($requestMethod === 'POST') {
                        $result = $controller->$method($_POST);
                        // redirect($result['Data']['Url'], $result['Error'] === '000' ? '01' : '03', $result['Message']);
                    } elseif ($requestMethod === 'GET') {
                        // Jika GET, bisa menangani baik pengambilan data atau pengiriman data
                        if (!empty($_POST)) {
                            // Jika ada data POST, berarti ini pengiriman data melalui GET
                            $result = $controller->$method(...array_values($_POST));
                            // redirect($result['Data']['Url'], $result['Error'] === '000' ? '01' : '03', $result['Message']);
                        } else {
                            // Jika tidak ada data POST, cukup tampilkan halaman
                            if ( isset($matches) && $matches == TRUE ) {
                                $result = $controller->$method(...array_values($matches));
                            } else {
                                $result = $controller->$method();
                            }
                        }
                    }

                    return;
                }
            }

            return $this->notFound();
        }

        private function loadController($controllerName) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if ( (isset($_SESSION['__Administrator__']) && isset($_SESSION['__User__'])) ) {
                session_unset();
                session_destroy();
            }
            $directories = [];
            if (isset($_SESSION['__Administrator__'])) {
                $directories[] = '/app/controllers/administrator/';
            } elseif (isset($_SESSION['__User__'])) {
                $directories[] = '/app/controllers/user/';
            }
            $directories[] = '/app/controllers/';
            foreach ($directories as $directory) {
                $filePath = dirname(__DIR__,2) . $directory . $controllerName . '.php';
                if (file_exists($filePath)) {
                    require_once $filePath;
                    return true;
                }
            }
            return false;
        }

        private function error($msg) {
            echo "<h1>500 Internal Error</h1><p>$msg</p>";
            exit;
        }

        private function notFound() {
            echo "<h1>404 Not Found</h1><p>Halaman tidak ditemukan.</p>";
            exit;
        }
    }