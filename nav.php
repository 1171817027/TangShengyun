<style>
    .main{width: 80%;margin: 0 auto; text-align: center;}
    h2{font-size: 20px;}
    h2 a{color: navy; text-decoration: none; margin-right: 15px;}
    h2 a:last-child{margin-right: 0;}
    h2 a:hover{color: brown;text-decoration: underline;}
    .current{color: brown;}
    .logged{font-size: 16px;color: darkgreen }
    .logout{margin-left: 20px;margin-bottom: 15px;}
    .logout a{ color:cornflowerblue;text-decoration: none }
    .logout a:hover{text-decoration: underline}
</style>
 <h1>会员注册管理系统</h1>
        <?php
    if (isset($_SESSION['LoggedUsername'])&&$_SESSION['LoggedUsername']<>''){?>

        <div class="logged"><?php if ($_SESSION['isAdmin']){echo '欢迎管理员登录:';}else{echo '当前登录者';}; ?><?php echo $_SESSION['LoggedUsername'];?><span class="logout"><a href="logout.php">注销登陆</a> </span></div>
    <?php
    }
        $id=isset($_GET['id'])?$_GET['id']:1;

    ?>


        <h2>
            <a href="index.php?id=1" <?php if($id==1){?>class="current"<?php } ?>>首页</a>
            <a href="singup.php?id=2" <?php if($id==2){?>class="current"<?php } ?>>会员注册</a>
            <a href="login.php?id=3" <?php if($id==3){?>class="current"<?php } ?>>会员登陆</a>
            <a href="modify.php?id=4&source=member" <?php if($id==4){?>class="current"<?php } ?>>个人资料修改</a>
            <a href="admin.php?id=5" <?php if($id==5){?>class="current"<?php } ?>>后台管理</a>
        </h2>
