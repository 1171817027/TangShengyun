<?php
//连接数据库服务器
//第一步,链接数据库服务器
$conn = mysqli_connect("localhost", "root", "", "member");
if (!$conn) {
    die("连接数据库服务器失败");
}
//第二部,设置字符集
mysqli_query($conn, "set names utf8");