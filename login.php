<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <?php
    include './connect.php';
    session_start();
    var_dump($_SESSION);
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
                echo("User does not exist");
            } else {
                $arr = mysqli_fetch_assoc($result);
                if (password_verify($pass, $arr['password'])) {
                    $_SESSION['name'] = $arr['name'];
                    $_SESSION['email'] = $arr['email'];
                    $_SESSION['business_id '] = $arr['business_id'] ;
                    $_SESSION['username'] = $arr['username'];
                    $_SESSION['loggedin'] = true;
                    // header("location: index.php");
                } else {
                    $passwrong = true;
                }
            }
        }
    }
    ?>

    <h1>login</h1>
    <form action="" method="post">
        <div>
            <label for="username">username</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="password">password</label>
            <input type="text" name="password" id="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>

</html>