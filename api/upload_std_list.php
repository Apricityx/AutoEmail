<?php
$file = $_FILES['upload'];
echo "File uploaded successfully";
$name = $file['name'];
$lines = file($file['tmp_name']);
$data = array();
$if_ok = true;
// 判断文件中每一行是否都能被,分割成两部分
foreach ($lines as $line) {
    $parts = explode(',', $line);
    if (count($parts) != 2) {
        $if_ok = false;
        echo "上传失败，学生表格格式不正确！请保证只有两列，第一列为学号，第二列为姓名！";
        break;
    }
}
if ($if_ok) {
    if (!file_exists('temp')) {
        mkdir('temp', 0777, true);
    }
    move_uploaded_file($file['tmp_name'], '../std_data.csv');
    echo "学生表格上传成功！上传学生信息表后，请点击初始化数据库按钮加载学生信息。";
    echo "<a href='../WEB/Admin/index.php'>回到管理页面</a>";
}

