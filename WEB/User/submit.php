<!DOCTYPE html>
<html lang="zh_CN">
<head>
    <meta charset="UTF-8">
    <title>作业管理平台 - 提交作业</title>
    <link rel="stylesheet" href="user_src/receive.css">
</head>
<body>
<div id="main">
    <div id="title">
        <h1>提交作业</h1>
    </div>
    <div id="content">
<form  id="S_W" action="receive.php" method="post" enctype="multipart/form-data">
    <label for="homework_name"></label><input name="homework_name" id="homework_name" required>
    </input>
    <br>
    <label id="std_name_label">
        <input name="std_name" type="text" id="std_name">
    </label>
    <br>
    <label id="std_num_label">
        <input name="std_num" type="text" id="std_num">
    </label>
    <br>
    <input type="file" name="file">
    <br>
    <input type="submit" value="提交">
</form>
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
</body>
</html>
