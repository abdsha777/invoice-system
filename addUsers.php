<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <?php
    include 'connect.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $ename = $_POST['ename'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $business_id = $_POST['business_id'];

        if (!$ename || !$username || !$password) {
            echo ("Please Fill required fields");
        } else {
            $sql = "SELECT * From employee where username='$username'";
            $result = mysqli_query($conn, $sql);
            $n = mysqli_num_rows($result);
            if ($n == 0) {
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $insert = "INSERT INTO `employee` (`employee_name`,`username`, `password`,`email`,`business_id`) VALUES ('$ename','$username', '$hash','$email',$business_id);";
                $result = mysqli_query($conn, $insert);
                if ($result) {
                    $succ = true;
                    echo("Inserted successfully");
                }
            } else {
                echo ("username already exists");
            }
            // $result = $conn.
        }
    }
    ?>

    <h1>Register</h1>
    <form action="" method="post">
        <div>
            <label for="ename">Employee Name</label>
            <input type="text" name="ename" id="ename" required>
        </div>
        <div>
            <label for="username">Employee username</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="password">password</label>
            <input type="text" name="password" id="password" required>
        </div>
        <div>
            <label for="email">email</label>
            <input type="text" name="email" id="email">
        </div>
        <div>
            <label for="business">business</label>
            <select name="business_id" id="business">
                <?php
                    $select = "select * from business";
                    $result = mysqli_query($conn,$select);
                    while($row = mysqli_fetch_assoc($result)){
                        echo("<option value='". $row['business_id'] ."'>". $row['business_name'] ."</option>");
                    }

                ?>
                </select>
        </div>


        <button type="submit">Register</button>
    </form>
</body>

</html>