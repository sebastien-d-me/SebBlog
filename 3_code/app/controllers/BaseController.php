<?php

// Namespace
namespace App\Controllers;

// Load model
use App\Models\Base;

class BaseController {
    // Load Twig
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }

    // Functions of the controller
    function index() {
        $html = $this->twig->render("base.html.twig");
        return $html;
    }

    function getData() {
        $result = Base::getAll();
        var_dump($result);
    }
    
    function getDataFiltered() {
        $result = Base::getBy("idTest", 1);
        var_dump($result);
    }
    
    function createData() {
        $data = [
            "fullName" => "Sébastien D.", 
            "mail" => "seb@moi.com"
        ];
        Base::create($data);
    }
    
    function updateData() {
        $data = [
            "fullName" => "John DOE", 
            "mail" => "john@doe.com"
        ];
        Base::update(1, $data);
    }
    
    function deleteData() {
        Base::delete(1);
    }
}