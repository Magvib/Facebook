<?php

class Controller
{
    public $response = null;
    public $auth = false;

    public function __construct()
    {
        $this->response = new Response();

        // Check if user is logged in
        if ($this->auth && !Auth::check()) {
            $this->redirect('/login');
        }
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
                try {
                    $class = new $class();
                    $class->$method($params);
                    die();
                } catch (Exception $e) {
                    self::errorPage($e->getMessage());
                }
            }
        }

        self::errorPage('Page not found');
    }

    public static function errorPage($message = '')
    {
?>
        <div id="main">
            <div class="fof">
                <h1>Error 404</h1>
                <h3><?= $message ?></h3>
            </div>
        </div>
        <style>
            * {
                transition: all 0.6s;
            }

            html {
                height: 100%;
            }

            body {
                font-family: 'Lato', sans-serif;
                color: #888;
                margin: 0;
            }

            #main {
                display: table;
                width: 100%;
                height: 100vh;
                text-align: center;
            }

            .fof {
                display: table-cell;
                vertical-align: middle;
            }

            .fof h1 {
                font-size: 50px;
                display: inline-block;
                padding-right: 12px;
                animation: type .5s alternate infinite;
            }

            @keyframes type {
                from {
                    box-shadow: inset -3px 0px 0px #888;
                }

                to {
                    box-shadow: inset -3px 0px 0px transparent;
                }
            }
        </style>
<?php
        die();
    }
}
