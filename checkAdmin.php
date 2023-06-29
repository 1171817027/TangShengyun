<?php
//首先判断是不是管理员
session_start();
if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']){
    //说明isAdmin不存在或者存在,但值为假
    echo"<script>alert('请以管理员身份登陆后访问本页面');location.href='login.php';</script>";
    exit;
}
