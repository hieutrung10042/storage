<?php include 'header.php'; ?>
<?php include 'conn.php'; ?>
<?php
    // Sử dụng hàm để lấy dữ liệu từ bảng
    if($conn)
    {
        $tableName ="products";
        $data = getTableData($conn,$tableName);
        //In dữ liệu
        //print_r($data);
    }
    else
    {
        echo " Kết nối đến cơ sở dữ liệu không thực hiện";
    }
    ?>
    <section class="bg-info">
    <div class="container">
        <div class="row">
        <?php


// Sử dụng hàm để lấy dữ liệu từ bảng
if($conn)
{
    $tableName ="products";
    $query = "SELECT * FROM $tableName";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0) {
        // Bắt đầu vòng lặp while
        while ($row = mysqli_fetch_assoc($result)) {
?>
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <img src="./images/<?php echo $row['Thumb']; ?>" class="card-img-top" alt="">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['Product_Name']; ?></h5>
                        <p class="card-text">Price: <?php echo $row['Price']; ?></p>
                    </div>
                    <div class="modal-content">
      <div class="modal-footer">
        <input type="submit" class="btn btn-success" name="modal" value ="ADD"></input>
      </div>
      
    </div>
                </div>
            </div>
<?php
        } // Kết thúc vòng lặp while
    } else {
        echo "Không có dữ liệu sản phẩm.";
    }
} else {
    echo "Kết nối đến cơ sở dữ liệu không thành công.";
}
?>

