<?php
    /*
    * App Core Class
    * Creates URL & loads core controller
    * URL FORMAT - /controller/method/params
    */
    class Core
    {
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct(){
            $url = $this->getUrl();

            // Look in 'controllers' for first values, ucwords will capitalize first letter
            if(file_exists('../app/controllers/' . ucwords($url[0]) .'.php')){
                // we will set a new controller
                $this->currentController = ucwords($url[0]);
                unset($url[0]);
            }

            // require the controller
            require_once '../app/controllers/' . $this->currentController . '.php';

            // Instantiate controller class
            $this->currentController = new $this->currentController;

            // check for the second part of url
            if (isset($url[1])){
                if (method_exists($this->currentController, $url[1])){
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }

            // Get parameters
            $this->params = $url ? array_values($url) : [];

            // Call a callback with array of params

            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

        }


        public function getUrl() {
            if(isset($_GET['url'])) {
                $url = rtrim($_GET['url'], '/');

                // allow you to filter variables as string/number
                $url = filter_var($url, FILTER_SANITIZE_URL);

                // Breaking it into an array
                $url = explode('/', $url);

                return $url;
            }
        }
    }