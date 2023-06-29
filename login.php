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

        .none {
            width: 15px;
            display: none;
        }
    </style>
</head>

<body>
    <div class="main">
        <?php include_once 'nav.php' ?>
        <form action="postLogin.php" method="post" onsubmit="return check()">
            <table align="center" border="1" style="border-collapse:collapse" cellpadding="10" cellspacing="0">
                <tr>
                    <td align="right">用户名</td>
                    <td align="left"><input name="username" id="username" id="username" onblur="checkUsername()"><span class='red'>*</span><img src="img/x0.png" id="x0" class="none">
                        <img src="img/x1.png" id="x1" class="none">
                    </td>
                </tr>
                <tr>
                    <td align="right">密码</td>
                    <td align="left"><input type="password" name="pw"><span class='red'>*</span>

                    </td>
                </tr>
                <tr>
                    <td align="right">验证码</td>
                    <td align="left"><input name="code" placeholder="请输入图片中的验证码"><img src="code.php" style="cursor:pointer" onclick="this.src='code.php?'+new Date().getTime();" width="100" height="35"><span class='red'>*</span>

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
            let username = $("#username").val().trim();
            if (username.length == 0) {
                $("#x0").hide();
                $("#x1").hide();
                return;
            } else {
                let usernameReg = /^[a-zA-Z0-9]{3,10}$/;
                if (!usernameReg.test(username)) {
                    alert('用户名只能由大小写字符和数字构成,长度为3到10个字符!');
                    return;
                }
                $.ajax({
                    url: 'checkUsername.php',
                    type: "post",
                    dataType: 'json',
                    data: {
                        username: username
                    },
                    success: function(d) {
                        if (d.code == 0) {
                            $("#x0").hide();
                            $("#x1").show();
                        } else if (d.code == 2) {
                            $("#x0").show();
                            $("#x1").hide();
                        }

                    },
                    error: function() {
                        $("#x0").show();
                        $("#x1").hide();

                    }
                })
            }
        }

        function check() {
            let username = document.getElementsByName('username')[0].value.trim();
            let pw = document.getElementsByName('pw')[0].value.trim();

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
            }
            let code = document.getElementsByName('code')[0].value.trim();
            let codeReg = /^[a-zA-Z0-9]{4}$/;
            if (!codeReg.test(code)) {
                alert('验证码必填,且');
                return false;
            }

            return true;
        }
    </script>
</body>


</html>