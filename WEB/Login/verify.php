<?php
$file = file('../../database_passwd');
$pass = $file[0];
$servername = "pve.zwtsvx.xyz:1128";
$username = "root";
$password = $pass;
$dbname = "autoemail";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed:" . mysqli_connect_error());
}
$type = $_POST['type'];
if ($type == 'admin') {
    $admin_passwd = file('login_src/admin_passwd')[0];
    if ($_POST['username'] == 'admin' && $_POST['password'] == $admin_passwd) {
        header("Location:../Admin/index.php");
        echo "登录成功!WELCOME!";
    } else {
        echo "用户名或密码错误，将在3秒后返回登录页面";
        header("refresh:3;url=../Login/Login.html");
    }
} else {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql0 = "select name from students where student_id='$username'";
        $result0 = $conn->query($sql0);//获取学生姓名
        $row0 = $result0->fetch_assoc();//获取学生姓名
        $sql = "select * from students where student_id='$username' and passwd='$password'";//查询用户是否存在
        $result = $conn->query($sql);
        if ($result->num_rows > 0 && $row0['name'] != null) {
            $name = $row0['name'];
            $num = $username;
            $flag = 1;
            if ($type == 'student') {
                setcookie("name", $name, time() + 3600, "/",256);
                setcookie("num", $num, time() + 3600, "/");
                echo "登录成功!WELCOME!";
                header("Location:../User/index.html");
            }
        } else {
            $flag = 0;
            echo "用户名或密码错误，将在3秒后返回登录页面";
            header("refresh:3;url=../Login/Login.html");
        }
    }
}

$conn->close();
?>
<script>
    let name = `<?php echo $name?>`;
    let num = `<?php echo $num?>`;
    // console.log(name);
    let flag = `<?php echo $flag?>`;
    if (flag === "1") {
        // 登陆成功
        //清除cookie
        // document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
        // document.cookie="username=John Smith; expires=Thu, 18 Dec 2043 12:00:00 GMT; path=/";
        // document.cookie = "cookieName=; path=/;";
        console.log("ok")
        console.log("setting_cookies:" + "name=" + name + ";expires=Thu, 18 Dec 2043 12:00:00 GMT; path=/")
        document.cookie = "name=" + name + "; path=/";
        document.cookie = "num=" + num + "; path=/";
    } else {
        console.log("no")
        // 登陆失败
    }
    console.log(document.cookie);
</script>