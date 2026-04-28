<?php
    // posts 테이블의 특정 게시글 삭제

    // 1. 보안 설정
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
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

    // 4. 리액트에서 보낸 '삭제 id 와 인증 정보(password)' 받기
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->id) && !empty($data->password)){
        $id = $data->id;
        $input_pw = $data->password;

        // 5. 먼저 해당 글의 진짜 비밀번호를 DB에서 조회
        $check_sql = "SELECT password FROM posts WHERE id = $id";
        $result = $conn->query($check_sql);
        $row = $result->fetch_assoc();

        if ($row && $row['password']===$input_pw){
            // [인증 성공] 비밀번호 일치하면 삭제
            $delete_sql = "DELETE FROM posts WHERE id = $id";
            if($conn->query($delete_sql)){
                echo json_encode(["success" => true, "message" => "성공적으로 삭제되었습니다."]);
            }else{
                echo json_encode(["success" => false, "message" => "삭제 중 error"]);
            }
        }else{
            // [인증 실패]
            echo json_encode(["success"=>false, "message" => "비밀번호가 일치하지 않습니다."]);
        }
    }else{
        echo json_encode(["success"=>false, "message"=>"비정상적인 접근입니다."]);
    }

    // 6. 연결 종료
    $conn->close();
?>