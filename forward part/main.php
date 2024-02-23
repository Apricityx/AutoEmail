<html>
<head>
    <title>软工3、4班邮件服务平台</title>
<!--    <script src="mainpage.js"></script>-->
    <link rel="stylesheet" href="mainpage.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div id="title"><h1>软工3、4班邮件服务平台</h1></div>
<div id="left">1</div>
<div id="std_info">2<br>3<br>4
<!--<div class="std" id="div0"></div>-->
<!--<div class="std" id="div1"></div>-->
<!--<div class="std" id="div2"></div>-->
<!--<div class="std" id="div3"></div>-->
<!--<div class="std" id="div4"></div>-->
<!--<div class="std" id="div5"></div>-->
<!--<div class="std" id="div6"></div>-->
<!--<div class="std" id="div7"></div>-->
<!--<div class="std" id="div8"></div>-->
<!--<div class="std" id="div9"></div>-->
<!--<div class="std" id="div10"></div>-->
<!--<div class="std" id="div11"></div>-->
<!--<div class="std" id="div12"></div>-->
<!--<div class="std" id="div13"></div>-->
<!--<div class="std" id="div14"></div>-->
<!--<div class="std" id="div15"></div>-->
<!--<div class="std" id="div16"></div>-->
<!--<div class="std" id="div17"></div>-->
<!--<div class="std" id="div18"></div>-->
<!--<div class="std" id="div19"></div>-->
<!--<div class="std" id="div20"></div>-->
<!--<div class="std" id="div21"></div>-->
<!--<div class="std" id="div22"></div>-->
<!--<div class="std" id="div23"></div>-->
<!--<div class="std" id="div24"></div>-->
<!--<div class="std" id="div25"></div>-->
<!--<div class="std" id="div26"></div>-->
<!--<div class="std" id="div27"></div>-->
<!--<div class="std" id="div28"></div>-->
<!--<div class="std" id="div29"></div>-->
<!--<div class="std" id="div30"></div>-->
<!--<div class="std" id="div31"></div>-->
<!--<div class="std" id="div32"></div>-->
<!--<div class="std" id="div33"></div>-->
<!--<div class="std" id="div34"></div>-->
<!--<div class="std" id="div35"></div>-->
<!--<div class="std" id="div36"></div>-->
<!--<div class="std" id="div37"></div>-->
<!--<div class="std" id="div38"></div>-->
<!--<div class="std" id="div39"></div>-->
<!--<div class="std" id="div40"></div>-->
<!--<div class="std" id="div41"></div>-->
<!--<div class="std" id="div42"></div>-->
<!--<div class="std" id="div43"></div>-->
<!--<div class="std" id="div44"></div>-->
<!--<div class="std" id="div45"></div>-->
<!--<div class="std" id="div46"></div>-->
<!--<div class="std" id="div47"></div>-->
<!--<div class="std" id="div48"></div>-->
<!--<div class="std" id="div49"></div>-->
<!--<div class="std" id="div50"></div>-->
<!--<div class="std" id="div51"></div>-->
<!--<div class="std" id="div52"></div>-->
<!--<div class="std" id="div53"></div>-->
<!--<div class="std" id="div54"></div>-->
<!--<div class="std" id="div55"></div>-->
<!--<div class="std" id="div56"></div>-->
</div>
<!--<div id="footer"></div>-->
<?php
function get_str_array_list($obj){ //将文本转化为list
    $pattern='/[\x{4e00}-\x{9fa5}]+/u';
    preg_match_all($pattern,$obj,$array);
    $chineseArray=$array[0];
    //$list=implode(', ',$chineseArray);
    return $chineseArray;
}

function get_file_array_list($obj_)
{
    $initial=scandir($obj_);//读取文件夹下的文件及目录并存储在数组中
//    $number=count($initial)-2;
//    echo $number;
    $move=array_slice($initial,2);
    $pattern_='/[^\x{4e00}-\x{9fa5}]/u';
    foreach ($move as &$end){
        $end=preg_replace($pattern_,'',$end);
    }
//    $list_end=implode(', ',$move);
//    print_r($list_end);
    return $move;
}

//读取文本
$file='D:\PHP\file\forward part\text\totalsudents.txt';
$content=file_get_contents($file);
//调用文本转化为list（字符串）函数
$total_s=get_str_array_list($content);
$total_s_num=count($total_s);
//读取文件夹
$path='D:\workfile\FileRecv\homeworksubmit';
//调用文件夹转化为list（字符串）函数
get_file_array_list($path);
$var_= get_file_array_list($path);
$var_num=count($var_);
?>
<script>
    var total_s = <?php echo json_encode($total_s); ?>;
    var var_ = <?php echo json_encode($var_); ?>;
    var total_s_num = <?php echo json_encode($total_s_num); ?>;
    var var_num = <?php echo json_encode($var_num); ?>;
    // 然后我们遍历数组A
    for (let i = 0; i < total_s.length; i++) {
        // 我们获取第i个div元素
        let div = document.getElementById('div' + i);

        // 判断A中的第i个元素是否存在于B中
        if (var_.includes(total_s[i])) {
            // 如果存在，我们将div的颜色设置为绿色
            div.style.backgroundColor = "green";
        } else {
            // 如果不存在，我们将div的颜色设置为灰色
            div.style.backgroundColor = "grey";
        }
    }

</script>
</body>
</html>
