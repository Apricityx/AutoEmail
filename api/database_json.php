<?php
//allow chinese characters
header("Content-type: text/html; charset=utf-8");
$file = file('../database_passwd');
$pass = $file[0];
//echo $pass;
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
echo json_encode($tables);
$conn->close();
