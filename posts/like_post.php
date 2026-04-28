<?php
// 게시글 좋아요 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$servername = "localhost";
$username = "mbca2025yjh";
$password = "q1w2e3r4!";
$dbname = "mbca2025yjh";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die(json_encode(["success" => false])); }

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $id = (int)$data->id;
    // 기존 likes 값에 +1을 더함
    $sql = "UPDATE posts SET likes = likes + 1 WHERE id = $id";

    if ($conn->query($sql)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}
$conn->close();
?>