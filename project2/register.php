<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>

<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $pass = $_POST["pass"];
            $passwordRepeat = $_POST["repeat_password"];
            $passwordHash = password_hash($pass, PASSWORD_DEFAULT);

            $error = array();

            // Validate input
            if (empty($username) || empty($email) || empty($pass) || empty($passwordRepeat)) {
                $error[] = "All fields are required.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error[] = "Invalid email format.";
            }
            if (strlen($pass) < 8) {
                $error[] = "Password must be at least 8 characters long.";
            }
            if ($pass !== $passwordRepeat) {
                $error[] = "Passwords do not match.";   
            }
            require_once "database.php";
            //Check email
            $sql = "SELECT * FROM register WHERE email='$email'";
            $result = mysqli_query($conn,$sql);
            $rowCount = mysqli_num_rows($result);
            if($rowCount>0)
            {
                array_push($error,"Email already exists");
            }
            // If there are validation errors, display them
            if (!empty($error)) {
                foreach ($error as $errMsg) {
                    echo "<div class='alert alert-danger'>$errMsg</div>";
                }
            } else {
                
                
                // Sửa lại câu lệnh SQL
                $sql = "INSERT INTO register (username, email, pass) VALUES (?, ?, ?)";
                
                // Khởi tạo prepared statement
                $stmt = mysqli_stmt_init($conn);
                
                // Chuẩn bị câu lệnh SQL
                if (mysqli_stmt_prepare($stmt, $sql)) {
                    // Gắn các giá trị vào các tham số của câu lệnh SQL
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $passwordHash);
                    
                    // Thực thi câu lệnh SQL
                    if (mysqli_stmt_execute($stmt)) {
                        echo "<div class='alert alert-success'>You are registered successfully.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: Could not execute SQL statement.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Error: Could not prepare SQL statement.</div>";
                }
                
                // Đóng prepared statement
                mysqli_stmt_close($stmt);
            }
        }
        ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="pass" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
    </div>
</body>

</html>
