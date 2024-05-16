<?php
include 'conn.php';

// Kết nối đến cơ sở dữ liệu
if($conn) {
    // Truy vấn SQL để lấy dữ liệu của sản phẩm đầu tiên
    $query = "SELECT image_path FROM products LIMIT 1"; // Lấy sản phẩm đầu tiên trong bảng products
    $result = mysqli_query($conn, $query);
    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = $row['image_path'];
        // Hiển thị hình ảnh trong thẻ <img>
        echo '<img src="' . $imagePath . '" alt="Product Image">';
    } else {
        echo "Không tìm thấy hình ảnh sản phẩm.";
    }
} else {
    echo "Kết nối đến cơ sở dữ liệu không thành công.";
}
?>
