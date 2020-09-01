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
        }
        #temp{
            width: 100px;
        }
        #content{
            margin-top: 5px;
            width: 690px;
            height: 300px;
        }
        #submit{
            width: 690px;
        }
    </style>
</head>
<body>
<?php if(library::isLogin()){?>
    <fieldset>
        <legend> 글쓰기 </legend>
        <form method="post" action=<?php echo boardConf::WRITE_PROCESS;?>>
            <table>
                <tr>
                    <td id="temp"> 제목 </td>
                    <td> <input type="text" name="title"/> </td>
                </tr>
                <tr>
                    <td id="temp"> 작성자 </td>
                    <td> <?php echo $_SESSION['name']; ?> </td>
                </tr>
            </table>

            <textarea name="content" id="content"></textarea><br>

            <input type="submit" name="submit" id="submit" value="글 쓰 기"/>
        </form>
    </fieldset>

<?php }

else { ?> <script> alert('잘못된 접근입니다.'); </script>
<?php library::movePage(boardConf::LIST); }?>

</body>
</html>

