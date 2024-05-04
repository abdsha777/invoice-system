<?php
session_start();
include './util/checkLogin.php';
include './connect.php';

$id = "";
$name = "";
$hsn = "";
$rate = "";
$quantity = "";
$gst = "";

$inserted = false;
$updated = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $hsn = $_POST['hsn'];
    $rate = $_POST['rate'];
    $quantity = $_POST['quantity'];
    $gst = $_POST['gst'];
    if (isset($_POST['add'])) {
        $sql = "insert into product(product_name,hsn_sac,gst,rate,quantity,business_id,employee_id) values('$name','$hsn',$gst,$rate,$quantity," . $_SESSION['business_id'] . "," . $_SESSION['employee_id'] . ")";

        $result = mysqli_query($conn, $sql);
        if ($result) {
            $inserted = true;
        }
    } else if (isset($_POST['update'])) {
        $sql = "UPDATE product SET ";
        $sql .= "product_name = '$name', ";
        $sql .= "hsn_sac = '$hsn', ";
        $sql .= "gst = $gst, ";
        $sql .= "rate = $rate, ";
        $sql .= "quantity = $quantity ";
        $sql .= "WHERE product_id = " . $id ;
        
        echo(var_dump($_POST));
        echo($sql);
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $updated = true;
            header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
            exit();
        }
    }
} else {
    if (isset($_GET['upd'])) {
        $id = $_GET['id'];
        $name = $_GET['name'];
        $hsn = $_GET['hsn'];
        $rate = $_GET['rate'];
        $quantity = $_GET['quantity'];
        $gst = $_GET['gst'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.02.min.css">
    <!-- <link href="./css/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="./css/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/product.css">
</head>

<body>
    <?php include './components/navbar.php' ?>


    <div class="main-container">
        <div class="sidebar-wrapper">
            <div class="sidebar-items">
                <a class="sidebar-item" href="index.php">
                    <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 11.6562V5.28125C13 5.16482 12.9729 5.04998 12.9208 4.94584C12.8687 4.8417 12.7931 4.75111 12.7 4.68125L7.45 0.74375C7.32018 0.646383 7.16228 0.59375 7 0.59375C6.83772 0.59375 6.67982 0.646383 6.55 0.74375L1.3 4.68125C1.20685 4.75111 1.13125 4.8417 1.07918 4.94584C1.02711 5.04998 1 5.16482 1 5.28125V11.6562C1 11.8552 1.07902 12.0459 1.21967 12.1866C1.36032 12.3272 1.55109 12.4062 1.75 12.4062H4.75C4.94891 12.4062 5.13968 12.3272 5.28033 12.1866C5.42098 12.0459 5.5 11.8552 5.5 11.6562V9.40625C5.5 9.20734 5.57902 9.01657 5.71967 8.87592C5.86032 8.73527 6.05109 8.65625 6.25 8.65625H7.75C7.94891 8.65625 8.13968 8.73527 8.28033 8.87592C8.42098 9.01657 8.5 9.20734 8.5 9.40625V11.6562C8.5 11.8552 8.57902 12.0459 8.71967 12.1866C8.86032 12.3272 9.05109 12.4062 9.25 12.4062H12.25C12.4489 12.4062 12.6397 12.3272 12.7803 12.1866C12.921 12.0459 13 11.8552 13 11.6562Z" stroke="#656D76" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p>Home</p>
                </a>
                <a class="sidebar-item" href="dashboard.php">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M21 21H7.8C6.11984 21 5.27976 21 4.63803 20.673C4.07354 20.3854 3.6146 19.9265 3.32698 19.362C3 18.7202 3 17.8802 3 16.2V3M6 15L10 11L14 15L20 9M20 9V13M20 9H16" stroke="#656D76" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                    <p>Dashboard</p>
                </a>
                <a class="sidebar-item " href="pastOrders.php">
                    <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.52943 0.5H2.4706C1.69091 0.5 1.05884 1.13207 1.05884 1.91176V11.0882C1.05884 11.8679 1.69091 12.5 2.4706 12.5H9.52943C10.3091 12.5 10.9412 11.8679 10.9412 11.0882V1.91176C10.9412 1.13207 10.3091 0.5 9.52943 0.5Z" stroke="#656D76" />
                        <path d="M3.88232 4.02942H8.11762M3.88232 6.85295H8.11762M3.88232 9.67648H6.70585" stroke="#656D76" stroke-linecap="round" />
                    </svg>
                    <p>Past Orders</p>
                </a>
                <a class="sidebar-item active" href="productList.php">
                    <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2.75V11C12 11.3978 11.842 11.7794 11.5607 12.0607C11.2794 12.342 10.8978 12.5 10.5 12.5H1.5C1.10218 12.5 0.720644 12.342 0.43934 12.0607C0.158035 11.7794 0 11.3978 0 11V2C0 1.60218 0.158035 1.22064 0.43934 0.93934C0.720644 0.658035 1.10218 0.5 1.5 0.5L10.5 0.5C10.8978 0.5 11.2794 0.658035 11.5607 0.93934C11.842 1.22064 12 1.60218 12 2V2.75ZM11.25 2.75V2C11.25 1.80109 11.171 1.61032 11.0303 1.46967C10.8897 1.32902 10.6989 1.25 10.5 1.25H1.5C1.30109 1.25 1.11032 1.32902 0.96967 1.46967C0.829018 1.61032 0.75 1.80109 0.75 2V2.75H11.25ZM11.25 3.5H0.75V11C0.75 11.1989 0.829018 11.3897 0.96967 11.5303C1.11032 11.671 1.30109 11.75 1.5 11.75H10.5C10.6989 11.75 10.8897 11.671 11.0303 11.5303C11.171 11.3897 11.25 11.1989 11.25 11V3.5ZM3.375 5C3.47446 5 3.56984 5.03951 3.64016 5.10984C3.71049 5.18016 3.75 5.27554 3.75 5.375C3.75 5.47446 3.71049 5.56984 3.64016 5.64016C3.56984 5.71049 3.47446 5.75 3.375 5.75H1.872C1.77254 5.75 1.67716 5.71049 1.60683 5.64016C1.53651 5.56984 1.497 5.47446 1.497 5.375C1.497 5.27554 1.53651 5.18016 1.60683 5.10984C1.67716 5.03951 1.77254 5 1.872 5H3.375ZM10.125 5C10.2245 5 10.3198 5.03951 10.3902 5.10984C10.4605 5.18016 10.5 5.27554 10.5 5.375C10.5 5.47446 10.4605 5.56984 10.3902 5.64016C10.3198 5.71049 10.2245 5.75 10.125 5.75H5.625C5.52554 5.75 5.43016 5.71049 5.35984 5.64016C5.28951 5.56984 5.25 5.47446 5.25 5.375C5.25 5.27554 5.28951 5.18016 5.35984 5.10984C5.43016 5.03951 5.52554 5 5.625 5H10.125ZM3.375 7.25C3.47446 7.25 3.56984 7.28951 3.64016 7.35983C3.71049 7.43016 3.75 7.52554 3.75 7.625C3.75 7.72446 3.71049 7.81984 3.64016 7.89017C3.56984 7.96049 3.47446 8 3.375 8H1.872C1.77254 8 1.67716 7.96049 1.60683 7.89017C1.53651 7.81984 1.497 7.72446 1.497 7.625C1.497 7.52554 1.53651 7.43016 1.60683 7.35983C1.67716 7.28951 1.77254 7.25 1.872 7.25H3.375ZM10.125 7.25C10.2245 7.25 10.3198 7.28951 10.3902 7.35983C10.4605 7.43016 10.5 7.52554 10.5 7.625C10.5 7.72446 10.4605 7.81984 10.3902 7.89017C10.3198 7.96049 10.2245 8 10.125 8H5.625C5.52554 8 5.43016 7.96049 5.35984 7.89017C5.28951 7.81984 5.25 7.72446 5.25 7.625C5.25 7.52554 5.28951 7.43016 5.35984 7.35983C5.43016 7.28951 5.52554 7.25 5.625 7.25H10.125ZM3.375 9.5C3.47446 9.5 3.56984 9.53951 3.64016 9.60983C3.71049 9.68016 3.75 9.77554 3.75 9.875C3.75 9.97446 3.71049 10.0698 3.64016 10.1402C3.56984 10.2105 3.47446 10.25 3.375 10.25H1.872C1.77254 10.25 1.67716 10.2105 1.60683 10.1402C1.53651 10.0698 1.497 9.97446 1.497 9.875C1.497 9.77554 1.53651 9.68016 1.60683 9.60983C1.67716 9.53951 1.77254 9.5 1.872 9.5H3.375ZM10.125 9.5C10.2245 9.5 10.3198 9.53951 10.3902 9.60983C10.4605 9.68016 10.5 9.77554 10.5 9.875C10.5 9.97446 10.4605 10.0698 10.3902 10.1402C10.3198 10.2105 10.2245 10.25 10.125 10.25H5.625C5.52554 10.25 5.43016 10.2105 5.35984 10.1402C5.28951 10.0698 5.25 9.97446 5.25 9.875C5.25 9.77554 5.28951 9.68016 5.35984 9.60983C5.43016 9.53951 5.52554 9.5 5.625 9.5H10.125Z" fill="#656D76" />
                    </svg>
                    <p>Product List</p>
                </a>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="content-main">
                <div class="container1">
                    <form class="box" action="" method="post">
                        <div class="text">Add Goods / Products</div>
                        <hr />
                        <div class="input-row">
                            <div class="input-col">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <div class="input-box width-large">
                                    <label for="p-name">Description of product</label>
                                    <input type="text" name="name" id="p-name" placeholder="-" required value="<?= $name ?>" />
                                </div>

                                <div class="input-box width-medium">
                                    <label for="hsn/sac">HSN/SAC</label>
                                    <input type="text" name="hsn" id="hsn/sac" placeholder="-" required value="<?= $hsn ?>" />
                                </div>

                                <div class="input-box width-medium">
                                    <label for="rate">Rate</label>
                                    <input type="number" name="rate" id="rate" placeholder="-" required value="<?= $rate ?>" />
                                </div>

                                <div class="input-box width-small">
                                    <label for="quantity">quantity</label>
                                    <input type="number" name="quantity" id="quantity" placeholder="-" required value="<?= $quantity ?>" />
                                </div>

                                <div class="input-box width-small">
                                    <label for="code">GST</label>
                                    <input type="number" name="gst" id="code" placeholder="-" required value="<?= $gst ?>" />
                                </div>


                            </div>
                            <?php
                            if (isset($_GET['upd'])) {
                                echo '<input type="submit" name="update" value="Update">';
                            } else {
                                echo '<input type="submit" name="add" value="Add">';
                            }

                            ?>

                        </div>

                    </form>
                    <table class="box">
                        <tr>
                            <th>
                                Sr No
                            </th>
                            <th class="width-large">
                                Description of product
                            </th>
                            <th class="width-medium">
                                HSN/SAC
                            </th>
                            <th class="width-medium">
                                Rate
                            </th>
                            <th class="width-small">
                                quantity
                            </th>
                            <th class="width-medium">
                                GST
                            </th>
                            <th></th>
                        </tr>
                        <!-- data  -->
                        <?php

                        $sql = "Select * from product where business_id=" . $_SESSION['business_id'];
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                                <tr>
                                <td>" . $row['product_id'] . "</td>
                                <td>" . $row['product_name'] . "</td>
                                <td>" . $row['hsn_sac'] . "</td>
                                <td>" . $row['rate'] . "</td>
                                <td>" . $row['quantity'] . "</td>
                                <td>" . $row['gst'] . "%</td>
                                <td>
                                    <a href='
                                    ?upd=1&id=" . $row['product_id'] . "&name=" . $row['product_name'] . "&rate=" . $row['rate'] . "&quantity=" . $row['quantity'] . "&gst=" . $row['gst'] . "&hsn=" . $row['hsn_sac'] . "
                                    ' class='update' >update</a>
                                </td>
                                </tr>
                                ";
                        }

                        ?>

                    </table>
                </div>
            </div>
        </div>
    </div>
</body>


</html>