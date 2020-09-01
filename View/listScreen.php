<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>main</title>
    <style>
        #myTable {
            border: 1px solid #444444;
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        #myTable td, th {
            border: 1px solid #444444;
            padding: 10px;
        }

        p, #find {
            text-align: center;
        }

        #write, #back {
            float: right;
            margin-top: 10px;
            margin-right: 10px;
            width: 90px;
            height: 30px;
        }

        #table_title {
            width: 60%;
        }

        #search {
            width: 300px;
        }
    </style>
</head>
<body>

<?php
// 로그인 되었을 때
if(isset($_SESSION['login']) && $_SESSION['login']){
    ?>
    <fieldset style="width:250px">
        <legend> 사용자 정보 </legend>
        이름 : <?php echo $_SESSION['name'];?><br>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <input type="hidden" name="logout" value="true">
            <input type="submit" value="로그아웃">
        </form>
    </fieldset>
    <?php
}
// 세션이 없어 로그인을 해야할 때
else { ?>
<fieldset style="width:300px">
    <legend> 로그인 </legend>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <table>
            <tr>
                <td> ID </td>
                <td> <input type="text" name="id"> </td>
                <td rowspan="2"> <input type="hidden" name="login" value="true">
                    <input type="submit" value="로그인"> </td>
            </tr>
            <tr>
                <td> Password </td>
                <td> <input type="text" name="password"> </td>
            </tr>
        </table>
    </form>
</fieldset>
<?php
}
?>

<br>

<!-- 테이블 출력 -->
<table id="myTable">
    <tr>
        <th colspan="5" style="background-color: #c9c9c9"> SH Lee 게시판</th>
    </tr>
    <tr>
        <th> 번호</th>
        <th id="table_title"> 제목</th>
        <th> 작성자</th>
        <th> 조회수</th>
        <th> 날짜</th>
    </tr>

<?php
    // 테이블 출력
    while ($record = $result->fetch_object("board_information")) {
        echo "
            <tr style='text-align:center'>
                <td id='board_id'> $record->board_id </td>
                <td> <a href='".boardConf::VIEW."?board_id=".$record->board_id."&opt=".$opt."&search=".$searchText."&page=".$page."'> $record->title </a></td>
                <td> $record->user_name </td>
                <td> $record->hits </td>
                <td> $record->reg_date </td>
            </tr>    
            ";
    }
// DB 에서 받아온 정보
class board_information{}
?>
</table>


<!--검색 기능 구현-->
<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="find">
    <span> 검색 키워드 </span>
    <select name="opt">
        <option value="title"> 제목</option>
        <option value="contents"> 내용</option>
        <option value="name"> 작성자</option>
        <option value="titleContents"> 제목+내용</option>
    </select>
    <input type="search" name="search" id="search"/>
    <input type="submit" name="submit" id="submit" value="검색"/>
</form>

<!--페이지네이션-->
<p>
    <?php
    // 이전 블럭으로 넘어가기
    if ($page > boardConf::PAGE_BLOCK) {
        echo "<a href='{$_SERVER['PHP_SELF']}?page={$leftBlockPage}&opt={$opt}&search={$searchText}'><<&nbsp</a>";
    }

    // 페이지 넘어가는 하이퍼링크 만들기
    for ($i = $beginningPage; $i <= $lastPage; $i++) {
        if ($i == $pageNum + 1) break;
        echo "<a href='{$_SERVER['PHP_SELF']}?page={$i}&opt={$opt}&search={$searchText}'" .
            ($i == $page ? "style='color:red'" : null) . ">{$i} ";
    }

    // 다음 블럭으로 넘어가기
    if ($page <= $rightBlockPage) {
        echo "<a href='{$_SERVER['PHP_SELF']}?page={$firstPageOfRightBlockPage}&opt={$opt}&search={$searchText}'>>></a>";
    }
    ?>
</p>

<!--글쓰기 버튼-->
<?php if(library::isLogin()){ ?>
    <form method="post" action=<?php echo boardConf::WRITE; ?>>
        <input type="submit" name="write" id="write" value="글쓰기"/>
    </form>
<?php } ?>

<!--리스트 돌아가기 버튼-->
<?php if ($opt != "") { ?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="submit" name="back" id="back" value="리스트" />
</form>
<?php } ?>

