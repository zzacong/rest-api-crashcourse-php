
<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../../config/Database.class.php';
require_once '../../models/Post.class.php';
require_once '../../utils/utils.php';


$database = new Database();
$db = $database->connect();

$post = new Post($db);
$stmt = $post->read();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($result) {
  $posts_arr = [];
  $posts_arr['data'] = [];

  foreach ($result as $row) {
    extract($row);

    $post_item = [
      'id' => $id,
      'title' => $title,
      'body' => html_decode($body),
      'author' => $author,
      'categoryId' => $category_id,
      'categoryName' => $category_name,
    ];

    $posts_arr['data'][] = $post_item;
  }

  echo json_encode($posts_arr);
} else {
  echo json_encode(['message' => 'No posts found.']);
}


?>