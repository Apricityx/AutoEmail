<?php
$table_name = $_GET["table_name"];
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
//"CREATE TABLE IF NOT EXISTS " + homework_name + " (student_id LONG,student_name VARCHAR(255), if_finish INT,submit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP )")
$sql = "CREATE TABLE IF NOT EXISTS $table_name (student_id LONG,student_name VARCHAR(255), if_finish INT,submit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP )";
if ($conn->query($sql) === TRUE) {
    echo "Table $table_name created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}