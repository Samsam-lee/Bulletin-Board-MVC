<?php
class library {
    // 유효성 검사
    // $argValue : array
    // return True or False
    static function isExist($argValue){
        foreach($argValue as $value){
            if(isset($value) && $value != null){
                return true;
            } else {
                return false;
            }
        }
    }

    // html 태그 제거
    // $argValue : array (key 값, value 값 활용 가능)
    // return Array
    static function deleteHtmlTag($argValue){
        $temp = [];
        foreach($argValue as $key => $value){
            $temp[$key] = htmlspecialchars($value);
        }
        return $temp;
    }


    // 비밀번호 암호화
    // password_hash($temp, PASSWORD_DEFAULT);

    // 비밀번호 복호화 (암호화 된 값과 입력 값 비교)
    // password_verify(비교할 값, 암호화 된 값);


    // 스크립트로 페이지 이동
    // $argPage : 이동 할 페이지 명
    static function movePage($argPage){
        echo "<script> document.location.href = '{$argPage}' </script>";
    }


    // 로그아웃 눌렀을 때 세션 없애고 페이지 새로고침
    // $isLogout : $_REQUEST['logout']
    static function logout($isLogout){
        if(isset($isLogout) && $isLogout){
            // destroy 즉시 반영이 되지 않기 때문에
            $_SESSION = array();
            // 세션 제거
            session_destroy();
            // 세션 제거 후 새로고침
            header("Refresh:0");
        }
    }


    // 검색 옵션에 따라 추가할 sql 문 설정
    // $opt : 검색 옵션
    // $searchText : 사용자가 입력한 검색 값
    static function sqlPlus($opt, $searchText){
        // 검색 옵션에 따라 sql 문 지정
        switch ($opt) {
            case "title":
                return "AND title LIKE '%$searchText%'";
            case "contents":
                return "AND contents LIKE '%$searchText%'";
            case "name":
                return "AND user_name LIKE '%$searchText%'";
            case "titleContents":
                return "AND title LIKE '%$searchText%' OR contents LIKE '%$searchText%'";
            default:
                return "";
        }
    }

    // 로그인 확인 여부
    // $_SESSION['login'] 존재 유무
    static function isLogin() {
        if(session_status() !== PHP_SESSION_ACTIVE)
            session_start();

        // 로그인 상태 일 때
        if (isset($_SESSION['login']))
            return true;

        // 로그인 상태가 아닐 때
        return false;
    }


}