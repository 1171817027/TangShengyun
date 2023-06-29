<?php
session_start();

$username = trim($_POST['username']);
$pw = trim($_POST['pw']);

//进行必要的验证
$code = $_POST['code'];
//判断验证码
if (strtolower($_SESSION['captcha'])==strtolower($code)) {
    $_SESSION['captcha']='';
}
else{
    $_SESSION['captcha']='';
    echo"<script>alert('验证码错误');location.href='login.php?id=3';</script>";
    exit;
}
if (!strlen($username) || !strlen($pw)) {
    echo "<script>alert('用户名和密码都必须要填写');history.back();</script>";
    exit;
}else{
    if(!preg_match('/^[a-zA-Z0-9]{3,10}$/',$pw)){
        echo "<script>alert('用户名必填,且');history.back();</script>";
        exit;
    }
    if (!preg_match('/^[a-zA-Z0-9_*]{6,10}$/', $pw)) {
        echo "<script>alert('密码必填,且只能大小写');history.back();</script>";
        exit;
    }
}
include_once "conn.php";
$sql ="select * from info where username ='$username' and  pw ='".md5($pw)."'";
$result = mysqli_query($conn,$sql);
$num = mysqli_num_rows($result);
if ($num){

    $_SESSION['LoggedUsername']=$username ;
    //判断是不是管理员
    $info=mysqli_fetch_array($result);
    if ($info['admin']){
        $_SESSION['isAdmin']=1;
    }
    else{
        $_SESSION['isAdmin']=0;

    }
    echo "<script>alert('登陆成功');location.href='index.php';</script>";
}
else{
    unset($_SESSION['isAdmin']);
    unset($_SESSION['LoggedUsername']);
    echo "<script>alert('登陆失败');history.back();</script>";
}
