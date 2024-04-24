<html>
<head>

</head>
<body>

</body>
<?php
$file = "./password_.txt";
$pass=file_get_contents($file);
$servername = "localhost";
$username = "root";
$password = $pass;
$dbname ="autoemail";
$conn = new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    die("Connection failed:".mysqli_connect_error());
}
//判断用户登录表单的用户名和密码是否正确，并将用户数据储存在cookie中
$sql0="select name from students where student_id=".$_POST['username'];
$result0=$conn->query($sql0);
$row0=$result0->fetch_assoc();
$name=$row0['name'];
setcookie("name",$name,time()+3600);

//$name=$_POST['student_id'];
//将学生姓名存入cookie
setcookie("name",$name,time()+3600);
if(isset($_POST['username'])&&isset($_POST['password'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $type=$_POST['type'];
    $sql="select * from students where student_id='$username' and passwd='$password'";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        setcookie("username",$username,time()+3600);
        //获得用户选择类型

//        $row=$result->fetch_assoc();
//        $type=$row['type'];
        if($type=='学生'){
            header("Location:User/index.html");
        }
        if($type=='管理员'){
            header("Location:Admin/index.html");
        }
//        setcookie("type",$type,time()+3600);
//        header("Location:User/index.html");
        echo "登录成功!WELCOME!";
    }else{
        echo "用户不存在，登录失败";
    }
}
$conn->close();
?>
<script>

    var type = "<?php echo $type?>";
    if(type==='管理员'){
        setTimeout(()=>{window.location.href = "Admin/index.html"
            },5000);
    }
    if(type==='学生'){
        setTimeout(()=>{window.location.href = "User/index.html"
            },5000);
    }

</script>
<!--<script>-->
    setTimeout(() => {
<!--        window.location.href = "User/login.php";-->
<!--    }, 5000);-->
<!--</script>-->
</html>
