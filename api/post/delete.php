
<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-Width');

require_once '../../config/Database.class.php';
require_once '../../models/Post.class.php';


$database = new Database();
$db = $database->connect();

$post = new Post($db);

$data = json_decode(file_get_contents("php://input"));

$post->id = $data->id;

if ($post->delete()) {
  echo json_encode(['message' => 'Post deleted']);
} else {
  echo json_encode(['message' => 'Post delete failed']);
}

?>