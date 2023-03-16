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
        $base->setFullName("Sébastien D.");
        $base->setMail("seb@moi.com");
        $base->save();
    }
    
    function updateData($id) {
        $base = Base::find($id);
        $base->setFullName("John DOE");
        $base->setMail("test@test.com");
        $base->save();
    }
    
    function deleteData($id) {
        $base = Base::find($id);
        $base->delete();
    }
}