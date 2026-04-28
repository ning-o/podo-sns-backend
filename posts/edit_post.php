<?php
/* * 게시글 수정*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// [서버 오류 방지] OPTIONS 요청 시 즉시 종료
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

// 2. DB 접속 정보
$servername = "localhost";
$username = "mbca2025yjh";
$password = "q1w2e3r4!";
$dbname = "mbca2025yjh";       //DB이름

// 3. 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// [서버 오류 방지] 한글 깨짐 방지 설정 추가
$conn->set_charset("utf8mb4");

// 연결 확인
if($conn->connect_error){
    die(json_encode(["success" => false, "message" => "연결 실패: ".$conn->connect_error]));
}

// 4. 리액트에서 보낸 '새 글 정보' 받기
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->password)){
    $id = $conn->real_escape_string($data->id);
    $password = $conn->real_escape_string($data->password);
    $title = $conn->real_escape_string($data->title);
    $content = $conn->real_escape_string($data->content);

    // [전술 핵심] 먼저 비밀번호가 맞는지부터 확인합니다. [cite: 2026-01-27]
    $checkSql = "SELECT id FROM posts WHERE id='$id' AND password='$password'";
    $result = $conn->query($checkSql);

    if($result->num_rows > 0) {
        // 비밀번호가 일치하면 수정
        $updateSql = "UPDATE posts SET title='$title', content='$content' 
                      WHERE id='$id' AND password='$password'";
        
        if($conn->query($updateSql)){
            echo json_encode(["success" => true, "message" => "수정 완료!"]);
        } else {
            // 서버 자체 오류 발생 시
            echo json_encode(["success" => false, "message" => "서버 쿼리 오류: " . $conn->error]);
        }
    } else {
        // 비밀번호가 틀린 경우
        echo json_encode(["success" => false, "message" => "비밀번호가 일치하지 않습니다."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "비밀번호를 입력해야 수정이 가능합니다."]);
}

$conn->close();
?>