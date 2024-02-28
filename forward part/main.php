<html>
<head>
    <title>软工3、4班邮件服务平台</title>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--    <script src="mainpage.js"></script>-->
    <link rel="stylesheet" href="mainpage.css">
<!--    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
    <style>
        @font-face {
            font-family: 'font_style01';
            src: url('font/font_style01.otf');
        }
        @font-face {
            font-family: 'font_style02';
            src: url('font/font_style02.otf');
        }
        @font-face {
            font-family: 'font_style03';
            src: url('font/font_style03.otf');
        }
        @font-face {
            font-family: 'font_style04';
            src: url('font/font_style04.otf');
        }
       body{
            font-family: 'font_style01';
        }
    </style>
</head>
<body>
<div id="title"><h1>软工3、4班邮件服务平台</h1></div>
<div id="left">
    <div id="search_box">
    <input type="text" name="search" placeholder="搜索学号"><div id="search_">SEARCH</div>
    </div>
</div>
<div id="std_info">
    <marquee behavior="scroll" direction="left">
<div class="std" id="div0"><h2>061</h2></div>
<div class="std" id="div1"><h2>062</h2></div>
<div class="std" id="div2"><h2>064</h2></div>
<div class="std" id="div3"><h2>065</h2></div>
<div class="std" id="div4"><h2>066</h2></div>
<div class="std" id="div5"><h2>067</h2></div>
<div class="std" id="div6"><h2>068</h2></div>
<div class="std" id="div7"><h2>069</h2></div>
<div class="std" id="div8"><h2>070</h2></div>
<div class="std" id="div9"><h2>071</h2></div>
<div class="std" id="div10"><h2>073</h2></div>
<div class="std" id="div11"><h2>075</h2></div>
<div class="std" id="div12"><h2>076</h2></div>
<div class="std" id="div13"><h2>077</h2></div>
<div class="std" id="div14"><h2>078</h2></div>
<div class="std" id="div15"><h2>079</h2></div>
<div class="std" id="div16"><h2>080</h2></div>
<div class="std" id="div17"><h2>081</h2></div>
<div class="std" id="div18"><h2>082</h2></div>
        </br>
<div class="std" id="div19"><h2>083</h2></div>
<div class="std" id="div20"><h2>084</h2></div>
<div class="std" id="div21"><h2>085</h2></div>
<div class="std" id="div22"><h2>086</h2></div>
<div class="std" id="div23"><h2>087</h2></div>
<div class="std" id="div24"><h2>088</h2></div>
<div class="std" id="div25"><h2>089</h2></div>
<div class="std" id="div26"><h2>090</h2></div>
<div class="std" id="div27"><h2>091</h2></div>
<div class="std" id="div28"><h2>092</h2></div>
<div class="std" id="div29"><h2>093</h2></div>
<div class="std" id="div30"><h2>094</h2></div>
<div class="std" id="div31"><h2>095</h2></div>
<div class="std" id="div32"><h2>096</h2></div>
<div class="std" id="div33"><h2>097</h2></div>
<div class="std" id="div34"><h2>098</h2></div>
<div class="std" id="div35"><h2>099</h2></div>
<div class="std" id="div36"><h2>100</h2></div>
<div class="std" id="div37"><h2>101</h2></div>
        </br>
<div class="std" id="div38"><h2>102</h2></div>
<div class="std" id="div39"><h2>103</h2></div>
<div class="std" id="div40"><h2>104</h2></div>
<div class="std" id="div41"><h2>105</h2></div>
<div class="std" id="div42"><h2>106</h2></div>
<div class="std" id="div43"><h2>107</h2></div>
<div class="std" id="div44"><h2>108</h2></div>
<div class="std" id="div45"><h2>109</h2></div>
<div class="std" id="div46"><h2>110</h2></div>
<div class="std" id="div47"><h2>111</h2></div>
<div class="std" id="div48"><h2>112</h2></div>
<div class="std" id="div49"><h2>113</h2></div>
<div class="std" id="div50"><h2>114</h2></div>
<div class="std" id="div51"><h2>115</h2></div>
<div class="std" id="div52"><h2>116</h2></div>
<div class="std" id="div53"><h2>117</h2></div>
<div class="std" id="div54"><h2>118</h2></div>
<div class="std" id="div55"><h2>119</h2></div>
<div class="std" id="div56"><h2>120</h2></div>
    </marquee>
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
$file='D:\PHP\file\AutoEmail\forward part\text\totalsudents.txt';
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

var students = document.getElementsByClassName('std');
    for(var i=0;i<students.length;i++){
        students[i].addEventListener('mouseover',function(e){
        e.target.style.animationPlayState='paused';
        });
        students[i].addEventListener('mouseout',function(e){
        e.target.style.animationPlayState='running';
        }

}
</script>
</body>
</html>
