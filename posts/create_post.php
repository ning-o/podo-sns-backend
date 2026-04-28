<?php
    // posts 테이블에 글 작성

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
        die(json_encode(["success" => false, "message" => "연결 실패: ".$conn->connect_error]));
    }

    // 4. 리액트에서 보낸 '새 글 정보' 받기
    $data = json_decode(file_get_contents("php://input"));

    // 아이디와 비밀번호가 모두 있는지 확인
    if(!empty($data->user_id) && !empty($data->password)){
        // 데이터 정리
        $user_id = $conn->real_escape_string($data->user_id);
        $password = $conn->real_escape_string($data->password);

        // 컨텐츠가 비어있으면 기본값 자동 할당

        $image_url = !empty($data->image_url) ? $conn->real_escape_string($data->image_url) : "";
        $title = !empty($data->title) ? $conn->real_escape_string($data->title) : "제목없음";
        $content = !empty($data->content) ? $conn->real_escape_string($data->content) : "내용없음";

        // DB에 새 글 집어넣기
        $sql= "INSERT INTO posts (user_id, title, content, password, image_url)
               VALUES ('$user_id','$title','$content','$password','$image_url')";

        if($conn->query($sql)){
            echo json_encode(["success"=>true, "message"=>"게시글이 성공적으로 등록되었습니다."]);
        }else{
            echo json_encode(["success"=>false, "message"=>"등록 중 error" . $conn->error]);
        }
    }else{
        echo json_encode(["success"=> false, "message"=> "필수 항목이 누락되었습니다."]);
    }

    $conn->close();

?>