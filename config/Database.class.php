
<?php

class Database {

  private const DB_USER = 'admin';
  private const DB_PASSWD = 'password';
  private $conn;


  public function connect() {
    $this->conn = null;
    try {
      $this->conn = new PDO(
        "mysql:dbname=myblog_rest_api;host=localhost;charset=utf8mb4",
        self::DB_USER,
        self::DB_PASSWD
      );
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo 'Connection Error: ' . $e->getMessage();
    }
    return $this->conn;
  }
}

?>