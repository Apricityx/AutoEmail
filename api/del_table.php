<?php
$table_name = $_GET["table_name"];
$passwd = file("../database_passwd")[0];
$servername = "pve.zwtsvx.xyz:1128";
$username = "root";
$password = $passwd;
$dbname = "autoemail";
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->query("DROP TABLE {$table_name}");
echo "删除表成功！";