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
//        echo "登录成功!WELCOME!";
        setcookie("login_type", "admin", time() + (86400 * 30), "/");
        header("refresh:3;url=../Admin/index.php");
    } else {
//        $flag = 0;
//        echo "用户名或密码错误，将在3秒后返回登录页面";
        header("refresh:3;url=../Login/login.html");
    }
} else {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $if_remember = isset($_POST['save']);
        $sql0 = "select name from students where student_id='$username'";
        $result0 = $conn->query($sql0);//获取学生姓名
        $row0 = $result0->fetch_assoc();//获取学生姓名
        $sql = "select * from students where student_id='$username' and passwd='$password'";//查询用户是否存在
//        echo $sql;
        $result = $conn->query($sql);
        $num = $username;
        if ($result->num_rows > 0 && $row0['name'] != null) {
            $name = $row0['name'];
            $flag = 1;
            if ($type == 'student') {
                setcookie("name", $name, time() + 3600, "/", 256);
                setcookie("num", $num, time() + 3600, "/");
//                echo "登录成功!WELCOME!";
                header("refresh:3;url=../User/index.html");
            }
        } else {
            $flag = 0;
//            echo "用户名或密码错误，将在3秒后返回登录页面";
            header("refresh:3;url=../Login/login.html");
        }
    }
}

$conn->close();
?>
<html>
<head>
    <title>加载中.....</title>
    <link rel="stylesheet" type="text/css" href="./login_src/verify_.css">
</head>

<body>
<div id="main">

    <div id="show">
        <div id="content">

            <div class="show">
                <h1 class="typing">欢迎登录电子作业管理平台！</h1>
            </div>
            <div class="pacMan">
                <div class="eye"></div>
                <div class="mouth1"></div>
                <div class="mouth2"></div>
                <div class="beanOne"></div>
                <div class="beanTwo"></div>
                <div class="beanThree"></div>
                <div class="beanFour"></div>
                <div class="beanFive"></div>
            </div>
            <div class="tran">
                <h2>正在加载中...请耐心等待</h2>
            </div>
        </div>
    </div>


</div>

</body>

<script>
    let name = `<?php echo $name?>`;
    let num = `<?php echo $num?>`;
    console.log(name);
    let flag = `<?php echo $flag?>`;
    console.log(flag);
    if ((flag === "1") {
        // 登陆成功
        //清除cookie
        // document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
        // document.cookie = "cookieName=; path=/;";
        console.log("ok")
        console.log("setting_cookies:" + "name=" + name + ";expires=Thu, 18 Dec 2043 12:00:00 GMT; path=/")
        console.log("setting_cookies:" + "name=" + name + ";expires=Thu, 18 Dec 2043 12:00:00 GMT; path=/")
        document.cookie = "name=" + name + "; path=/";
        document.cookie = "login_type=" + "student" + "; path=/";
        document.cookie = "num=" + num + "; path=/";
    }else{
        console.log("no");
        document.getElementsByClassName("show")[0].innerHTML = "<div><h1 style='font-size: 34px'>用户名或密码错误，将在3秒后返回登录页面</h1><h2>温馨提示:请确保您选择的类型正确</div>";
        // 登陆失败
    }
</script>

<script>
    let if_remember = `<?php echo $if_remember?>`;
    console.log(if_remember);
    console.log(num);
    if_remember = parseInt(if_remember)
    if (if_remember) {
        console.log("set_cookie");
        document.cookie = "account=" + num + "; path=/";
        document.cookie = "remember=" + if_remember + "; path=/";
    } else {
        document.cookie = "account=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
        document.cookie = "remember=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
    console.log(document.cookie);
</script>
</html>