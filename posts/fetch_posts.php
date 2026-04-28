<?php
    // 데이터베이스 조회 함수 : posts 테이블의 모든 데이터 추출

    // 1. 보안/접속 설정 : 리액트(포트 5173)에서 이 PHP로 접근할 수 있게 허용
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // 2. DB 접속 정보
    $servername = "localhost";
    $username = "mbca2025yjh";
    $password = "q1w2e3r4!";
    $dbname = "mbca2025yjh";       //DB이름

    // 3. 연결
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if($conn->connect_error){
        die(json_encode(["error" => "연결 실패: ".$conn->connect_error]));
    }

    // 4. SQL 쿼리 전송
    $sql = "SELECT id, title, user_id, content, image_url, likes, created_at FROM posts ORDER BY created_at DESC";
    $result = $conn->query($sql);

    $posts = [];

    // 4. 결과 가공 : 한 줄씩 배열로
    if ($result->num_rows >0){
        while($row = $result->fetch_assoc()){
            $posts[] = $row;
        }
    }

    // 6. 결과 전송 : JSON으로
    echo json_encode($posts, JSON_UNESCAPED_UNICODE);

    // 7. 연결 종료
    $conn->close();
?>