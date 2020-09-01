<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>main</title>
    <style>
        fieldset{
            background-color: #eeeeee;
            width: 700px;
        }
        legend{
            background-color: gray;
            color: white;
            padding: 5px 10px;
        }
        table {
            border: 1px solid #444444;
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            text-align: center;
        }
        th, td {
            border: 1px solid #444444;
            padding: 10px;
        }
        input{
            margin: 5px;
        }
        form{
            display: inline;
        }
        #content{
            margin-top: 5px;
            width: 690px;
            height: 300px;
        }
        #temp{
            width: 100px;
        }
        #comment, #name, #password {
            width: 400px;
        }
    </style>
</head>
<body>

<fieldset>
    <legend> 글보기 글 번호 <?php echo $_REQUEST['board_id'];?> </legend>
    <table>
        <tr>
            <td id="temp"> 제목 </td>
            <td> <?php echo $record['title']; ?> </td>
        </tr>
        <tr>
            <td id="temp"> 작성자 </td>
            <td> <?php echo $record['user_name']; ?> </td>
        </tr>
        <tr>
            <td id="temp"> 작성시간 </td>
            <td> <?php echo $record['reg_date']; ?> </td>
        </tr>
        <tr>
            <td id="temp"> 조회수 </td>
            <td> <?php echo $record['hits']; ?> </td>
        </tr>
    </table>
    <textarea name="content" id="content" readonly><?php echo $record['contents'];?></textarea><br>

    <form method="get" action="<?php echo boardConf::LIST;?>">
        <input type="hidden" name="opt" id="opt" value="<?php echo $_REQUEST['opt'];?>"/>
        <input type="hidden" name="search" id="search" value="<?php echo $_REQUEST['search'];?>"/>
        <input type="hidden" name="page" id="page" value="<?php echo $_REQUEST['page'];?>"/>
        <input type="submit" name="submit" id="list" value="글목록"/>
    </form>

    <?php if($_SESSION['name'] == $record['user_name']){ ?>
        <form method="post" action="<?php echo boardConf::DELETE;?>">
            <input type="hidden" name="board_id" value="<?php echo $_REQUEST['board_id']; ?>"/>
            <input type="submit" name="submit" id="delete" value="글삭제"/>
        </form>

        <form method="post" action="<?php echo boardConf::MODIFY;?>">
            <input type="hidden" name="board_id" value="<?php echo $_REQUEST['board_id']; ?>"/>
            <input type="submit" name="submit" id="modify" value="글수정"/>
        </form>
    <?php } ?>

    <p> </p>

    <!--댓글 구현-->
    <table>
        <tr><th colspan="4"> 댓글 </th></tr>
        <?php if(library::isLogin()){ ?>
            <tr>
                <td> 코멘트 </td>
                <td colspan="3">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
                        <input type="text" name="comment" id="comment" /></td>
            </tr>
            <tr> <td colspan="4">
                    <input type="hidden" name="board_id" id="board_id" value="<?php echo $_REQUEST['board_id']; ?>"/>
                    <input type="submit" name="writeComment" id="writeComment" value="댓글쓰기"/>
                    </form></td></tr>
        <?php } ?>

        <tr>
            <th> 작성자 </th>
            <th> 코멘트 </th>
            <th> 작성일 </th>
            <th> 삭제 </th>
        </tr>

    <?php
    while($commentInfo = $result->fetch_object("comment_info")){
        echo "<tr>
                <td> $commentInfo->user_name</td>
                <td> $commentInfo->contents</td>
                <td> $commentInfo->reg_date</td>
                <td> <form method='post' action='".boardConf::DELETE."'>
                <input type='hidden' name='parent_id' id='parent_id' value='".$_REQUEST['board_id']."'/>
                <input type='hidden' name='board_id' id='board_id' value='".$commentInfo->board_id."'/>";
            if($_SESSION['name'] == $commentInfo->user_name)
            echo "<input type='submit' name='del' id='del' value='삭제'/> </form> </td> </tr>";
        }

        // 댓글 정보
        class comment_info{}
        ?>
    </table>
</fieldset>

</body>
</html>