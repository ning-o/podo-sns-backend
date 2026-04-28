<?php
/* 게시글 상세 정보 가져오기 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username = "mbca2025yjh";
$password = "q1w2e3r4!";
$dbname = "mbca2025yjh";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if($conn->connect_error){
    die(json_encode(["success" => false, "message" => "연결 실패"]));
}

// 주소창의 ?id=값 읽어오기
$id = isset($_GET['id']) ? $conn->real_escape_string($_GET['id']) : '';

if(!empty($id)){
    $sql = "SELECT * FROM posts WHERE id = '$id'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        echo json_encode($row); // 해당 글 정보만 객체로 반환
    } else {
        echo json_encode(["success" => false, "message" => "글을 찾을 수 없습니다."]);
    }
}
$conn->close();
?>