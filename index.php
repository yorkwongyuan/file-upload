<?php
if($_POST){
    $files = $_FILES['data'];
    $arr['index'] = $_POST['index'];
    $arr['totalCount'] = $_POST['totalCount'];
    $arr['name'] = $_POST['name'];
    $arr['lastModified'] = $_POST['lastModified'];
    $arr['totalSize'] = $_POST['totalSize'];
    if($files['error']){
        $arr['status'] = 500;
        exit(json_encode($arr));
    }
 
    if($files['error'] == 0){
        if($arr['index']==1 && is_file("/Crawler/Public/Upload/".$arr['name']) && filesize($_SERVER['DOCUMENT_ROOT'].'/Crawler/Public/Upload/'.$arr['name']) == $arr['totalSize']){
            unlink($_SERVER['DOCUMENT_ROOT'].'/Crawler/Public/Upload/'.$arr['name']);
        }

    // file_put_contents 向文件输入内容
    if(!file_put_contents($_SERVER['DOCUMENT_ROOT'].'/Crawler/Public/Upload/'.$arr['name'],file_get_contents($files['tmp_name']),FILE_APPEND)){
        $arr['status'] = 501;
        exit(json_encode($arr));
    }

    // 传输完成之后
    if($arr['index'] == $arr['totalCount']){
        if(filesize($_SERVER['DOCUMENT_ROOT'].'/Crawler/Public/Upload/'.$arr['name']) == $arr['totalSize']){
            $arr['status'] = 200;
        }else{
            $arr['status'] = 502;
            $arr['big'] = filesize($_SERVER['DOCUMENT_ROOT'].'/Crawler/Public/Upload/'.$arr['name']);
            exit(json_encode($arr));
        }
        exit(json_encode($arr));
    }


    $arr['status'] = 201;
    exit(json_encode($arr));
    }else{
        $arr['status'] = 502;
        exit(json_encode($arr));
    }
}else{
    $this ->display();
}
?>