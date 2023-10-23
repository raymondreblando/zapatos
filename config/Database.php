<?php

namespace Config;

use PDO;
use Exception;

class Database
{
  private $conn;

  public function getConnetion(string $host, string $db, string $username, string $password): PDO
  {
    if($this->conn === null){
      try {
        $this->conn = new PDO('mysql:host=' . $host . ';dbname=' . $db, $username, $password, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
      } catch (PDOException $e) {
        throw new Exception('Connection failed '. $e->getMessage());
      }
    }

    return $this->conn;
  }
}