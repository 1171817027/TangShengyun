<?php
include_once 'checkAdmin.php';
$action = $_GET['action'];
$id=$_GET['id'];
if(is_numeric($action)&& is_numeric($id)){
    if($action==1||$action==0){
        $sql="update info set admin = $action where id =$id";
    }else{
        
        echo "<script>alert('参数错误');history.back();</scripy>";
        exit;
    }
    include_once 'conn.php';
    $result = mysqli_query($conn,$sql);
    if($action){
        $msg='设置管理员';

    }else{
        $msg='取消管理员';
    }
    if($result){
        echo "<script>alert('{$msg}成功');location.href='admin.php';</script>";
    }
    else{
        echo "<script>alert('{$msg}失败');history.back();</script>";
    }
}
else{
    //说明action和id不是数字
    echo "<script>alert('参数错误');history.back();</script>";
}