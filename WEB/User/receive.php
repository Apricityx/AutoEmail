<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取POST请求中的文本数据
    $homework_name = isset($_POST['homework_name']) ? $_POST['homework_name'] : '';
    $std_name = isset($_POST['std_name']) ? $_POST['std_name'] : 'NONE';
    $std_num = isset($_POST['std_num']) ? $_POST['std_num'] : '';
    // 检查是否有文件被上传
    $file = $_FILES['file'];//获取文件

    // 您可以在这里添加文件验证和处理逻辑
    // 例如：检查文件大小、类型或保存到服务器的特定位置

    // 输出文件信息（仅作为示例）
//    echo "上传的文件名: " . $file['name'] . "<br>";
//    echo "文件类型: " . $file['type'] . "<br>";
//    echo "文件大小: " . $file['size'] . "<br>";
    $file_name = "上传的文件名:  ".$file['name'];
    $file_type = "文件类型:  ".$file['type'];
    $file_size = "文件大小:  ".$file['size'];
    // 处理其他数据（例如：保存到数据库或发送电子邮件）
    // ...

    // 输出接收到的文本数据（仅作为示例）
//    echo "接收到的table: " . $homework_name . "<br>";
//    echo "接收到的名字: " . $std_name . "<br>";
//    echo "接收到的学号: " . $std_num;
    $table = "作业名:  " . $homework_name;
    $name = "学生姓名:  " . $std_name;
    $num = "学生学号:  " . $std_num;

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
    $conn->query("UPDATE $homework_name SET if_finish = 1 WHERE student_id = $std_num");
    // 将文件保存到./homework/$homework_name/目录下
    if (!file_exists('homework')) {
        mkdir('homework', 0777, true);
    }
    if (!file_exists('homework/' . $homework_name)) {
        mkdir('homework/' . $homework_name, 0777, true);
    }
    move_uploaded_file($file['tmp_name'], 'homework/' . $homework_name . '/' . $std_name . '_' . $std_num . '_' . $file['name']);
}
?>
<html>
<head>
    <title>提交成功</title>
    <link rel="stylesheet" type="text/css" href="user_src/receive.css">
</head>
<body>
<div id="main">
    <div class="left"></div>
    <div id="title" class="left">
        <div>
        <h1>作业提交成功!</h1>
        </div>
        <div>
        <p>请检查作业提交信息是否有误，如若有误，请重新提交，点击按钮返回上一页面</p>
        </div>
        <div>
            <button onclick="window.history.back()">返回</button>
        </div>
    </div>
    <div id="content">
        <div id="receive_box">
            <div class="receive_text">
                <p><?php echo $table; ?></p>
            </div >
            <div class="receive_text">
                <p><?php echo $name; ?></p>
            </div>
            <div class="receive_text">
                <p><?php echo $num; ?></p>
            </div>
            <div class="receive_text">
                <p><?php echo $file_name; ?></p>
            </div>
            <div class="receive_text">
                <p><?php echo $file_type; ?></p>
            </div>
            <div class="receive_text">
                <p><?php echo $file_size; ?></p>
            </div>
        </div>
    </div>
    <div class="left" style="grid-row: 3/4"></div>
</body>
</html>
<script>

 //如果未获取文件，显示重新提交
    if (<?php echo $file['size']; ?> == 0) {
     document.getElementById("title").innerHTML = "<h1>提交失败!</h1>";
        document.getElementById("title").innerHTML += "<p>请检查是否选择文件提交或当前网络是否良好，5秒后将自动返回上一页面，请重新提交</p>";
        document.getElementById("receive_box").innerHTML = "<h2 style='margin-left: 250px'>未获取数据，请重新提交</h2>";
        setTimeout(function () {
            window.history.back();
        }, 5000);
    }


    
</script>