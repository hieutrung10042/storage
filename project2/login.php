<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if(isset($_POST["login"]))
        {
            $email = $_POST["email"];
            $pass = $_POST["pass"];
            require_once "database.php";
            $sql = "SELECT * FROM register WHERE email ='$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if($user)
            {
                if(password_verify($pass,$user["pass"]))
                {
                    header("Location:index.php");
                    exit();
                    echo "Điều hướng thành công";
                }else{

                }
            }else{
                echo "<div class='alert alert-danger '>Password does not match</div>";
            }
        }
        ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="pass" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="login" name="login" class="btn btn-primary ">
            </div>
        </form>
    </div>
</body>
</html>