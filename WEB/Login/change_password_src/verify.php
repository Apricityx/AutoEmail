<?php
$passwd = file("../../../database_passwd")[0];
$conn = new mysqli("pve.zwtsvx.xyz:1128", "root", $passwd, "autoemail");
if ($conn->connect_error) {
    die("连接失败：" . $conn->connect_error);
}
$std_num = $_POST["std_num"];
$std_old_passwd = $_POST["std_old_passwd"];
$std_new_passwd = $_POST["std_new_passwd"];
$sql = "select * from students where student_id = $std_num";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row["student_passwd"] == $std_old_passwd) {
        $sql = "update students set student_passwd = '$std_new_passwd' where student_id = $std_num";
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . $conn->error;
        }
        echo "密码修改成功！";
    } else {
        echo "原密码错误！";
    }
} else {
    echo "学号不存在！";
}