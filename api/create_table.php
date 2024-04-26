<?php
$table_name = $_GET["table_name"];
$deadline = $_GET["deadline"];
$passwd = file("../database_passwd")[0];
$servername = "pve.zwtsvx.xyz:1128";
$username = "root";
$password = $passwd;
$dbname = "autoemail";
$conn = new mysqli($servername, $username, $password, $dbname);

// DEBUGING....
//$table_name = 'test';
//$conn->query("DROP TABLE {$table_name}");
//

if ($conn->connect_error) {
    echo "连接失败";
    die("连接失败: " . $conn->connect_error);
}
//"CREATE TABLE IF NOT EXISTS " + homework_name + " (student_id LONG,student_name VARCHAR(255), if_finish INT,submit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP )")
$sql = "CREATE TABLE IF NOT EXISTS $table_name (student_id LONG,student_name VARCHAR(255), if_finish INT,submit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP )";
if ($conn->query($sql) === FALSE) {
    echo "创建表时出现问题：" . $conn->error;
}
// 插入作业表
$sql = "INSERT INTO assignments (assignment_name, deadline) VALUES ('$table_name', '$deadline')";
//从第二行开始，读取文件内容
$std = fopen("../std_data.csv", "r");
$flag = 1;
while (!feof($std)) {

    $line = fgetcsv($std);
    $sql = "INSERT INTO $table_name (student_id, student_name, if_finish) VALUES ('$line[0]', '$line[1]', 0)";
    if ($flag == 1) {
        $flag = 0;
        continue;
    }
    if ($conn->query($sql) === FALSE) {
        echo "Error: " . $sql . $conn->error;
    }
}
echo "新作业已创建！";