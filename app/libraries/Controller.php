<?php
    // load the model and view
    class Controller {
        public function model($model){
            // require model file
            require_once '../app/models/' . $model . '.php';

            // instantiate model
            return new $model();
        }

        // Load the view (checks for file)
        public function view($view , $data = []) {
            if (file_exists('../app/views/' . $view . '.php')) {
                // require view
                require_once '../app/views/' . $view . '.php';
            } else {
                die("View Does not exists.");
            }

        }
    }