<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取POST请求中的文本数据
    $homework_name = isset($_POST['homework_name']) ? $_POST['homework_name'] : '';
    $std_name = isset($_POST['std_name']) ? $_POST['std_name'] : 'NONE';
    $std_num = isset($_POST['std_num']) ? $_POST['std_num'] : '';
    // 检查是否有文件被上传
    $file = $_FILES['file'];

    // 您可以在这里添加文件验证和处理逻辑
    // 例如：检查文件大小、类型或保存到服务器的特定位置

    // 输出文件信息（仅作为示例）
    echo "上传的文件名: " . $file['name'] . "<br>";
    echo "文件类型: " . $file['type'] . "<br>";
    echo "文件大小: " . $file['size'] . "<br>";

    // 处理其他数据（例如：保存到数据库或发送电子邮件）
    // ...

    // 输出接收到的文本数据（仅作为示例）
    echo "接收到的table: " . $homework_name . "<br>";
    echo "接收到的名字: " . $std_name . "<br>";
    echo "接收到的学号: " . $std_num;
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
    <title></title>
    <link rel="stylesheet" type="text/css" href="user_src/receive.css">
</head>
<body>
</body>
</html>