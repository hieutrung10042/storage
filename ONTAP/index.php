<?php include 'code.php'; ?>
<?php
    // Sử dụng hàm để lấy dữ liệu từ bảng
    if($conn)
    {
        $tableName ="user";
        $data = getTableData($conn,$tableName);
        //In dữ liệu
        //print_r($data);
    }
    else
    {
        echo " Kết nối đến cơ sở dữ liệu không thực hiện";
    }
    ?>
    <style>
        body
        {
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
        }
        table
        {
            width: 100%;
        }
        table, td, th
        {
            border: 1px solid;
            border-collapse: collapse;
        }
        thead
        {
            background-color: aqua;
        }
        .container
        {
            background-color: blanchedalmond;
        }
    </style>
<section id="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="box">
                <table border="1">
                    <thead>
                        <tr>
                            <th colspan="3">Bảng thông tin tài khoản</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td>ID</td>
                        <td>Username</td>
                        <td>Password</td>
                    <?php foreach($data as $user) { ?>
                        <tr>
                            <td><?php echo $user['ID'] ?></td>
                            <td><?php echo $user['Name'] ?></td>
                            <td><?php echo $user['Password'] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>    