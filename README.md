# Podo SNS (백엔드 API)
React 프론트엔드와 연동하기 위해 구축한 PHP 기반의 백엔드 시스템입니다.

## Live API Base URL
Production: https://mbca2025yjh.dothome.co.kr/podo_api
위 링크 접속으로는 403 에러가 뜨는게 정상이며, 아래 상세 엔드포인트를 통해 접근 가능합니다.
ex) 게시글 전체 조회 엔드포인트
https://mbca2025yjh.dothome.co.kr/podo_api/posts/fetch_posts.php

## 주요 기능 및 경험
- **API 서버 구축:** Apache 환경에서 구동되며, 프론트엔드의 요청에 맞춰 JSON 형태로 데이터를 응답하는 REST API를 설계했습니다.
- **데이터베이스 연동:** MySQL을 활용해 사용자의 게시글과 댓글 데이터를 관리합니다.
- **데이터 무결성 관리:** 게시글이 삭제될 때 해당 글에 달린 댓글들도 함께 삭제되도록 DB 구조를 설계하여 더미 데이터가 남지 않도록 처리했습니다.

## 기술 스택
- **백엔드:** PHP
- **데이터베이스:** MySQL
- **개발 환경(로컬):** Apache (XAMPP)
- **운영 환경(배포):** Dothome Hosting
- **배포 도구:** FileZilla

## 연결된 프론트엔드
- GitHub: https://github.com/ning-o/podo-sns-web
- Live Demo: https://mbca2025yjh.dothome.co.kr/podo_sns
