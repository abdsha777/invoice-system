<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <?php
    include './connect.php';
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!$username || !$password) {
            echo "Fill all details";
        } else {
            $select = "SELECT * from employee where username='$username'";
            $result = mysqli_query($conn, $select);
            $n = mysqli_num_rows($result);
            if ($n == 0) {
                $dexist = true;
                echo ("User does not exist");
            } else {
                $arr = mysqli_fetch_assoc($result);
                if (password_verify($pass, $arr['password'])) {
                    $_SESSION['name'] = $arr['employee_name'];
                    $_SESSION['email'] = $arr['email'];
                    $_SESSION['business_id '] = $arr['business_id'];
                    $_SESSION['username'] = $arr['username'];
                    $_SESSION['loggedin'] = true;
                    echo ("die");
                    header("Location: index.php");
                    exit;
                } else {
                    $passwrong = true;
                }
            }
        }
    }
    ?>

    <div class="login-wrapper">
        <p class="brand-name"> <img src="./img/logo.png" alt=""> R & R Enterprises</p>
        <div class="login-box">

            <h1>Sign In</h1>
            <form action="" method="post" class="login-form">
                <div class="form-field">
                    <!-- <label for="username">username</label> -->
                    <input type="text" name="username" id="username" placeholder="Username" required>
                </div>
                <div class="form-field">
                    <!-- <label for="password">password</label> -->
                    <input type="text" name="password" id="password" placeholder="Password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <small class="forget-pass">Forget Password</small>
        </div>

        <div class="modal">
            <p>Forgot password</p>
            <p>Please Contact Joy to reset your password.</p>
            <button class="close">Cancel</button>
        </div>
    </div>

    <script>
        document.querySelector('.forget-pass').addEventListener('click',()=>{
            document.querySelector('.modal').classList.add('active')
        })
        document.querySelector('.close').addEventListener('click',()=>{
            document.querySelector('.modal').classList.remove('active')
        })
    </script>
</body>


</html>