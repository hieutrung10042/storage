<?php
// Kiểm tra xem người dùng đã gửi dữ liệu thông qua phương thức POST chưa
if(isset($_POST['add_students'])) {
    // Kiểm tra xem kết nối cơ sở dữ liệu đã được thiết lập hay chưa
    if(isset($conn)) {
        // Lấy dữ liệu từ biểu mẫu
        $f_name = mysqli_real_escape_string($conn, $_POST['f_name']);
        $l_name = mysqli_real_escape_string($conn, $_POST['l_name']);
        $age = mysqli_real_escape_string($conn, $_POST['age']);

        // Kiểm tra xem các trường thông tin có rỗng hay không
        if(empty($f_name)) {
            // Nếu trường first_name rỗng, chuyển hướng và hiển thị thông báo
            header('Location: index.php?message=You need to fill in the first name');
            exit; // Kết thúc kịch bản sau khi chuyển hướng
        } else {
            // Nếu tất cả các trường thông tin được điền, thực hiện truy vấn SQL
            $query = "INSERT INTO student (first_name, last_name, age) VALUES ('$f_name', '$l_name', '$age')";
            $result = mysqli_query($conn, $query);

            if(!$result) {
                // Nếu truy vấn thất bại, hiển thị thông báo lỗi và kết thúc kịch bản
                die("Query Failed: " . mysqli_error($conn));
            } else {
                // Nếu truy vấn thành công, chuyển hướng và hiển thị thông báo thành công
                header('Location: index.php?insert_msg=Your data has been added successfully');
                exit; // Kết thúc kịch bản sau khi chuyển hướng
            }
        }
    } else {
        // Nếu kết nối cơ sở dữ liệu chưa được thiết lập, hiển thị thông báo lỗi và kết thúc kịch bản
        die("Connection to database is not established.");
    }
} else {
    // Nếu không có dữ liệu được gửi qua phương thức POST, hiển thị thông báo lỗi và kết thúc kịch bản
    die("No data received via POST method.");
}
?>
