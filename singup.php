<?php
session_start();
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

        .green {
            color: green
        }

        .black {
            color: black
        }

        #loading {
            width: 20px;
            display: none;
            text-align:end;
        }
    </style>
</head>

<body>
    <div class="main">
        <?php include_once 'nav.php'; ?>
        <form action="postReg.php" method="post" onsubmit="return check()">
            <table align="center" border="1" style="border-collapse:collapse" cellpadding="10" cellspacing="0">
                <tr>
                    <td align="right">用户名</td>
                    <td align="left"><input name="username" onblur="checkUsername()"><span class='red'>*</span> <span id='usernameMsg'></span><img src="img/loading.gif" id="loading"></td>
                </tr>
                <tr>
                    <td align="right">密码</td>
                    <td align="left"><input type="password" name="pw"><span class='red'>*</span></td>
                </tr>
                <tr>
                    <td align="right">确认密码</td>
                    <td align="left"><input type="password" name="cpw"><span class='red'>*</span></td>
                </tr>
                <tr>
                    <td align="right">性别</td>
                    <td align="left">
                        <input type="radio" name="sex" checked value="1">男
                        <input type="radio" name="sex" value="0">女
                    </td>
                </tr>
                <tr>
                    <td align="right">邮箱</td>
                    <td align="left"><input type="text" name="email"></td>
                </tr>

                <tr>
                    <td align="right">爱好</td>
                    <td align="left">
                        <input type="checkbox" name="fav[]" value="听音乐">听音乐
                        <input type="checkbox" name="fav[]" value="玩游戏">玩游戏
                        <input type="checkbox" name="fav[]" value="踢足球">踢足球
                    </td>
                </tr>
                <tr>
                    <td align="right"><input type="submit" value="提交"></td>
                    <td align="left"><input type="reset" value="重置"></td>
                </tr>
            </table>

        </form>
    </div>
    <script src="https://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
    <script>
        function checkUsername() {

            let username = document.getElementsByName('username')[0].value.trim();
            let usernameReg = /^[a-zA-Z0-9]{3,10}$/;
            if (!usernameReg.test(username)) {
                alert('用户名必填,且111');
                $("#usernameMsg").text('');
                return false;
            }
            $.ajax({
                url: "checkUsername.php",
                type: 'post',
                dataType: 'json',
                data: {
                    username: username
                },
                beforeSend: function() {
                    $("#usernameMsg").text('');
                    $("#loading").show();
                },
                success: function(data) {
                    $("#loading").hide();
                    if (data.code == 0) {
                        //表明不可用
                        $("#usernameMsg").text(data.msg).removeClass('green').addClass('red');


                    } else if (data.code == 2) {
                        //表明可用
                        $("#usernameMsg").text(data.msg).removeClass('red').addClass('green');
                    }

                },
                error: function() {
                    $("#loading").hide();
                    alert('网络错误');
                }
            })
        }

        function check() {
            let username = document.getElementsByName('username')[0].value.trim();
            let pw = document.getElementsByName('pw')[0].value.trim();
            let cpw = document.getElementsByName('cpw')[0].value.trim();
            let email = document.getElementsByName('email')[0].value.trim();
            //用户名验证
            let usernameReg = /^[a-zA-Z0-9]{3,10}$/;
            if (!usernameReg.test(username)) {
                alert('用户名必填,且');
                return false;
            }
            let pwreg = /^[a-zA-Z0-9_*]{6,10}$/;
            if (!pwreg.test(pw)) {
                alert('密码必填,且');
                return false;
            } else {
                if (pw != cpw) {
                    alert('密码和确认密码必须相同');
                    return false;
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
</body>


</html>