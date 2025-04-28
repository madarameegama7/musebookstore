<?php
class Controller
{
    public function model($model)
    {
        // Check if this is a model in a subdirectory
        if (strpos($model, '/') !== false) {
            // Split the path into directory and model name
            $parts = explode('/', $model);
            $modelDirectory = $parts[0];
            $modelName = $parts[1];

            // Require the model file
            require_once '../app/models/' . $model . '.php';

            // Instantiate the model using only the class name part
            return new $modelName();
        } else {
            // Handle standard models (not in subdirectories)
            require_once '../app/models/' . $model . '.php';
            return new $model();
        }
    }

    public function view($view, $data = [])
    {
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die('Corresponding view does not exist!');
        }
    }
}
