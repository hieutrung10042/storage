<?php
include 'header.php';
include "D8.php";
include "code.php";

if ($conn) {
    //Kết nối đến cơ sở dữ liệu đã có
    $tableName = "user";
    $data = getTableData($conn, $tableName);
    //In ra dữ liệu
    // print_r($data);
} else {
    echo "Kết nối đến cơ sở dữ liệu không thành công";
}
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Danh sách user</h3>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>USER_ID</th>
                <th>USER_NAME</th>
                <th>PASSWORD</th>
                <th>CHỈNH SỬA</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $us) : ?>
                <tr>
                    <td><?php echo $us['ID']; ?></td>
                    <td><?php echo $us['USERNAME']; ?></td>
                    <td><?php echo $us['PASSWORD']; ?></td>
                    <td>
                        <a href="sua_user.php?id=<?php echo $us['ID']; ?>" class="btn btn-xs btn-primary">Sửa</a>
                        <a href="xoa_user.php?id=<?php echo $us['ID']; ?>" class="btn btn-xs btn-danger">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include "footer.php" ?>
