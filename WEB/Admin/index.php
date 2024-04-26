<!DOCTYPE html>
<?php
// 验证是否登录
//echo $_COOKIE["admin"];
if ($_COOKIE["login_type"] != "admin") {
    header("Location:../Login/login.html");
}
?>
<?php
//allow chinese characters
//header("Content-type: text/html; charset=utf-8");
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
        if ($table == 'students' || $table == 'assignments') {
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>作业管理平台 - 管理员</title>
    <link rel="stylesheet" href="./index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div id="main">
    <!-- <div id="top">
        <h1 style="text-align: center">作业管理平台 - 管理员</h1>
    </div> -->
    <div id="bottom" class="container-fluid">
        <div class="row">
            <div id="left" class="col-2">
                <div class="logo">
                    <p style="flex:">作业管理平台</p>
                </div>
                <!-- <div id="search_container"></div> -->
                <!-- <ul class="menu menu-items shadow">
                    <li class="menu-items" style="padding-left: 24px;">
                        Chem
                    </li>
                    <li class="menu-items" style="padding-left: 24px;">
                        Chn
                    </li>
                    <li class="menu-items" style="padding-left: 24px;">
                        Math
                    </li>
                </ul> -->
                <div class="list-group" id="list-tab" role="tablist">
                    <!--                    <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list"-->
                    <!--                       href="#chem" role="tab" aria-controls="list-home">Chem</a>-->
                    <!--                    <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list"-->
                    <!--                       href="#chinese" role="tab" aria-controls="list-profile">Chn</a>-->
                    <!--                    <a class="list-group-item list-group-item-action" id="list-messages-list" data-bs-toggle="list"-->
                    <!--                       href="#math" role="tab" aria-controls="list-messages">Math</a>-->
                </div>
                <hr/>
                <button type="button" class="btn btn-secondary btn-sm" onclick="logout()"><i class="bi bi-escape"></i>
                    退出账号
                </button>
                <div id="table_information"></div>
            </div>
            <div id="right" class="col-10" style="padding: 0 0 0 1em;background-color: #f0f2f5;">
                <div id="control_table" class="gap-2 d-md-block buttonmodule">
                    <button class="btn btn-danger" style="" onclick="init()"><i class="bi bi-arrow-clockwise"></i>
                        初始化数据库
                    </button>
                    <button class="btn btn-primary" onclick="new_table()"><i class="bi bi-plus-square"></i> 创建作业
                    </button>
                    <button class="btn btn-danger" onclick="del_table()"><i class="bi bi-trash3"></i> 删除作业</button>
                    <button class="btn btn-primary"><i class="bi bi-cloud-upload"></i> 上传名单</button>
                </div>
                <div id="detailed_information" class="sheetmodule">
                    <div class="single_std" style="background-color: #fff;">
                        <div class="std_num">学生学号</div>
                        <div class="std_name">学生姓名</div>
                        <div class="std_status">提交情况</div>
                        <div class="std_time">提交时间</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
<!--向服务端发送请求-->
<!--服务端返回：表名（作业名） -> 名字（学生名） -> 作业内容（作业内容） -> 作业状态（是否提交） -> 提交时间（提交时间）-->
</body>
</html>

<script>
    var table_selected = null;

    function reset_color() {
        let tables = document.getElementsByClassName("table");
        for (let i = 0; i < tables.length; i++) {
            tables[i].style.backgroundColor = "white";
        }
    }

    let data = <?php echo $data; ?>;
    // console.log(data);
    let table_container = document.getElementById("table_information");
    let detailed_information = document.getElementById("detailed_information");
    for (let table in data) {
        // console.log('开始加载')
        let table_div = document.createElement("a");
        table_div.className = "list-group-item list-group-item-action";
        table_div.id = "list-home-list";
        table_div.setAttribute('data-bs-toggle', 'list');
        table_div.role = 'tab';
        table_div.setAttribute('aria-controls', 'list-home');
        table_div.innerHTML = table;
        table_div.onclick = function () {
            table_selected = table;
            reset_color();
            // table_div.style.backgroundColor = "lightblue";
            table_div.className = "list-group-item list-group-item-action active"
            // idk whats going on with that lightblue
            // active is a RULE
            // but not picking a color

            // but how to reverse?

            //all in all codes arent examined
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
        document.getElementById('list-tab').appendChild(table_div);
    }
</script>
<script>
    // 实现按钮的功能
    function new_table() {
        let table_name = prompt("请输入新建作业名");
        if (table_name === "") {
            window.alert("作业名不能为空");
        } else if (table_name === null) {
            window.alert("作业名不能为空")
        } else if (table_name.match(/\d+/g) !== null) {
            window.alert("作业名不能包含数字！");
        }
        //作业名不能重名
        else if (data[table_name] !== undefined) {
            window.alert("作业名已存在！");
        }
        //作业名不能包含空格
        else if (table_name.match(/\s+/g) !== null) {
            window.alert("作业名不能包含空格！");
        }
        //作业名不能包含特殊字符
        else if (table_name.match(/[^a-zA-Z0-9\u4e00-\u9fa5]/g) !== null) {
            window.alert("作业名不能包含特殊字符！");
        } else {
            // console.log(table_name)
            // 判断时间是否合法
            let year = prompt("请输入截止年份");
            let time = new Date();
            // console.log(time.getFullYear());
            year = parseInt(year);
            if (year < time.getFullYear()) {
                window.alert("年份输入有误！");
                return;
            }

            let month = prompt("请输入截止月份");
            month = parseInt(month);
            if (typeof month !== "number" || month < 1 || month > 12) {
                window.alert("月份输入有误！");
                return;
            }
            let day = prompt("请输入截止日期");
            day = parseInt(day);
            if (typeof day !== "number" || day < 1 || day > 31) {
                window.alert("日期输入有误！");
                return;
            }
            let hour = prompt("请输入截止小时");
            hour = parseInt(hour);
            if (typeof hour !== "number" || hour < 0 || hour > 23) {
                window.alert("小时输入有误！");
                return;
            }
            let minute = prompt("请输入截止分钟");
            minute = parseInt(minute);
            if (typeof minute !== "number" || minute < 0 || minute > 59) {
                window.alert("分钟输入有误！");
                return;
            }
            let deadline = `${year}-${month}-${day} ${hour}:${minute}:00`;
            let xhr = new XMLHttpRequest();
            xhr.open("GET", `../../api/create_table.php?table_name=${table_name}&deadline=${deadline}`);
            xhr.send();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    window.location.reload();
                }
            }
        }
    }

    function del_table() {
        if (table_selected === null) {
            alert("请选择一个作业！");
            return;
        }
        let table_name = table_selected;
        // console.log(table_selected);
        let xhr = new XMLHttpRequest();
        xhr.open("GET", `../../api/del_table.php?table_name=${table_name}`);
        xhr.send();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText);
                window.location.reload();
            }
        }
    }

    function logout() {
        document.cookie = "name=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "num=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "login_type=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        window.location.href = "../Login/login.html";
    }

    function init() {
        let is_confirm = confirm("确认初始化数据库?");
        console.log(is_confirm);
        if (is_confirm) {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "../../api/database_init.php");
            xhr.send();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    window.location.reload();
                }
            }
        }
    }
</script>
