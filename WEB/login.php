<?php
$file = file("../database_passwd");
$pass = $file[0];
$servername = "pve.zwtsvx.xyz:1128";
$username = "root";
$password = $pass;
$dbname = "autoemail";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed:" . mysqli_connect_error());
}
//判断用户登录表单的用户名和密码是否正确，并将用户数据储存在cookie中
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "select * from students where student_id='$username' and passwd='$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "登录成功!WELCOME!";
    } else {
        echo "用户或密码错误！登录失败！";
    }
}
$conn->close();
?>