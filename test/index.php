<?php
session_start();

$connect = mysqli_connect("localhost", "root", "", "shopping_cart");

// Xử lý thêm sản phẩm vào giỏ hàng
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
    $session_array_id = array_column($_SESSION['cart'], "id");
    if (!in_array($id, $session_array_id)) {
        $session_array = array(
            "id" => $id,
            "name" => $name,
            "price" => $price,
            "quantity" => $quantity
        );
        $_SESSION['cart'][] = $session_array;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Shopping Cart</title>
</head>

<body>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="text-center">Shopping Cart</h2>
                    <div class="col-md-12">
                        <div class="row">

                            <?php
                            $query = "SELECT * FROM cart_item";
                            $result = mysqli_query($connect, $query);

                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <div class="col-md-4">
                                    <form method="post" action="index.php">
                                        <img src="img/<?= $row['image'] ?>" style="height: 150px;">
                                        <h5 class="text-center"><?= $row['name']; ?></h5>
                                        <h5 class="text-center">$<?= number_format($row['price'], 2); ?></h5>
                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                        <input type="hidden" name="name" value="<?= $row['name']; ?>">
                                        <input type="hidden" name="price" value="<?= $row['price']; ?>">
                                        <input type="number" name="quantity" value="1" class="form-control">
                                        <input type="submit" name="add_to_cart" class="btn btn-warning btn-block my-2" value="Add To Cart">
                                    </form>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Giỏ Hàng
                    </button>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Giỏ Hàng</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-6">
                                <h2 class="">Items Selected</h2>
                                <?php
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
                                    // Thay đổi phần hiển thị danh sách sản phẩm trong giỏ hàng
                                    foreach ($_SESSION['cart'] as $key => $value) {
                                        $output .= "<tr>
                                        <td>{$value['id']}</td>
                                        <td>{$value['name']}</td>
                                        <td>{$value['price']}</td>
                                        <td>{$value['quantity']}</td>
                                        <td>" . number_format($value['price'] * $value['quantity'], 2) . "</td>
                                        <td>
                                            <a href='index.php?action=remove&id={$value['id']}'>
                                                <button class='btn btn-danger btn-block'>Remove</button>
                                            </a>
                                        </td>
                                    </tr>";
                                        $total += $value['quantity'] * $value['price'];
                                    }

                                    $output .= "<tr>
                                    <td colspan='4'></td>
                                    <td><b>Total Price</b></td>
                                    <td>" . number_format($total, 2) . "</td>
                                </tr>
                                </table>";
                                    // Thay đổi phần button Clear Cart
                                    $output .= "<a href='checkout.php'>
                            <button class='btn btn-warning btn-block'>Checkout</button>
                            </a>";
                                } else {
                                    $output .= "<tr><td colspan='6' class='text-center'>Your cart is empty.</td></tr></table>";
                                }

                                echo $output;
                                ?>
                            </div>
                        </div>
                        <?php
                        // Xử lý các hành động trong giỏ hàng
                        if (isset($_GET['action'])) {
                            if ($_GET['action'] == "clearall") {
                                unset($_SESSION['cart']);
                                // Redirect để tránh gửi lại các hành động sau khi xóa giỏ hàng
                                header("Location: index.php");
                                exit();
                            }
                            if ($_GET['action'] == "remove" && isset($_GET['id'])) {
                                $remove_id = $_GET['id'];
                                foreach ($_SESSION['cart'] as $key => $value) {
                                    if ($value['id'] == $remove_id) {
                                        unset($_SESSION['cart'][$key]);
                                        // Redirect để tránh gửi lại các hành động sau khi xóa sản phẩm
                                        header("Location: index.php");
                                        exit();
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Hàm xử lý xóa sản phẩm khỏi giỏ hàng bằng AJAX
        function removeCartItem(id) {
            $.ajax({
                url: 'index.php?action=remove&id=' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Nếu xóa thành công, cập nhật lại nội dung giỏ hàng
                        $('#cartContent').load('index.php');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
</body>

</html>