<?php
class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $param = [];

    public function __construct()
    {
        $url = $this->getURL();

        // Special handling for admin controllers
        if (isset($url[0]) && $url[0] == 'admin') {
            if (isset($url[1])) {
                // Check if it's a specialized admin controller first
                $adminControllerClass = ucwords($url[1]) . 'AdminController';
                $adminControllerFile = '../app/controllers/admin/' . $adminControllerClass . '.php';

                if (file_exists($adminControllerFile)) {
                    // Load the specialized admin controller
                    require_once $adminControllerFile;
                    $this->currentController = new $adminControllerClass();

                    // If there's a method specified, use it, otherwise default to index
                    if (isset($url[2]) && method_exists($this->currentController, $url[2])) {
                        $this->currentMethod = $url[2];
                        unset($url[2]);
                    } else {
                        $this->currentMethod = 'index';
                    }

                    // Remove controller parts from URL array
                    unset($url[0]);
                    unset($url[1]);
                }
                // Then check if the method exists in the main Admin controller (fallback for backward compatibility)
                else if (file_exists('../app/controllers/Admin.php')) {
                    require_once '../app/controllers/Admin.php';
                    $adminInstance = new Admin();

                    if (method_exists($adminInstance, $url[1])) {
                        // It's a method of the main Admin controller
                        $this->currentController = $adminInstance;
                        $this->currentMethod = $url[1];

                        // Remove controller and method from URL array
                        unset($url[0]);
                        unset($url[1]);
                    } else {
                        // No specialized controller found and method doesn't exist in Admin, 
                        // use main Admin with default index
                        $this->currentController = $adminInstance;
                        $this->currentMethod = 'index';

                        // Remove controller part from URL array
                        unset($url[0]);
                    }
                } else {
                    // Admin.php doesn't exist (unusual case), fallback to default
                    require_once '../app/controllers/' . $this->currentController . '.php';
                    $this->currentController = new $this->currentController();
                }
            } else {
                // Just 'admin' without second segment, load Admin controller with index method
                require_once '../app/controllers/Admin.php';
                $this->currentController = new Admin();
                $this->currentMethod = 'index';

                unset($url[0]);
            }
        }
        // Standard controllers handling (not admin)
        else if (isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]);
            unset($url[0]);

            require_once '../app/controllers/' . $this->currentController . '.php';
            $this->currentController = new $this->currentController();

            if (isset($url[1]) && method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        } else {
            // Default controller if no match
            require_once '../app/controllers/' . $this->currentController . '.php';
            $this->currentController = new $this->currentController();
        }

        // Remaining URL parameters
        $this->param = $url ? array_values($url) : [];

        // Call controller method with parameters
        call_user_func_array([$this->currentController, $this->currentMethod], $this->param);
    }

    public function getURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
