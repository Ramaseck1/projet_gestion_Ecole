<?php

namespace ProjetGestionPedagogique\Core;


class Controller {
    protected $validator;

    public function __construct(){
        // var_dump("sidy");
        // die();
        // $this->validator=new Validator1();
        
    }
   
    /**
     * Renders a view file.
     *
     * @param string 
     * @param array 
     */
    public function renderView(string $view, array $data = []) {
        // Extract the data array to variables
        extract($data);

        // Generate the path to the view file
        $viewPath = "../views/$view.html.php";

       
        if (file_exists($viewPath)) {
       
            require $viewPath;
        } else {
           
            echo "View not found: $viewPath";
        }
    }

    /**
     * Redirects to another URL.
     *
     * @param string $url The URL to redirect to.
     */
    public function redirect(string $url) {
        // Send the HTTP header to redirect
        header("Location: $url");
        exit;
    }
}

  




?>