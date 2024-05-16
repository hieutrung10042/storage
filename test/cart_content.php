<?php
session_start();

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['action']) && $_GET['action'] == "remove" && isset($_GET['id'])) {
    $remove_id = $_GET['id'];
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['id'] == $remove_id) {
            unset($_SESSION['cart'][$key]);
            echo json_encode(["success" => true]);
            exit(); // Dừng việc thực thi sau khi xóa
        }
    }
}

// Hiển thị nội dung giỏ hàng sau khi xóa
$total = 0;
$output = "<table class='table table-bordered table-striped'>
    <tr>
        <th>ID</th>
        <th>Item Name</th>
        <th>Item Price</th>
        <th>Item Quantity</th>
        <th>Total Price</th>
        <th>Action</th>
    </tr>";

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $output .= "<tr>
            <td>{$value['id']}</td>
            <td>{$value['name']}</td>
            <td>{$value['price']}</td>
            <td>{$value['quantity']}</td>
            <td>" . number_format($value['price'] * $value['quantity'], 2) . "</td>
            <td>
                <button onclick='removeCartItem({$value['id']})' class='btn btn-danger btn-block'>Remove</button>
            </td>
        </tr>";
        $total += $value['quantity'] * $value['price'];
    }
}

$output .= "<tr>
    <td colspan='4'></td>
    <td><b>Total Price</b></td>
    <td>" . number_format($total, 2) . "</td>
</tr>
</table>";

echo $output;
?>
<!-- Đoạn mã JavaScript để gửi yêu cầu AJAX khi xóa sản phẩm khỏi giỏ hàng -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function removeCartItem(id) {
        $.ajax({
            url: 'index.php?action=remove&id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Nếu xóa thành công, tải lại nội dung giỏ hàng
                    $('#cartContent').load('index.php');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>

