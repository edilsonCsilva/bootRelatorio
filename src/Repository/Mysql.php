<?php

namespace Stilldistribuidora\Repository;
use PDO;
use PDOException;




class Mysql implements IConecao{

    protected $conn;
    private $username="still";
    private $password="still";
    private $database="boot";
    private $host="localhost";



   public function __construnct(){
        $this->conectar();
    }

     function conectar()
    {

        try {
            $host=sprintf("mysql:host=%s;dbname=%s",$this->host,$this->database);
            $this->conn = new PDO($host, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $e) {
              echo 'ERROR: ' . $e->getMessage();
              exit();
          }
        
    }

}



?>