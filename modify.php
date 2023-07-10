<?php
session_start();
$source = $_GET['source'] ?? "";
$page = $_GET['page'] ?? '';
if (!$source or (($source <> 'admin') and ($source <> 'member'))) {
    echo "<script>alert('页面来源错误');location.href='index.php';</script>";
    exit;
}
if ($page) {
    if (!is_numeric($page)) {
        echo "<script>alert('参数错误');location.href='index.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会员管理系统</title>
    <style>
        .main {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }

        h2 {
            font-size: 20px;
        }

        h2 a {
            color: navy;
            text-decoration: none;
            margin-right: 15px;
        }

        h2 a:last-child {
            margin-right: 0;
        }

        h2 a:hover {
            color: brown;
            text-decoration: underline;
        }

        .current {
            color: brown;
        }

        .red {
            color: red
        }
    </style>
</head>

<body>
    <div class="main">
        <?php
        include_once 'nav.php';
        include_once 'conn.php';
        $username = $_GET['username'] ?? '';
        if ($username) { //说明有username参数,是管理员修改别人的资料
            $sql = "select * from info where username ='$username'";
        } else {
            @$sql = "select * from info where username='" . $_SESSION['LoggedUsername'] . "'";
        }

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)) {
            $info = mysqli_fetch_array($result);
            $fav = explode(",", $info['fav']);
        } else {
            die("未找到有效用户!");
        }
        ?>
        <form action="postModify.php" method="post" onsubmit="return check()">
            <table align="center" border="1" style="border-collapse:collapse" cellpadding="10" cellspacing="0">
                <tr>
                    <td align="right">用户名</td>
                    <td align="left"><input name="username" readonly value="<?php echo $info['username']; ?>"></td>
                </tr>
                <tr>
                    <td align="right">密码</td>
                    <td align="left"><input type="password" name="pw" placeholder="不修改密码请留空"></td>
                </tr>
                <tr>
                    <td align="right">确认密码</td>
                    <td align="left"><input type="password" name="cpw" placeholder="不修改密码请留空"></td>
                </tr>
                <tr>
                    <td align="right">性别</td>
                    <td align="left">
                        <input type="radio" name="sex" <?php if ($info['sex']) { ?> checked<?php } ?> value="1">男
                        <input type="radio" name="sex" <?php if (!$info['sex']) { ?> checked<?php } ?>value="0">女
                    </td>
                </tr>
                <tr>
                    <td align="right">邮箱</td>
                    <td align="left"><input type="text" name="email"></td>
                </tr>

                <tr>
                    <td align="right">爱好</td>
                    <td align="left">
                        <input type="checkbox" name="fav[]" <?php if (in_array('听音乐', $fav)) {
                                                                echo 'checked';
                                                            } ?> value="听音乐">听音乐
                        <input type="checkbox" name="fav[]" <?php if (in_array('玩游戏', $fav)) {
                                                                echo 'checked';
                                                            } ?> value="玩游戏">玩游戏
                        <input type="checkbox" name="fav[]" <?php if (in_array('踢足球', $fav)) {
                                                                echo 'checked';
                                                            } ?> value="踢足球">踢足球
                    </td>
                </tr>
                <tr>
                    <td align="right"><input type="submit" value="提交"></td>
                    <td align="left">
                        <input type="reset" value="重置">
                        <input type='hidden' name="source" value="<?php echo $source; ?>">
                        <input type='hidden' name="page" value="<?php echo $page; ?>">
                    </td>
                </tr>
            </table>

        </form>
    </div>

</body>
<script>
    function check() {

        let pw = document.getElementsByName('pw')[0].value.trim();
        let cpw = document.getElementsByName('cpw')[0].value.trim();
        let email = document.getElementsByName('email')[0].value.trim();

        let pwreg = /^[a-zA-Z0-9_*]{6,10}$/;
        if (pw.length > 0) {
            if (!pwreg.test(pw)) {

                alert('密码必填,且');
                return false;
            } else {
                if (pw != cpw) {
                    alert('密码和确认密码必须相同');
                    return false;
                }
            }
        }

        let emaiReg = /^[a-zA-Z0-9_\-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/;
        if (email.length > 0) {
            if (!emaiReg.test(email)) {
                alert('信箱格式不正确')
                return false;
            }
        }
        return true;
    }
</script>

</html>
