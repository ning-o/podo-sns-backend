<?php
// 데이터베이스/제어 함수 : 특정 댓글 삭제

// 1. 보안 및 통신 설정
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// 2. DB 접속 정보
$servername = "localhost";
$username = "mbca2025yjh";
$password = "q1w2e3r4!";
$dbname = "mbca2025yjh";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "DB 연결 실패"]));
}

// 3. 리액트에서 보낸 '삭제 정보' 받기 (JSON 해독)
$data = json_decode(file_get_contents("php://input"));

$conn->set_charset("utf8mb4"); // 한글 깨짐 방지

// 4. 삭제할 댓글 번호(id)와 비밀번호(password)가 있는지 확인
if (!empty($data->id) && !empty($data->password)) {
    
    $id = (int)$data->id; // 숫자로 강제 형변환
    $input_pw = $conn->real_escape_string($data->password);

    // 5. 번호와 비번이 모두 일치하는 행만 삭제
    $sql = "DELETE FROM comments WHERE id = $id AND password = '$input_pw'";

    if ($conn->query($sql) && $conn->affected_rows > 0) {
        echo json_encode(["success" => true, "message" => "댓글이 삭제되었습니다."]);
    } else {
        // 비번이 틀렸거나 이미 지워진 경우
        echo json_encode(["success" => false, "message" => "비밀번호가 일치하지 않거나 삭제할 대상이 없습니다."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "필수 정보(댓글 번호, 비밀번호)가 누락되었습니다."]);
}

$conn->close();
?>