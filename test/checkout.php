<?php
session_start();

// Kết nối đến cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "shopping_cart");
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Xử lý thanh toán khi người dùng nhấn nút Checkout
if (isset($_POST['checkout'])) {
    // Lấy thông tin thanh toán từ form và escape để ngăn chặn SQL Injection
    $customer_name = mysqli_real_escape_string($connect, $_POST['customer_name']);
    $card_number = mysqli_real_escape_string($connect, $_POST['card_number']);
    $expiry_date = mysqli_real_escape_string($connect, $_POST['expiry_date']);
    $cvv = mysqli_real_escape_string($connect, $_POST['cvv']);
    $address  = mysqli_real_escape_string($connect, $_POST['address']);
    $number  = mysqli_real_escape_string($connect, $_POST['number']);

    // Tính tổng số tiền của đơn hàng từ giỏ hàng trong session
    $total_amount = 0;
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total_amount += $item['price'] * $item['quantity'];
        }
    }

    // Thêm thông tin đơn hàng vào cơ sở dữ liệu
    $insert_query = "INSERT INTO checkout (customer_name, total_amount, card_number, expiry_date, cvv,address,number)
                     VALUES ('$customer_name', $total_amount, '$card_number', '$expiry_date', '$cvv','$address','$number')";

    if (mysqli_query($connect, $insert_query)) {
        // Xóa giỏ hàng sau khi lưu thông tin đơn hàng thành công
        unset($_SESSION['cart']);
        echo "<script>alert('Thanh toán thành công. Đơn hàng đã được lưu vào cơ sở dữ liệu.');</script>";
        // Sau khi thông báo thành công, chuyển hướng người dùng về trang chủ
        echo "<script>window.location.replace('index.php');</script>";
        exit();
    } else {
        echo "Đã xảy ra lỗi khi lưu đơn hàng: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="text-center my-4">Checkout</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4>Order Summary</h4>
            <table class="table">
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total_amount = 0;
                if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        $total_amount += $item['price'] * $item['quantity'];
                        echo "<tr>
                                <td>{$item['name']}</td>
                                <td>$ {$item['price']}</td>
                                <td>{$item['quantity']}</td>
                                <td>$ " . number_format($item['price'] * $item['quantity'], 2) . "</td>
                              </tr>";
                    }
                }
                ?>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total Amount</strong></td>
                    <td><strong>$ <?= number_format($total_amount, 2) ?></strong></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4 class="mb-4">Payment Details</h4>
            <form method="post">
                <div class="mb-3">
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                </div>
                <div class="mb-3">
                    <label for="card_number" class="form-label">Card Number</label>
                    <input type="text" class="form-control" id="card_number" name="card_number" required>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="expiry_date" class="form-label">Expiry Date</label>
                        <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>
                    </div>
                    <div class="col">
                        <label for="cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" maxlength="3" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="number" class="form-label">Number</label>
                        <input type="text" class="form-control" id="number" name="number" required>
                    </div>
                </div>
                <button type="submit" name="checkout" class="btn btn-primary btn-block">Checkout</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
