<?php
$std_num = $_GET["std_num"];
//$std_num = 222023321062106;
$passwd = file("../database_passwd")[0];
$servername = "pve.zwtsvx.xyz:1128";
$username = "root";
$password = $passwd;
$dbname = "autoemail";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo "连接失败数据库";
    die("连接失败: " . $conn->connect_error);
}
$result = $conn->query("SHOW TABLES")->fetch_all();
// 去掉students表
$tables = array();
foreach ($result as $key => $value) {
    if (json_encode($value) != '["students"]') {
        array_push($tables, $value);
    }
}
//echo json_encode($tables);
// 从所有表中查找学生信息
$out_data = array();
for ($i = 0; $i < count($tables); $i++) {
    $select_name = implode('', $tables[$i]);
//    echo "SELECT * FROM $select_name WHERE student_id = $std_num";
    $result = $conn->query("SELECT * FROM $select_name WHERE student_id = $std_num");
    while ($row = $result->fetch_assoc()) {
        $out_data[$select_name] = $row["if_finish"];
//        echo $row["if_finish"];
    }
}
echo json_encode($out_data,256);
//$sql = "SELECT * FROM $table_name WHERE student_id = $std_num";
