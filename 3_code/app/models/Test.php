<?php

// Namespace
namespace App\Models;

class Test {
    private $idTest;
    private $name;

    // Getter
    public function getIdTest() {
        return $this->idTest;
    }
      
    public function getName() {
        return $this->name;
    }
      
    // Setter
    public function setName($name) {
        $this->name = $name;
    }

    // CRUD
    public function update($id, $name) {
        $SQL = DB_CONNECTION->prepare("UPDATE test SET name = :name WHERE idTest = :id");
        $SQL->bindParam(":name", $name);
        $SQL->bindParam(":id", $id);
        $SQL->execute();
    }
}
?>