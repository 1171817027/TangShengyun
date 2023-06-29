<?php
header("Content-Type:text/html;charset=utf-8");
$username = trim($_POST['username']);
$pw = trim($_POST['pw']);
$cpw = trim($_POST["cpw"]);
$sex = $_POST['sex'];
$email = $_POST['email'];
$fav = @implode(",", $_POST["fav"]);

include_once "conn.php";

//进行必要的验证
if (!strlen($username) || !strlen($pw)) {
    echo "<script>alert('用户名和密码都必须要填写');history.back();</script>";
    exit;
}else{
    if(!preg_match('/^[a-zA-Z0-9]{3,10}$/',$pw)){
        echo "<script>alert('用户名必填,且');history.back();</script>";
        exit;
    }
}
if ($pw <> $cpw) {
    echo "<script>alert('密码和确认密码必须相同');history.back();</script>";
    exit;
} else {
    if (!preg_match('/^[a-zA-Z0-9_*]{6,10}$/', $pw)) {
        echo "<script>alert('密码必填,且只能大小写');history.back();</script>";
        exit;
    }
}
if(!empty($email)){
    if(!preg_match('/^[a-zA-Z0-9_\-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/',$email)){
        echo "<script>alert('信箱格式不正确');history.back();</script>";
        exit;
    }
}
//判断用户名是否重复(是否被占用)
$sql = "select * from info where username='$username'";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
if ($num) {
    echo "<script>alert('用户名已经被占用');history.back();</script>";
    exit;
}
//sql语句
$sql = "insert into info (username,pw,sex,email,fav,createtime) values ('$username','" . md5($pw) . "','$sex','$email','$fav','" . time() . "')";
$result = mysqli_query($conn, $sql);
if ($result) {
    echo "<script>alert('数据插入成功');location.href='index.php';</script>";
} else {
    echo "<script>alert('数据插入失败');history.back();</script>";
}
