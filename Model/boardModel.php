<?php
require_once('../boardConf/boardConf.php');
require_once('connectDB.php');
require_once('../boardLibrary/library.php');

class boardModel{

    // 로그인 눌렀을 때 디비에서 아이디 비밀번호 비교 후 세션 저장
    // $isLogin : $_REQUEST['login']
    // $argId : $_REQUEST['id']
    // $argPassword : $_REQUEST['password']
    static function login($isLogin, $argId, $argPassword){
        if(isset($isLogin) && $isLogin){
            $sql = "SELECT * FROM user_info WHERE userid = '{$argId}' && password = '{$argPassword}'";
            $db_conn = DB_Connect();
            $result = $db_conn->query($sql);
            $record = $result->fetch_assoc();
            if($record['seqid'] != null){
                $_SESSION['id']       = $record['userid'];
                $_SESSION['password'] = $record['password'];
                $_SESSION['name']     = $record['name'];
                $_SESSION['login']    = $_REQUEST['login'];
            }
            else {
                echo "<script> alert('아이디와 비밀번호를 정확히 입력 해 주세요.'); </script>";
            }
        }
    }


    // 총 게시글 갯수
    // $plusSql : 검색 값
    static function NumOfBoard($plusSql){
        // 게시글 수
        $num = 0;

        // 디비 사용
        $conn = DB_Connect();

        // 총 게시글 갯수
        $sql = "SELECT board_id FROM mybulletin WHERE board_pid = 0 $plusSql";
        $data = $conn->query($sql);
        while ($data->fetch_assoc()) {
            $num++;
        }
        return $num;
    }


    // 게시글 테이블 출력
    // $plusSql : 검색 값
    // $messageNum : 첫 게시글 시작 지점
    static function boardTable($plusSql, $messageNum){
        // 디비 사용
        $conn = DB_Connect();

        // sql문 ( 테이블 출력 용 )
        $sql = "SELECT board_id, title, user_name, hits, DATE_FORMAT(reg_date,'%Y-%m-%d') 'reg_date'
            FROM mybulletin WHERE board_pid = 0 $plusSql 
            ORDER BY board_id DESC LIMIT $messageNum, " . boardConf::BOARD_NUM;

        // sql문 사용
        return $conn->query($sql);
    }



    // 게시글 작성
    // $title : 제목
    // $name : 이름
    // $password : 비밀번호
    // $content : 내용
    static function writeBoard($title, $name, $password, $content) {
        $conn   = DB_Connect();
        $sql    = "INSERT INTO mybulletin VALUES(0, 0, '$name', '$password', '$title', '$content', 0, now())";

        // sql문 사용
        $conn->query($sql);
    }


    // 조회 수 증가
    // $argBoardId : 게시글 번호
    static function hitUp($argBoardId){
        // 디비 사용
        $conn = DB_Connect();

        // 게시글 넘버 받아오기
        if(library::isExist([$argBoardId])){
            // 조회 수 1 증가
            $sql    = "UPDATE mybulletin SET hits = hits + 1 WHERE board_id = $argBoardId";
            $conn->query($sql);
        }
    }


    // 한 게시글 정보 가져오기
    // $argBoardId : 게시글 번호
    static function oneBoardInfo($argBoardId){
        // 디비 사용
        $conn = DB_Connect();

        // 보여줄 데이터 가져오기
        $sql    = "SELECT title, user_name, reg_date, hits, contents FROM mybulletin WHERE board_id = $argBoardId";
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }


    // 댓글 추가
    // $argBoardId : 게시글 번호
    // $argName : 작성자 이름
    // $argPassword : 작성자 비밀번호
    // $argComment : 댓글 내용
    static function addComment($argBoardId, $argName, $argPassword, $argComment){
        // 디비 사용
        $conn = DB_Connect();

        if(library::isExist([$argComment])){
            $sql = "INSERT INTO mybulletin VALUES(0, $argBoardId, '$argName', '$argPassword', '', '$argComment', 0, now())";
            $conn->query($sql);
        }
    }


    // 보여줄 댓글 가져오기
    // $argBoardId : 게시글 번호
    static function viewComment($argBoardId){
        // 디비 사용
        $conn = DB_Connect();

        // 보여줄 데이터 가져오기
        $sql    = "SELECT board_id, user_name, DATE_FORMAT(reg_date,'%Y-%m-%d') 'reg_date', contents 
            FROM mybulletin WHERE board_pid = $argBoardId";

        // sql문 사용
        return $conn->query($sql);
    }


    // 게시글 or 댓글 지우기
    // $argBoardId : 지울 글의 번호
    static function deleteBoard($argBoardId){
        // 디비 사용
        $conn = DB_Connect();

        $sql = "DELETE FROM mybulletin WHERE board_id = $argBoardId";
        $conn->query($sql);
    }

    // 수정할 게시글 내용 가져오기
    // $argBoardId : 게시글 번호
    static function getBoard($argBoardId){
        // 디비 연결
        $conn   = DB_Connect();

        $sql    = "SELECT board_id, title, user_name, contents FROM mybulletin WHERE board_id = $argBoardId";
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }


    // 게시글 수정
    static function modifyBoard($argBoardId, $argTitle, $argContent){
        // 디비 연결
        $conn   = DB_Connect();

        $sql = "UPDATE mybulletin SET title = '$argTitle', contents = '$argContent' WHERE board_id = $argBoardId";
        $conn->query($sql);
    }


}