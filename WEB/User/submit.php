<!DOCTYPE html>
<html lang="zh_CN">
<head>
    <meta charset="UTF-8">
    <title>作业管理平台 - 提交作业</title>
    <link rel="stylesheet" href="user_src/submit.css">
</head>
<body>
<div id="main">
    <div id="title">
        <h1>提  交  作  业</h1>
    </div>
    <div id="back">
        <button>返回</button>
    </div>
    <div id="content">
        <div id="submit_b">
            <form id="S_W" action="receive.php" method="post" enctype="multipart/form-data">
                <label for="homework_name">提交的作业名:</label>
                <input type="text" name="homework_name" id="homework_name" required>
<!--                    <option value="1">暂无作业</option>-->
                <br>
                <label id="std_name_label">姓名:
                    <input name="std_name" type="text" id="std_name">
                </label>
                <br>
                <label id="std_num_label">学号:
                    <input name="std_num" type="text" id="std_num">
                </label>
                <br>
                <label>点击选择文件:
                    <br>
<!--                    <input type="file" name="file">-->
                    <div id="select_" onclick="document.getElementById('select').click()">
                        <p>选择文件</p>
                    </div>
                </label>
                <input type="file" id="select" name="file" style="display: none">
                <br>
                <input type="submit" id="submit" value="提交">
            </form>
        </div>
    </div>
</div>
<?php
$course = $_GET["course"];
$result = json_encode($course);
?>

<!--<script>-->
<!--    // TEST-->
<!--    document.cookie = "name!Apricityx!name,num!22023321062106!num";-->
<!--    console.log(document.cookie)-->
<!--</script>-->
<script>
    let tables = <?php echo $result; ?>;
    console.log(tables);
    let homework_name = document.getElementById("homework_name");
    homework_name.innerHTML = "";
    let course_input = document.getElementById("homework_name");
    course_input.value = tables;

    // for (let i = 0; i < tables.length; i++) {
    //     if (tables[i] === "students") {
    //         continue;
    //     }
    //     let option = document.createElement("option");
    //     option.value = tables[i];
    //     option.innerText = tables[i];
    //     homework_name.appendChild(option);
    // }
</script>
<script>
    // 读取cookies中被!name name!包裹的字段并填入std_name中
    let std = decodeURIComponent(document.cookie.split("name=")[1]);
    std = std.split(";")[0];
    let num = document.cookie.split("num=")[1];
    num = num.split(";")[0];
    document.getElementById("std_name").value = std;
    document.getElementById("std_num").value = num;
    console.log(document.getElementById("std_name").value);
</script>
<script>
        let input0=document.getElementById("homework_name");
        input0.readOnly=true;
        var input = document.getElementById('std_name');
        input.readOnly = true;
        let input_num = document.getElementById('std_num');
        input_num.readOnly = true;
        //判断如果fileinput已选择文件，selecr_div中显示文件名
        let file_input = document.getElementById('select');
        let select_div = document.getElementById('select_');
        file_input.onchange = function () {
            select_div.innerHTML = "<p>已选择文件</p>";
        }
</script>
    // }
</script>
</body>
</html>
