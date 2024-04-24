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
if(isset($_POST['username'])&&isset($_POST['password'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $type=$_POST['type'];
    $sql0="select name from students where student_id='$username'";
    $result0=$conn->query($sql0);//获取学生姓名
    $row0=$result0->fetch_assoc();//获取学生姓名
    $sql="select * from students where student_id='$username' and passwd='$password'";//查询用户是否存在
    $result=$conn->query($sql);
    if($result->num_rows>0&&$row0['name']!=null){
        $name="name!".$row0['name']."!name";
        $num="num!".$username."!num";
        setcookie("name",$name,time()+3600);
        setcookie("username",$num,time()+3600);
        if($type=='student'){
            header("Location:../User/index.html");
            echo "登录成功!WELCOME!";
        }
        if($type=='admin'){
            header("Location:../Admin/index.html");
        }

        echo "登录成功!WELCOME!";
    }else{
        echo "用户不存在，登录失败";
    }
}
$conn->close();
?>
<script>
    console.log(document.cookie);
</script>