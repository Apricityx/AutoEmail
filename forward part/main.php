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

        body {
            font-family: 'font_style01';
        }
    </style>
</head>
<body>
<!--<div id="background">-->
<!--    <canvas id="canvas">-->
<div id="title"><h1>软工3、4班邮件服务平台</h1></div>
<div id="left">
    <div id="search_box">
        <input type="text" name="search" placeholder="搜索学号">
        <div id="search_">SEARCH</div>
    </div>
    <div id="std_text">
        <!--        放竖着的学生信息-->

    </div>
</div>

<div>
    <marquee behavior="scroll" direction="left" id="std_info">
        <!--        放横着的学生信息-->

    </marquee>
</div>
<!--    </canvas>-->
<!--</div>-->
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
    let flag_ = 0
    for (let i = 61; i < 121; i++) {
        if ((i - 61) % 20 === 0) {
            if (flag_ === 0) {
                flag_ = 1;
            } else {
                document.getElementById('std_info').innerHTML += '<br>';
            }
        }
        if (skip_num.includes(i)) {
            document.getElementById('std_info').innerHTML += std_right.replace('{order_num}', i - 61).replace('{std_num}', i).replace('{color}', 'grey');
            document.getElementById('std_text').innerHTML += std_example.replace('{num}', i).replace('{pic}', 'WRONG.svg');
            counter++;
        } else {
            if (name_submitted.includes(name_total[i - 61 - counter])) {
                document.getElementById('std_info').innerHTML += std_right.replace('{order_num}', i - 61).replace('{std_num}', i).replace('{color}', '8dc26f');
                document.getElementById('std_text').innerHTML += std_example.replace('{num}', i).replace('{pic}', 'icons8-done-48.png');
            } else {
                document.getElementById('std_info').innerHTML += std_right.replace('{order_num}', i - 61).replace('{std_num}', i).replace('{color}', 'grey');
                document.getElementById('std_text').innerHTML += std_example.replace('{num}', i).replace('{pic}', 'icons8-close-30.png');
            }
        }
    }

</script>
<!--右侧-->
<script>

</script>
<script>
    //let blank = [63, 72, 74];
    //let style = ' style="width: 240px;display: inline-block;font-size: 2em;text-align: center;"'
    //for (let j = 0; j < 60; j++) {
    //    if (blank.includes(j + 61)) {
    //        continue;//跳过空白
    //    }
    //    let id_1 = 'image_n' + j;
    //    let id_2 = 'image_y' + j;
    //    let x = j + 61;
    //    let data = '<p' + style + '> ' + x + '</p> ' + '<div class="image-container"> ' + '<img id="' + id_1 + '" src="pictures/icons8-close-30.png"> ' + '<img id="' + id_2 + '" src="pictures/icons8-done-48.png" style="display: none;"> ' + '</div>';
    //    document.getElementById('std_text').innerHTML += data;
    //
    //}
    //let newline = '<br>';
    //// let new_line = [18, 37, 56];
    //let class_ = 'std';
    //for (let r = 0; r < 60; r++) {
    //    // let h_t=[0,56];
    //    let id = 'div' + r;
    //    let data_ = '<div class="' + class_ + '"' + ' id="' + id + '"><h2>' + (r + 61) + '</h2></div>';
    //    let data_t = '<div class="' + class_ + '"' + ' id="' + id + '"><h2>' + (r + 61) + '</h2></div>' + newline;
    //    if (blank.includes(r + 61)) {
    //        continue;
    //        // } else if (r === 0) {
    //        //     document.getElementById('std_info').innerHTML += head;
    //        // } else if (r === 56) {
    //        //     document.getElementById('std_info').innerHTML += tail;
    //    }
    //    if ((r + 1) % 20 === 0) {
    //        document.getElementById('std_info').innerHTML += data_t;
    //    } else {
    //        document.getElementById('std_info').innerHTML += data_;
    //    }
    //    // else if(new_line.includes(r)) {
    //    //     console.log(new_line);
    //    //     document.getElementById('std_info').innerHTML += data_t;
    //    // } else {
    //    //     document.getElementById('std_info').innerHTML += data_;
    //    // }
    //    // // if(r in blank) {
    //    //     continue;
    //    // }else{
    //    //     document.getElementById('std_info').innerHTML+=data_;
    //    //     }
    //
    //
    //}
    //var total_s = <?php //echo json_encode($total_s); ?>//;
    //var var_ = <?php //echo json_encode($var_); ?>//;
    //var total_s_num = <?php //echo json_encode($total_s_num); ?>//;
    //var var_num = <?php //echo json_encode($var_num); ?>//;
    //// 然后我们遍历数组A
    //for (let i = 0; i < total_s.length; i++) {
    //    // 我们获取第i个div元素
    //    let div = document.getElementById('div' + i);
    //    let image_n = document.getElementById('image_n' + i);
    //    let image_y = document.getElementById('image_y' + i);
    //    // 判断A中的第i个元素是否存在于B中
    //    if (var_.includes(total_s[i])) {
    //        // 如果存在，我们将div的颜色设置为绿色
    //        div.style.backgroundColor = "43FA09";
    //        image_n.style.display = 'none';
    //        image_y.style.display = 'inline-block';
    //    } else {
    //        // 如果不存在，我们将div的颜色设置为灰色
    //        div.style.backgroundColor = "grey";
    //        image_n.style.display = 'inline-block';
    //        image_y.style.display = 'none';
    //    }
    //}
    //alert("共有" + total_s_num + "名学生，已提交" + var_num + "份作业");
    //// var students = document.getElementsByClassName('std');
    ////     for(var i=0;i<students.length;i++){
    ////         students[i].addEventListener('mouseover',function(e){
    ////         e.target.style.animationPlayState='paused';
    ////         });
    ////         students[i].addEventListener('mouseout',function(e){
    ////         e.target.style.animationPlayState='running';
    ////         }
    ////
    // }
</script>
</body>
</html>
