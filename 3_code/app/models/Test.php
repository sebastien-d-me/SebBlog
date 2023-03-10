<?php

/*class Test {
    private $id;
    private $name;
      
    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    // Getter
    public function getId() {
        return $this->id;
    }
      
    public function getName() {
        return $this->name;
    }
      
    // Setter
    public function setName($name) {
        $this->name = $name;
    }
}*/

class Test {
    function getTests() {
        $databasePDO = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASSWORD);
        $statement = $databasePDO->prepare("SELECT idTest, name FROM test");
        $statement->execute();

        $tests = [];
        while (($row = $statement->fetch())) {
            $testArray = [
                "name" => $row["name"],
            ];

            $tests[] = $testArray;
        }

        return $tests;
    }
}
?>