<html>
<head>
    <style type="text/css">
        p{
            color:rebeccapurple;
        }
    </style>
</head>
<body>
<?php
// 读取文本1
//    $file_path="totalsudents.txt";
//    if(file_exists($file_path)){
//        $fp=fopen($file_path,"r");
//        $str=fread($fp,filesize($file_path));
//        echo $str=str_replace("\r\n","<br />",$str);
//    }
//else{
//    echo "fail";
//}

//读取文本
$file='D:\PHP\file\try\text\totalsudents.txt';
$content=file_get_contents($file);
echo $content."<br>";

//将所有同学名字转化为数组
$pattern = '/[\x{4e00}-\x{9fa5}]+/u'; // 匹配中文字符的正则表达式
preg_match_all($pattern, $content, $total);
$chineseArray = $total[0];
print_r($chineseArray);
$total_number=count($total);
echo $total_number;

//读取文件夹
$path='D:\workfile\FileRecv\homeworksubmit';
$submitted=scandir($path);
    //print_r($submitted);
$counts=count($submitted)-2;
echo $counts;
//将文件夹转化为数组
$newArray = array_slice($submitted, 2);
print_r($newArray);
//纯中文数组
$pattern = '/[^\x{4e00}-\x{9fa5}]/u'; // 匹配非中文字符的正则表达式
foreach ($newArray as &$actual) {
    $actual = preg_replace($pattern, '', $actual);
}
print_r($newArray);
?>
<script>
    var javascriptVariable = "<?php echo $counts; ?>"
    //document.getElementsByTagName('body')[0].innerHTML = javascriptVariable
</script>
<p>hello</p>
</body>

</html>