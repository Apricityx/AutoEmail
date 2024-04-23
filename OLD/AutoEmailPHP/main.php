<html>
<head>
    <title>软工3、4班邮件服务平台</title>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        @font-face {
            font-family: 'font_style05';
            src: url('font/font_style05.otf');
        }

        @font-face {
            font-family: 'font_style06';
            src: url('font/font_style06.otf');
        }

        @font-face {
            font-family: 'font_style07';
            src: url('font/font_style07.otf');
        }

        @font-face {
            font-family: 'font_style08';
            src: url('font/font_style08.otf');
        }

        @font-face {
            font-family: 'font_style10';
            src: url('font/font_style10.otf');
        }

        @font-face {
            font-family: 'font_style13';
            src: url('font/font_style13.otf');
        }

        @font-face {
            font-family: 'font_style14';
            src: url('font/font_style14.otf');
        }

        h1 {
            font-family: 'font_style01';
            letter-spacing: 16px;
        }

        #std_text {
            font-family: 'font_style04';
            color: #2d2c2c;
        }

        .std {
            font-family: sans-serif;
        }
    </style>
</head>
<body>

<div id="title"><h1>软工3、4班邮件服务平台</h1></div>
<div id="left">
    <div id="search_box">
        <input type="text" name="search" placeholder="搜索学号" class="in_put">
        <div id="search_">SEARCH</div>
    </div>
    <div id="std_text">
        <!--        放竖着的学生信息-->

    </div>
</div>

<div id="box">
    <div id="std_info1">
        <!--        放横着的学生信息-->

    </div>
    <div id="std_info2"></div>
    <!--        放横着的学生信息-->
    <!--    <marquee behavior="scroll" direction="left" id="std_info">-->
    <!--        放横着的学生信息-->

    <!--    </marquee>-->

</div>
<?php
function get_str_array_list($obj)
{ //将文本转化为list
    $pattern = '/[\x{4e00}-\x{9fa5}]+/u';
    preg_match_all($pattern, $obj, $array);
    $chineseArray = $array[0];
    //$list=implode(', ',$chineseArray);
    return $chineseArray;
}

function get_file_array_list($obj_)
{
    $initial = scandir($obj_);//读取文件夹下的文件及目录并存储在数组中
//    $number=count($initial)-2;
//    echo $number;
    $move = array_slice($initial, 2);
    $pattern_ = '/[^\x{4e00}-\x{9fa5}]/u';
    foreach ($move as &$end) {
        $end = preg_replace($pattern_, '', $end);
    }
//    $list_end=implode(', ',$move);
//    print_r($list_end);
    return $move;
}

//读取文本
$file = './text/totalsudents.txt';
$content = file_get_contents($file);
//调用文本转化为list（字符串）函数
$total_s = get_str_array_list($content);
$total_s_num = count($total_s);
//读取文件夹
$path = './homeworksubmit';
//调用文件夹转化为list（字符串）函数
get_file_array_list($path);
$var_ = get_file_array_list($path);
$var_num = count($var_);
?>
<!--左侧-->

<script type="text/javascript">
    std_example = `<div class="student">
        <div class="std_left">
        {num}
        </div>
    <div>
        <img src="pictures/{pic}">
    </div>
    </div>`
    // test = std_example.replace('{num}', 2).replace('{pic}', 'WRONG.svg');
    // 学号从61开始
    std_right = `<div class="std" id="div{order_num}" style="background-color:{color}"><h2>{std_num}</h2></div>`
    skip_num = [63, 72, 74];

    name_submitted = <?php echo json_encode($var_); ?>; //已提交的学生
    name_total = <?php echo json_encode($total_s); ?>;//总学生
    let counter = 0;
    // let flag_ = 0
    for (let i = 61; i < 121; i++) {
        if ((i - 61) % 20 === 0) {
            // if (flag_) {
            //     flag_ = 1;
            //     console.log('跳')
            // } else {
            document.getElementById('std_info1').innerHTML += '<br>';
            document.getElementById('std_info2').innerHTML += '<br>';
        }
        if (skip_num.includes(i)) {
            document.getElementById('std_info1').innerHTML += std_right.replace('{order_num}', i - 61).replace('{std_num}', i).replace('{color}', 'grey');
            document.getElementById('std_text').innerHTML += std_example.replace('{num}', i).replace('{pic}', 'WRONG.svg');
            counter++;
        } else {
            if (name_submitted.includes(name_total[i - 61 - counter])) {
                document.getElementById('std_info1').innerHTML += std_right.replace('{order_num}', i - 61).replace('{std_num}', i).replace('{color}', '7F9F80');
                document.getElementById('std_text').innerHTML += std_example.replace('{num}', i).replace('{pic}', 'icons8-done-48.png');
            } else {
                document.getElementById('std_info1').innerHTML += std_right.replace('{order_num}', i - 61).replace('{std_num}', i).replace('{color}', '2f2f35');
                document.getElementById('std_text').innerHTML += std_example.replace('{num}', i).replace('{pic}', 'icons8-close-30.png');
            }
        }
    }
</script>
<script>
    let box1 = document.getElementById('std_info1');
    let box2 = document.getElementById('std_info2');
    let box = document.getElementById('box');
    let speed = 5;
    box2.innerHTML = box1.innerHTML;
    console.log(box.scrollLeft)
    setInterval(function () {
        console.log(speed)
        if (box.scrollLeft >= box1.offsetWidth) {
            box.scrollLeft = 0;
        } else {
            box.scrollLeft += speed;
        }
    }, 20);
    // for(j=0;j<60;j++){
    var scrollDiv = document.getElementsByClassName('std');
    for (let i = 0; i < scrollDiv.length; i++) {
        scrollDiv[i].addEventListener('click', function () {
            speed = 0
        })
        scrollDiv[i].addEventListener('mouseout', function () {
            speed = 5
        })
    }
    //     scrollDiv.addEventListener('mouseover', function() {
    //         //     // 鼠标移入时停止滚动
    //             scrollDiv.style.overflow = 'hidden';
    //         });
    //     scrollDiv.addEventListener('mouseout', function() {
    //             // 鼠标移出时恢复滚动
    //             scrollDiv.style.overflow = 'auto';
    //         });
    // }
    //
    //
    //
    //
    //
</script>
</body>
</html>
