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
$dir='D:\workfile\FileRecv\homeworksubmit';
$submitted=array();
function getfilecounts($ff){
    $dir = 'D:\workfile\FileRecv\homeworksubmit'.$ff;
    $handle = opendir($dir);
    $i = 0;
    while(false !== $file=(readdir($handle))){
        if($file !== '.' && $file != '..')
        {
            $i++;
        }
    }
    closedir($handle);
    return $i;
}
   echo getfilecounts( );
    if(is_dir($dir)){
    $info=opendir($dir);
    while(($file=readdir($info))!==false){
        /*if($file == '.')
            continue;
        if($file == '..')
            continue;*/  //将前面三个点去掉

       // for($i=1;$i<strlen)
      //  $submitted = $file."<br>";
      echo $file."<br>";
    }
    closedir($info);
}
    //echo $submitted;
?>
<p>hello</p>
</body>

</html>