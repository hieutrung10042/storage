<?php
require_once "connect.php";
// Đảm bảo rằng kết nối cơ sở dữ liệu đã được thiết lập (biến $conn)

// Hàm để chèn dữ liệu vào cơ sở dữ liệu
function insertData($conn, $table, $data)
{
    // Kiểm tra mật khẩu và mật khẩu xác nhận
    if ($data['password'] !== $data['confirm_password']) {
        echo "Mật khẩu và mật khẩu xác nhận không khớp!";
        return false;
    }

    // Xử lý chèn dữ liệu vào bảng cơ sở dữ liệu
    $username = $data['username'];
    $password = $data['password'];


    // Đoạn mã chèn dữ liệu vào cơ sở dữ liệu
    $sql = "INSERT INTO login (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}

// Xử lý gửi form khi POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $data = array(
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'confirm_password' => $_POST['confirm_password']
    );

    // Gọi hàm insertData để chèn dữ liệu
    if (insertData($conn, 'user', $data)) {
        echo "Đã thêm thành công!";
        header('Location: userhome.php');
        exit();
    } else {
        echo "Thêm user thất bại!";
    }
}
?>

<!-- HTML Form -->
<div class="form-container">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <input type="text" name="username" placeholder="username" class="box">
        </div>
        <div>
            <input type="password" name="password" placeholder="password" class="box">

        </div>
        <div>
            <input type="password" name="confirm_password" placeholder="Confirm Password" class="box">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>