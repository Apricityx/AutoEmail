<!DOCTYPE html>
<?php
//allow chinese characters
header("Content-type: text/html; charset=utf-8");
$file = file('../../database_passwd');
$pass = $file[0];
$servername = "pve.zwtsvx.xyz:1128";
$username = "root";
$password = $pass;
$dbname = "autoemail";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("连接失败：" . $conn->connect_error);
}
//读取所有的表，将数据库中所有的表以及表中的内容转换为json格式
$sql = "show tables";
$result = $conn->query($sql);
$tables = array();//存放表名和表中的内容
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $table = $row['Tables_in_autoemail'];//表名
        if ($table == 'students') {
            continue;//跳过student表
        }
        $sql = "select * from $table";
        $result2 = $conn->query($sql);
        $rows = array();
        if ($result2->num_rows > 0) {
            while ($row2 = $result2->fetch_assoc()) {
                $rows[] = $row2;
            }
        }
        $tables[$table] = $rows;
    }

}
$conn->close();
$data = json_encode($tables);
?>
<html lang="zh_CN">
<head>
    <meta charset="UTF-8">
    <title>作业管理平台 - 管理员</title>
    <link rel="stylesheet" href="./index.css">
</head>
<body>
<div id="main">
    <div id="top">
        <h1 style="text-align: center">作业管理平台 - 管理员</h1>
    </div>
    <div id="bottom">
        <div id="left">
            <div id="search_container"></div>
            <div id="table_information"></div>
        </div>
        <div id="right">
            <div id="control_table">
                <button style="color: red" onclick="">初始化数据库</button>
                <button onclick="">创建作业</button>
                <button>上传学生名单</button>
            </div>
            <div id="detailed_information">
                <div class="single_std">
                    <div class="std_num">学生学号</div>
                    <div class="std_name">学生姓名</div>
                    <div class="std_status">提交情况</div>
                    <div class="std_time">提交时间</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--向服务端发送请求-->
<!--服务端返回：表名（作业名） -> 名字（学生名） -> 作业内容（作业内容） -> 作业状态（是否提交） -> 提交时间（提交时间）-->
</body>
</html>

<script>
    function reset_color() {
        let tables = document.getElementsByClassName("table");
        for (let i = 0; i < tables.length; i++) {
            tables[i].style.backgroundColor = "white";
        }
    }

    let data = <?php echo $data; ?>;
    console.log(data);
    let table_container = document.getElementById("table_information");
    let detailed_information = document.getElementById("detailed_information");
    for (let table in data) {
        let table_div = document.createElement("div");
        table_div.className = "table";
        table_div.innerHTML = table;
        table_div.onclick = function () {
            reset_color();
            table_div.style.backgroundColor = "lightblue";
            detailed_information.innerHTML = `
<div class="single_std">
                    <div class="std_num">学生学号</div>
                    <div class="std_name">学生姓名</div>
                    <div class="std_status">提交情况</div>
                    <div class="std_time">提交时间</div>
                </div>`;
            for (let i = 0; i < data[table].length; i++) {
                let single_std = document.createElement("div");
                single_std.className = "single_std";
                let std_num = document.createElement("div");
                std_num.className = "std_num";
                std_num.innerHTML = data[table][i]["student_id"];
                let std_name = document.createElement("div");
                std_name.className = "std_name";
                std_name.innerHTML = data[table][i]["student_name"];
                let std_status = document.createElement("div");
                std_status.className = "std_status";
                std_status.innerHTML = data[table][i]["if_finish"] === '1' ? "已提交" : "未提交";
                let std_time = document.createElement("div");
                std_time.className = "std_time";
                std_time.innerHTML = data[table][i]["if_finish"] === '1' ? data[table][i]["submit_time"] : "N/A";
                single_std.appendChild(std_num);
                single_std.appendChild(std_name);
                single_std.appendChild(std_status);
                single_std.appendChild(std_time);
                detailed_information.appendChild(single_std);
            }
        }
        table_container.appendChild(table_div);
    }
</script>