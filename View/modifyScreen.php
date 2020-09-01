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
        input{
            margin: 5px;
            text-align: center;
        }
        form{
            display: inline;
        }
        #temp{
            width: 100px;
        }
        #content{
            margin-top: 5px;
            width: 690px;
            height: 300px;
        }
        #in{
            width: 500px;
        }
    </style>
</head>
<body>

<?php if($_SESSION['name'] == $record['user_name']){ ?>
<fieldset>
    <legend> 글수정 : 글 번호 <?php echo $_REQUEST['board_id'];?></legend>

    <form method="post" action=<?php echo boardConf::MODIFY_PROCESS;?>>
        <table>
            <tr>
                <td id="temp"> 제목 </td>
                <td> <input type="text" name="title" id="in" value="<?php echo $record['title']; ?>"/> </td>
            </tr>
        </table>

        <textarea name="content" id="content"><?php echo $record['contents']; ?></textarea><br>

        <input type="hidden" name="board_id" value="<?php echo $record['board_id']; ?>"/>

        <input type="submit" name="submit" id="modify" value="글수정"/>
    </form>

    <form method="post" action=<?php echo boardConf::LIST;?>>
        <input type="submit" name="submit" id="list" value="글목록"/>
    </form>
</fieldset>
<?php }

else {
    echo "<script> alert('잘못된 접근입니다.\\n리스트 페이지로 이동합니다.'); </script>";
    library::movePage(boardConf::LIST);
}?>
</body>
</html>


