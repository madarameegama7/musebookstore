<?php
class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $param = [];

    public function __construct()
    {
        $url = $this->getURL();

        // First, check if this is potentially a controller in a subdirectory
        if (
            isset($url[0]) && isset($url[1]) &&
            file_exists('../app/controllers/' . $url[0] . '/' . ucwords($url[1]) . '.php')
        ) {

            // Handle controller in subdirectory (e.g., admin_controllers/Reports)
            $controllerPath = $url[0] . '/' . ucwords($url[1]);
            $controllerName = ucwords($url[1]);
            require_once '../app/controllers/' . $controllerPath . '.php';

            // Create controller instance
            $this->currentController = new $controllerName;

            // Set method to third URL segment or default to index
            $this->currentMethod = isset($url[2]) && method_exists($this->currentController, $url[2])
                ? $url[2] : 'index';

            // Remove controller and method from URL array
            unset($url[0]);
            unset($url[1]);
            if (isset($url[2])) {
                unset($url[2]);
            }
        }
        // If not a subdirectory controller, check standard controllers
        else if (isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]);
            unset($url[0]);

            require_once '../app/controllers/' . $this->currentController . '.php';
            $this->currentController = new $this->currentController;

            if (isset($url[1]) && method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        } else {
            // Default controller if no match
            require_once '../app/controllers/' . $this->currentController . '.php';
            $this->currentController = new $this->currentController;
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
