<?php
include_once 'checkAdmin.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会员管理系统</title>
</head>
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
</style>

<body>
    <div class="main">
        <?php
        include_once 'nav.php';
        include_once  'conn.php';
        include_once  'page.php';
        $sql = "select count(id) as total from info";
        $result = mysqli_query($conn, $sql);
        $info = mysqli_fetch_array($result);
        $total = $info['total']; //得到记录总数
        $perPage = 2; //设置每一页显示多少条数据
        $page = $_GET['page'] ?? 1; //读取当前页码
        paging($total, $perPage);

        $sql = "select * from info order by id desc limit $firstCount,$displayPG";
        $result = mysqli_query($conn, $sql);
        
        ?>
        <table border="1" cellpadding="0" cellspacing="10" style="border-collapse: collapse" align="center" width="90%">
            <tr>
                <td>序号</td>
                <td>用户名</td>
                <td>性别</td>
                <td>信箱</td>
                <td>爱好</td>
                <td>是否管理员</td>
                <td>操作</td>
            </tr>
            <?php
            $i = ($page - 1) * $perPage + 1;
            while ($info = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $info['username']; ?></td>
                    <td><?php echo $info['sex'] ? '男' : '女'; ?></td>
                    <td><?php echo $info['email']; ?></td>
                    <td><?php echo $info['fav']; ?></td>
                    <td><?php echo $info['admin'] ? '是' : '否'; ?></td>
                    <td>删除会员 设置管理员</td>
                </tr>
            <?php
                $i++;
            }
            ?>
        </table>
        <?php
        echo $pageNav;
        ?>
    </div>
</body>

</html>