<?php
$file = $_FILES['upload'];
echo "File uploaded successfully";
$name = $file['name'];
$lines = file($file['tmp_name']);
$data = array();
// 判断文件中每一行是否都能被,分割成两部分

if (!file_exists('temp')) {
    mkdir('temp', 0777, true);
}
move_uploaded_file($file['tmp_name'], 'temp/' . $file['name']);

