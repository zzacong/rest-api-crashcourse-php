
<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-Width');

require_once '../../config/Database.class.php';
require_once '../../models/Post.class.php';


$database = new Database();
$db = $database->connect();

$post = new Post($db);

$data = json_decode(file_get_contents("php://input"));

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->categoryId;

if ($post->create()) {
  echo json_encode(['message' => 'Post created']);
} else {
  echo json_encode(['message' => 'Post create failed']);
}

?>