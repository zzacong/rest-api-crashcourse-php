
<?php

require_once __DIR__ . '/../utils/utils.php';

class Post {
  private $conn;
  private $table = 'post';

  public $id;
  public $category_id;
  public $category_name;
  public $title;
  public $body;
  public $author;
  public $created_at;

  public function __construct($db) {
    $this->conn = $db;
  }

  public function read() {
    $query = "
      SELECT
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
      FROM
        $this->table p
      LEFT JOIN
        category c
        ON p.category_id = c.id
      ORDER BY
        p.created_at DESC
    ";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    // print_r($stmt->errorInfo());
    return $stmt;
  }

  public function read_single() {
    $query = "
      SELECT
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
      FROM
        $this->table p
      LEFT JOIN
        category c
        ON p.category_id = c.id
      WHERE
        p.id = :id
    ";

    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(':id', $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->title = $row['title'];
    $this->body = $row['body'];
    $this->author = $row['author'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];
  }

  public function create() {
    $query = "
      INSERT INTO $this->table
        (title, body, author, category_id)
      VALUES
        (:title, :body, :author, :category_id)
    ";

    $stmt = $this->conn->prepare($query);

    $this->title = html(strip_tags($this->title));
    $this->body = html(strip_tags($this->body));
    $this->author = html(strip_tags($this->author));
    $this->category_id = html(strip_tags($this->category_id));

    $stmt->bindvalue(':title', $this->title);
    $stmt->bindvalue(':body', $this->body);
    $stmt->bindvalue(':author', $this->author);
    $stmt->bindvalue(':category_id', $this->category_id);

    $stmt->execute();
    if ($stmt->rowCount()) {
      return true;
    }
    printf("Error: %s.\n", $stmt->error);
  }

  public function update() {
    $query = "
      UPDATE $this->table
      SET
        title = :title,
        body = :body,
        author = :author,
        category_id = :category_id
      WHERE
        id = :id
    ";

    $stmt = $this->conn->prepare($query);

    $this->title = html(strip_tags($this->title));
    $this->body = html(strip_tags($this->body));
    $this->author = html(strip_tags($this->author));
    $this->category_id = html(strip_tags($this->category_id));
    $this->id = html(strip_tags($this->id));

    $stmt->bindvalue(':title', $this->title);
    $stmt->bindvalue(':body', $this->body);
    $stmt->bindvalue(':author', $this->author);
    $stmt->bindvalue(':category_id', $this->category_id);
    $stmt->bindvalue(':id', $this->id);

    if ($stmt->execute()) {
      return true;
    }
    printf("Error: %s.\n", $stmt->error);
  }

  public function delete() {
    $query = "
      DELETE FROM $this->table
      WHERE id = :id
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->bindvalue(':id', $this->id);
    if ($stmt->execute()) {
      return true;
    }
    printf("Error: %s.\n", $stmt->error);
    return false;
  }
}

?>