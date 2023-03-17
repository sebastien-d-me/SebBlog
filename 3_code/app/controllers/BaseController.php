<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\DefaultController;
use App\Models\Base;

class BaseController extends DefaultController {
    // Functions of the controller
    function index() {
        $html = $this->twig->render("base.html.twig");
        return $html;
    }

    function getData() {
        $result = Base::all();
        var_dump($result);
    }
    
    function getDataFiltered($id) {
        $result = Base::all()->where("idTest", $id);
        var_dump($result);
    }
    
    function createData() {
        $base = new Base();
        $base->setUsername("sebastien.dlh");
        $base->setMail("seb@dlh.com");
        $base->setPassword("Dévelopeur1");
        $base->save();
    }
    
    function updateData($id) {
        $base = Base::find($id);
        $base->setUsername("john.doe");
        $base->setMail("john@doe.com");
        $base->setPassword("Testeur2/");
        $base->save();
    }
    
    function deleteData($id) {
        $base = Base::find($id);
        $base->delete();
    }

    ////////////////////// 
    function login() {
        $login = "john@doe.com";
        $password = "Testeur2/";

        $checkLogin = Base::where("username", $login)->orWhere("mail", $login)->first();

        if(!empty($checkLogin)) {
            echo "LOGIN Correct / ";
            $checkPassword = password_verify($password, $checkLogin->getPassword());
            if($checkPassword === true) {
                echo "MDP Correct";
            } else {
                echo "MDP Incorrect";
            }
        } else {
            echo "LOGIN Incorrect";
        }
    }
}