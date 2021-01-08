
<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../../config/Database.class.php';
require_once '../../models/Post.class.php';


$database = new Database();
$db = $database->connect();

$post = new Post($db);
$post->id = isset($_GET['id']) ? $_GET['id'] : exit();
$post->read_single();
$post_arr = [
  'id' => $post->id,
  'title' => $post->title,
  'body' => $post->body,
  'author' => $post->author,
  'categoryId' => $post->category_id,
  'categoryName' => $post->category_name,
];

echo json_encode(['data' => $post_arr]);

?>