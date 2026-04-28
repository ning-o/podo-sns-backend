<?php
//특정 게시글의 댓글 목록 조회

// 1. 보안 및 통신 설정
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// 2. DB 접속 정보
$servername = "localhost";
$username = "mbca2025yjh";
$password = "q1w2e3r4!";
$dbname = "mbca2025yjh";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "연결 실패"]));
}

// 3. 리액트에서 보낸 게시글 번호(post_id) 받기
$post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

$conn->set_charset("utf8mb4"); // 한글 깨짐 방지

if ($post_id > 0) {
    // 4. 특정 게시글의 댓글만 시간순(ASC)으로 조회
    $sql = "SELECT id, user_id, content, created_at 
            FROM comments 
            WHERE post_id = $post_id 
            ORDER BY created_at ASC";
            
    $result = $conn->query($sql);

    $comments = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
    }
    echo json_encode($comments);
} else {
    echo json_encode(["error" => "올바른 게시글 번호가 필요합니다."]);
}

$conn->close();
?>