<!DOCTYPE html>
<html lang="zh_CN">
<head>
    <meta charset="UTF-8">
    <title>作业管理平台 - 提交作业</title>
</head>
<body>
<form action="receive.php" method="post" enctype="multipart/form-data">
    <label for="homework_name">请选择要提交的作业</label><select name="homework_name" id="homework_name" required>
        <option value="1">暂无作业</option>
    </select>
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
<?php
$passwd = file("../../database_passwd")[0];
$servername = "pve.zwtsvx.xyz:1128";
$username = "root";
$password = $passwd;
$dbname = "autoemail";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo "连接失败";
    die("连接失败: " . $conn->connect_error);
}
$sql = "SHOW tables";
$result = $conn->query($sql);
$tables = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tables[] = $row["Tables_in_autoemail"];
    }
} else {
    echo "0 结果";
}
$result = json_encode($tables);
$conn->close();
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
    for (let i = 0; i < tables.length; i++) {
        if (tables[i] === "students") {
            continue;
        }
        let option = document.createElement("option");
        option.value = tables[i];
        option.innerText = tables[i];
        homework_name.appendChild(option);
    }
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