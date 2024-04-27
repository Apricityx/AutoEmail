<?php
$passwd = file("../database_passwd")[0];
$servername = "localhost";
$username = "root";
$password = $passwd;
$conn = new mysqli($servername, $username, $password);

$sql = "DROP DATABASE IF EXISTS autoemail";
$conn->query($sql);
//echo $sql .'<br>';

$sql = "CREATE DATABASE autoemail";
//echo $sql .'<br>';
$conn->query($sql);

$sql = "USE autoemail";
//echo $sql .'<br>';
$conn->query($sql);
// DEBUGING....
//$table_name = 'test';
//$conn->query("DROP TABLE {$table_name}");
//
//exit();
if ($conn->connect_error) {
    echo "连接失败";
    die("连接失败: " . $conn->connect_error);
}
//"CREATE TABLE IF NOT EXISTS " + homework_name + " (student_id LONG,student_name VARCHAR(255), if_finish INT,submit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP )")
// 学生表
$sql = "CREATE TABLE IF NOT EXISTS students (student_id LONG,name VARCHAR(255), passwd VARCHAR(255),join_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP )";
//echo $sql .'<br>';
if ($conn->query($sql) === FALSE) {
    echo "创建表时出现问题：" . $conn->error;
}
// 作业表
$sql = "CREATE TABLE IF NOT EXISTS assignments (
    assignment_name VARCHAR(255),
    deadline TIMESTAMP,
    create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === FALSE) {
    echo "创建表时出现问题：" . $conn->error;
}

//从第二行开始，读取文件内容
$std = fopen("../std_data.csv", "r");
$flag = 0;
while (!feof($std)) {

    $line = fgetcsv($std);
    //获取student_id的后六位
    if ($flag < 1) {
        $flag += 1;
        continue;
    }
//    echo $line[0] . '<br>';
    $std_passwd = substr($line[0], -7);
//取前六位
    $std_passwd = substr($std_passwd, 0, 6);
//    echo $std_passwd . '<br>';
    // 去掉所有的空格
    $std_id = str_replace(' ', '', $line[0]);
    $std_name = str_replace(' ', '', $line[1]);

//    echo $std_id . '<br>';
//    echo $std_name . '<br>';
//    echo $std_passwd . '<br>';
    $sql = "INSERT INTO students (student_id, name, passwd) VALUES ('$std_id', '$std_name','$std_passwd')";
//    echo $sql .'<br>';

    if ($conn->query($sql) === FALSE) {
        echo "Error: " . $sql . $conn->error;
    }
}
echo "初始化完成！";