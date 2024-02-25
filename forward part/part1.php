<?php
function get_str_array_list($obj){ //将文本转化为list
    $pattern='/[\x{4e00}-\x{9fa5}]+/u';
    preg_match_all($pattern,$obj,$array);
    $chineseArray=$array[0];
    $list=implode(', ',$chineseArray);
    echo $list;
}

function get_file_array_list($obj_)
{
    $initial=scandir($obj_);//读取文件夹下的文件及目录并存储在数组中
    $number=count($initial)-2;
    echo $number;
    $move=array_slice($initial,2);
    $pattern_='/[^\x{4e00}-\x{9fa5}]/u';
    foreach ($move as &$end){
        $end=preg_replace($pattern_,'',$end);
    }
    $list_end=implode(', ',$move);
    print_r($list_end);
}

//读取文本
$file='D:\PHP\file\forward part\text\totalsudents.txt';
$content=file_get_contents($file);
//调用文本转化为list（字符串）函数
get_str_array_list($content);
//读取文件夹
$path='D:\workfile\FileRecv\homeworksubmit';
//调用文件夹转化为list（字符串）函数
get_file_array_list($path);
?>