<?php
// 특정 게시글에 대한 댓글 등록

// 1. 보안 및 통신 설정
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

// 2. DB 접속 정보
$servername = "localhost";
$username = "mbca2025yjh";
$password = "q1w2e3r4!";
$dbname = "mbca2025yjh";

$conn = new mysqli($servername, $username, $password, $dbname);

$conn->set_charset("utf8mb4"); // 한글 깨짐 방지

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "DB 연결 실패"]));
}

// 3. 리액트에서 보낸 '댓글 정보' 수령
$data = json_decode(file_get_contents("php://input"));

// 4. 어느 글인지(post_id), 누구인지(user_id), 비번(password), 글 내용(content) 이 있는지 확인
if (!empty($data->post_id) && !empty($data->user_id) && !empty($data->password) && !empty($data->content)) {
    
    // 데이터 처리 (Escape)
    $post_id = (int)$data->post_id; // 숫자로 강제 형변환
    $user_id = $conn->real_escape_string($data->user_id);
    $password = $conn->real_escape_string($data->password);
    $content = $conn->real_escape_string($data->content);

    // 5. DB에 댓글 삽입
    $sql = "INSERT INTO comments (post_id, user_id, content, password) 
            VALUES ($post_id, '$user_id', '$content', '$password')";

    if ($conn->query($sql)) {
        echo json_encode(["success" => true, "message" => "댓글이 등록되었습니다."]);
    } else {
        echo json_encode(["success" => false, "message" => "등록 실패: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "필수 정보(게시글 번호, 아이디, 비밀번호, 내용)가 누락되었습니다."]);
}

$conn->close();
?>