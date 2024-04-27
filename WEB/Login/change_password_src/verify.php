<?php
$passwd = file("../../../database_passwd")[0];
$conn = new mysqli("pve.zwtsvx.xyz:1128", "root", $passwd, "autoemail");
if ($conn->connect_error) {
    die("连接失败：" . $conn->connect_error);
}
//echo json_encode($_POST);
$std_num = $_POST["std_num"];
//$std_num = 'admin';
$std_old_passwd = $_POST["std_old_passwd"];
$std_new_passwd = $_POST["std_new_passwd"];
if ($std_num == 'admin') {
    $admin_passwd_file = file("../login_src/admin_passwd")[0];
    $admin_passwd = $admin_passwd_file;
//    echo $admin_passwd;
    if ($admin_passwd == $std_old_passwd) {
        file_put_contents("../login_src/admin_passwd", $std_new_passwd);
        echo "<script>alert('密码修改成功！')
              window.location.href='../change_password_src/index.html';</script>";
        exit();
    } else {
        echo "<script>alert('原密码错误！')
              window.location.href='../change_password_src/index.html';</script>";
    }
}
//exit();
$sql = "select * from students where student_id = $std_num";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
    if ($row["passwd"] == $std_old_passwd) {
        $sql = "update students set passwd = '$std_new_passwd' where student_id = $std_num";
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . $conn->error;
        }
        echo "<script>alert('密码修改成功！')
              window.location.href='../change_password_src/index.html';</script>";
    } else {
        echo "<script>alert('原密码错误！')
              window.location.href='../change_password_src/index.html';</script>";
    }
} else {
    echo "<script>alert('学号不存在！')
              window.location.href='../change_password_src/index.html';</script>";
}