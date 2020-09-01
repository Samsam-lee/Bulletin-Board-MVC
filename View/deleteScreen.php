<?php
// 댓글 삭제
if(library::isExist([$parent_id])){
    echo "<script> alert('댓글이 정상적으로 삭제되었습니다. \\n게시글로 돌아갑니다.'); 
                   document.location.href='".boardConf::VIEW."?board_id={$parent_id}';
          </script>";
}

// 게시글 삭제
else {
    echo "<script> alert('글이 정상적으로 삭제되었습니다.'); </script>";
    library::movePage(boardConf::LIST);
}


