<?php

class Controller
{
    public $response = null;

    public function __construct()
    {
        $this->response = new Response();
    }
    
    public function render(string $view, array $params = [], $useLayout = true)
    {
        // Check if view exists
        if (!file_exists("views/$view.php")) {
            return;
        }

        // Extract params
        extract($params);

        if ($useLayout) {
            // Render layout
            require_once "views/nav.php";
        }

        // Get the view
        require "views/$view.php";

        die();
    }

    public function redirect(string $url)
    {
        header("Location: $url");
        die();
    }

    public function json($data)
    {
        // Set header
        header('Content-Type: application/json');
        
        echo json_encode($data);
        die();
    }

    public static function match($match)
    {
        // if matched then call the class and method
        if ($match) {
            $target = explode('#', $match['target']);
            $class = $target[0];
            $method = $target[1];
            $params = $match['params'];

            // Merge params with $_GET
            $params = array_merge($params, $_GET);

            // Merge params with $_POST
            $params = array_merge($params, $_POST);

            // Check if class and function exists
            if (class_exists($class) && method_exists($class, $method)) {
                // Call the class and method
                $class = new $class();
                $class->$method($params);
                die();
            }
        }

        echo '404';
        die();
    }
}