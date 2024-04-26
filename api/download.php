<?php
$table_name = $_GET['table_name'];
$sourceDir = '../User/homework/' . $table_name;
// 压缩后的 zip 文件名
$zipFileName = '../User/homework/download.zip';

// 创建一个新的 zip 文件
$zip = new ZipArchive();
if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
    // 遍历目录中的所有文件
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($sourceDir));
    foreach ($iterator as $file) {
        if (!$file->isDir()) {
            // 获取文件的相对路径
            $relativePath = substr($file, strlen($sourceDir) + 1);
            // 将文件添加到 zip 中
            $zip->addFile($file, $relativePath);
        }
    }
    // 关闭 zip 文件
    $zip->close();
} else {
    echo "无法创建 zip 文件";
}
echo '下载完成';
