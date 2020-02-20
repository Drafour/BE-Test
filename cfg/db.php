<?php
  class Database {

    private $host     = '18.140.67.82';
    private $port     = 8976;
    private $db_name  = 'kriya_test';
    private $user     = 'test';
    private $password = 'kriyatest123';

    public $conn;

    public function getConnection(){
      $this->conn = null;

      try {
        $this->conn = new PDO('pgsql:host='.$this->host.';port='.$this->port.';dbname='.$this->db_name.';user='.$this->user.';password='.$this->password);
      }
      catch (PDOException $exception) {
        echo 'Connection error on cms: '.$exception->getMessage();
      }

      return $this->conn;
    }

  }  //end of class
?>
