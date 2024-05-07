<?php
session_start();
include './util/checkLogin.php';
include './connect.php';

$success = false;
$updated = false;
$cid = "";
$cname = "";
$cbname = "";
$address = "";
$state = "";
$invNo = "";
$paymentMode = "";
$deliveryNote = "";
$invDate = "";
$destination = "";
$dispatcher = "";
$terms = "";
$items = "";
$gst = 0;
$total = "";
$aftertax = "";
$pulledidx = 1;

if (isset($_GET['updId'])) {
    $id = $_GET['updId'];
    $invoice = mysqli_query($conn, "Select * from invoice where invoice_id=" . $id);
    $inv = mysqli_fetch_assoc($invoice);

    $invNo = $inv['invoice_id'];
    $paymentMode = $inv['payment_mode'];
    $deliveryNote = $inv['delivery_note'];
    $invDate = $inv['invoice_date'];
    $destination = $inv['destination'];
    $dispatcher = $inv['dispatcher_doc_no'];
    $terms = $inv['terms'];
    $gst = $inv['gst'];
    $total = $inv['total_amount'];
    $aftertax = $inv['afterTax'];

    $customer = mysqli_query($conn, "Select * from customer where customer_id=" . $inv['customer_id']);
    $c = mysqli_fetch_assoc($customer);

    $cid = $c['customer_id'];
    $cname = $c['customer_name'];
    $cbname = $c['customer_business_name'];
    $address = $c['address'];
    $state = $c['state'];

    $employee = mysqli_query($conn, "Select * from employee where employee_id=" . $inv['employee_id']);
    $e = mysqli_fetch_assoc($employee);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cid = $_POST['cid'];
    $cname = $_POST['cname'];
    $cbname = $_POST['cbname'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $invNo = $_POST['invNo'];
    $paymentMode = $_POST['paymentMode'];
    $deliveryNote = $_POST['deliveryNote'];
    $invDate = $_POST['invDate'];
    $destination = $_POST['destination'];
    $dispatcher = $_POST['dispatcher'];
    $terms = $_POST['terms'];
    $items = $_POST['items'];
    $gst = $_POST['gst'];
    $items = json_decode($items);
    // var_dump($_POST);
    $total = 0;

    foreach ($items as $i) {
        $total = $total + ($i->rate * $i->quantity);
    }
    $aftertax = $total + ((float)$total * ((float)$gst / 100));
    if (isset($_POST['update'])) {
        try {
            $conn->begin_transaction();

            $sql = "UPDATE customer SET 
                customer_name = '$cname',
                customer_business_name = '$cbname',
                address = '$address',
                state = '$state' 
                WHERE customer_id = $cid";

            $invoice = mysqli_query($conn, $sql);
            $sql = "UPDATE invoice SET 
                invoice_name = '$cname',
                total_amount = $total,
                gst = $gst,
                afterTax = $aftertax,
                payment_mode = '$paymentMode',
                destination = '$destination',
                delivery_note = '$deliveryNote',
                dispatcher_doc_no = '$dispatcher',
                terms = '$terms',
                invoice_date = '$invDate',
                employee_id = {$_SESSION['employee_id']}
                WHERE invoice_id = $invNo";

            $invoice = mysqli_query($conn, $sql);
            $invoice_id = mysqli_insert_id($conn);

            $sql_delete = "DELETE FROM invoice_items WHERE invoice_id = $invNo";
            mysqli_query($conn, $sql_delete);

            // Insert new invoice items
            // var_dump($items);
            foreach ($items as $i) {
                // echo $invNo;
                $t = $i->rate * $i->quantity;
                $sql_insert = "INSERT INTO invoice_items (invoice_id, product_id, quantity, rate, total) 
                               VALUES ($invNo, $i->pid, $i->quantity, $i->rate, $t)";
                mysqli_query($conn, $sql_insert);
            }

            // echo "DOne";
            $conn->commit();
            $updated = true;
        } catch (Exception $e) {
            $conn->rollback();
            echo ($e->getMessage());
        }
    } else {
        // var_dump($_POST);
        try {
            $conn->begin_transaction();
            // if ($cid == "") {
            $sql = "INSERT into customer(customer_name,customer_business_name,address,state,business_id) values ('$cname','$cbname', '$address', '$state', " . $_SESSION['business_id'] . ")";
            // echo ($sql);
            $customer = mysqli_query($conn, $sql);
            $cid = mysqli_insert_id($conn);
            // } else {
            // $customer = mysqli_query($conn, "select * from customer where customer_id=$cid");
            // $cid = mysqli_fetch_assoc($customer['customer_id']);
            // }

            $sql = "insert into invoice(invoice_name,total_amount,gst,afterTax, payment_mode,destination,delivery_note,dispatcher_doc_no,terms,invoice_date,customer_id,business_id,employee_id) values('$cname' ,$total,$gst,$aftertax,'$paymentMode','$destination','$deliveryNote','$dispatcher','$terms','$invDate'," . $cid . "," . $_SESSION['business_id'] . "," . $_SESSION['employee_id'] . ")";

            $invoice = mysqli_query($conn, $sql);
            $invoice_id = mysqli_insert_id($conn);

            foreach ($items as $i) {
                // $present = mysqli_query($conn,"Select * from product where product_id=".$i->pid);
                // $n = mysqli_num_rows($present);
                // var_dump($i);
                if ($i->pid) {
                    // echo"yes";
                } else {
                    echo "no";
                    $new_product = mysqli_query($conn, "insert into product(product_name,hsn_sac,rate,quantity,business_id,employee_id) values('$i->desc','$i->hsn',$i->rate,$i->quantity," . $_SESSION['business_id'] . "," . $_SESSION['employee_id'] . ")");
                    $i->pid = mysqli_insert_id($conn);
                }
                $t = $i->rate * $i->quantity;
                $sql = "INSERT into invoice_items(invoice_id,product_id,quantity,rate,total) values($invoice_id,$i->pid,$i->quantity,$i->rate,$t)";
                mysqli_query($conn, $sql);
            }
            // echo "DOne";
            $conn->commit();
            $success = true;
            header("Location: invoice.php?id=" . $invoice_id);
        } catch (Exception $e) {
            $conn->rollback();
            echo ($e->getMessage());
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.02.min.css">
    <!-- <link href="./css/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="./css/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/sidebar.css">
</head>

<body>
    <?php include './components/navbar.php' ?>

    <div class="main-container">
        <div class="sidebar-wrapper">
            <div class="sidebar-items">
                <a class="sidebar-item active" href="index.php">
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
                <a class="sidebar-item" href="pastOrders.php">
                    <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.52943 0.5H2.4706C1.69091 0.5 1.05884 1.13207 1.05884 1.91176V11.0882C1.05884 11.8679 1.69091 12.5 2.4706 12.5H9.52943C10.3091 12.5 10.9412 11.8679 10.9412 11.0882V1.91176C10.9412 1.13207 10.3091 0.5 9.52943 0.5Z" stroke="#656D76" />
                        <path d="M3.88232 4.02942H8.11762M3.88232 6.85295H8.11762M3.88232 9.67648H6.70585" stroke="#656D76" stroke-linecap="round" />
                    </svg>
                    <p>Past Orders</p>
                </a>
                <a class="sidebar-item" href="productList.php">
                    <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2.75V11C12 11.3978 11.842 11.7794 11.5607 12.0607C11.2794 12.342 10.8978 12.5 10.5 12.5H1.5C1.10218 12.5 0.720644 12.342 0.43934 12.0607C0.158035 11.7794 0 11.3978 0 11V2C0 1.60218 0.158035 1.22064 0.43934 0.93934C0.720644 0.658035 1.10218 0.5 1.5 0.5L10.5 0.5C10.8978 0.5 11.2794 0.658035 11.5607 0.93934C11.842 1.22064 12 1.60218 12 2V2.75ZM11.25 2.75V2C11.25 1.80109 11.171 1.61032 11.0303 1.46967C10.8897 1.32902 10.6989 1.25 10.5 1.25H1.5C1.30109 1.25 1.11032 1.32902 0.96967 1.46967C0.829018 1.61032 0.75 1.80109 0.75 2V2.75H11.25ZM11.25 3.5H0.75V11C0.75 11.1989 0.829018 11.3897 0.96967 11.5303C1.11032 11.671 1.30109 11.75 1.5 11.75H10.5C10.6989 11.75 10.8897 11.671 11.0303 11.5303C11.171 11.3897 11.25 11.1989 11.25 11V3.5ZM3.375 5C3.47446 5 3.56984 5.03951 3.64016 5.10984C3.71049 5.18016 3.75 5.27554 3.75 5.375C3.75 5.47446 3.71049 5.56984 3.64016 5.64016C3.56984 5.71049 3.47446 5.75 3.375 5.75H1.872C1.77254 5.75 1.67716 5.71049 1.60683 5.64016C1.53651 5.56984 1.497 5.47446 1.497 5.375C1.497 5.27554 1.53651 5.18016 1.60683 5.10984C1.67716 5.03951 1.77254 5 1.872 5H3.375ZM10.125 5C10.2245 5 10.3198 5.03951 10.3902 5.10984C10.4605 5.18016 10.5 5.27554 10.5 5.375C10.5 5.47446 10.4605 5.56984 10.3902 5.64016C10.3198 5.71049 10.2245 5.75 10.125 5.75H5.625C5.52554 5.75 5.43016 5.71049 5.35984 5.64016C5.28951 5.56984 5.25 5.47446 5.25 5.375C5.25 5.27554 5.28951 5.18016 5.35984 5.10984C5.43016 5.03951 5.52554 5 5.625 5H10.125ZM3.375 7.25C3.47446 7.25 3.56984 7.28951 3.64016 7.35983C3.71049 7.43016 3.75 7.52554 3.75 7.625C3.75 7.72446 3.71049 7.81984 3.64016 7.89017C3.56984 7.96049 3.47446 8 3.375 8H1.872C1.77254 8 1.67716 7.96049 1.60683 7.89017C1.53651 7.81984 1.497 7.72446 1.497 7.625C1.497 7.52554 1.53651 7.43016 1.60683 7.35983C1.67716 7.28951 1.77254 7.25 1.872 7.25H3.375ZM10.125 7.25C10.2245 7.25 10.3198 7.28951 10.3902 7.35983C10.4605 7.43016 10.5 7.52554 10.5 7.625C10.5 7.72446 10.4605 7.81984 10.3902 7.89017C10.3198 7.96049 10.2245 8 10.125 8H5.625C5.52554 8 5.43016 7.96049 5.35984 7.89017C5.28951 7.81984 5.25 7.72446 5.25 7.625C5.25 7.52554 5.28951 7.43016 5.35984 7.35983C5.43016 7.28951 5.52554 7.25 5.625 7.25H10.125ZM3.375 9.5C3.47446 9.5 3.56984 9.53951 3.64016 9.60983C3.71049 9.68016 3.75 9.77554 3.75 9.875C3.75 9.97446 3.71049 10.0698 3.64016 10.1402C3.56984 10.2105 3.47446 10.25 3.375 10.25H1.872C1.77254 10.25 1.67716 10.2105 1.60683 10.1402C1.53651 10.0698 1.497 9.97446 1.497 9.875C1.497 9.77554 1.53651 9.68016 1.60683 9.60983C1.67716 9.53951 1.77254 9.5 1.872 9.5H3.375ZM10.125 9.5C10.2245 9.5 10.3198 9.53951 10.3902 9.60983C10.4605 9.68016 10.5 9.77554 10.5 9.875C10.5 9.97446 10.4605 10.0698 10.3902 10.1402C10.3198 10.2105 10.2245 10.25 10.125 10.25H5.625C5.52554 10.25 5.43016 10.2105 5.35984 10.1402C5.28951 10.0698 5.25 9.97446 5.25 9.875C5.25 9.77554 5.28951 9.68016 5.35984 9.60983C5.43016 9.53951 5.52554 9.5 5.625 9.5H10.125Z" fill="#656D76" />
                    </svg>
                    <p>Product List</p>
                </a>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="content-main">
                <?php
                if ($success) {
                    echo '<div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                    <strong>Bill Created@</strong> See the bill on the <a href="pastOrders.php"> Past Orders</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
                }
                if ($updated) {
                    echo '<div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                    <strong>Bill Updated@</strong> See the bill on the <a href="pastOrders.php"> Past Orders</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
                }
                ?>
                <form class="myform" action="" method="POST">

                    <div style="display: flex; justify-content: space-between; gap: 24px;">
                        <div style="width: 40%; background-color: white; border-radius: 10px; padding: 16px;">
                            <h4>Buyer's Info</h4>
                            <!-- <form> -->
                            <input type="hidden" class="cid" name="cid" value="<?= $cid ?>">
                            <div class="form-group">
                                <label for="buyerName">Name of Buyer</label>
                                <input type="text" value="<?= $cname ?>" autocomplete="off" class="form-control cname" id="buyerName" name="cname" required />
                            </div>
                            <div class="form-group">
                                <label for="companyName">Company/Business Name</label>
                                <input type="text" value="<?= $cbname ?>" class="form-control cbname" id="companyName" name="cbname" required />
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" value="<?= $address ?>" class="form-control caddress" id="address" name="address" required>
                            </div>
                            <div class="form-group">
                                <label for="state">State</label>
                                <input type="text" value="<?= $state ?>" class="form-control cstate" id="state" name="state" required>
                            </div>
                            <!-- </form> -->
                        </div>
                        <div class="row" style="width: 60%; background-color: white; border-radius: 10px;  padding: 16px;">
                            <h4 class="col-12">Bill Info</h4>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="input1">Invoice number</label>
                                    <input type="number" name="invNo" class="form-control" id="input1" value="<?= $invNo ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="input2">Mode of payment</label>
                                    <select class="form-control" name="paymentMode" id="input2" required value="<?= $paymentMode ?>">
                                        <option value="cash">Cash</option>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <!-- Add more options if needed -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="input3">Delivery note</label>
                                    <input type="text" class="form-control" id="input3" name="deliveryNote" required value="<?= $deliveryNote ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="input4">Date</label>
                                    <input type="date" class="form-control" id="input4" name="invDate" required value="<?= $invDate ?>">
                                </div>
                                <div class="form-group">
                                    <label for="input5">Destination</label>
                                    <input type="text" class="form-control" id="input5" name="destination" required value="<?= $destination ?>">
                                </div>
                                <div class="form-group">
                                    <label for="input6">Dispatch Document No</label>
                                    <input type="number" class="form-control" id="input6" name="dispatcher" value="<?= $dispatcher ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input7">Terms of Delivery</label>
                                    <input type="text" class="form-control" id="input7" style="width: 100%;" name="terms" value="<?= $terms ?>">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="container-fluid mt-4" style="padding: 20px; background-color: white; border-radius: 5px;">
                        <table class="table billing-table editableTable" id="editableTable">
                            <thead style="border-bottom: 1px solid grey; font-size:12px;">
                                <tr>
                                    <th scope="col">Sr. No</th>
                                    <th scope="col">Description of Goods</th>
                                    <th scope="col">HSN/SAC</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Rate</th>
                                    <th scope="col">Per</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Actions</th> <!-- Add this column for actions -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Rows will be dynamically added here -->
                                <?php
                                if (isset($_GET['updId'])) {
                                    $items = mysqli_query($conn, "Select * from invoice_items where invoice_id=" . $inv['invoice_id']);
                                    $pulledidx = 1;
                                    while ($row = mysqli_fetch_assoc($items)) {
                                        $product = mysqli_query($conn, "Select * from product where product_id=" . $row['product_id']);
                                        $p = mysqli_fetch_assoc($product);
                                        echo '<tr>
                                        <td>' . $pulledidx . '<input type="hidden" name="pid" class="pid" value="' . $row['product_id'] . '" /></td>
                                        <td><input required readonly required type="text" class="table-input desc desc1" value="' . $p['product_name'] . '" /></td>
                                        <td><input required required type="text" class="table-input hsn" value="' . $p['hsn_sac'] . '" /></td>
                                        <td><input required required type="number" value="' . $row['quantity'] . '" min="1" class="table-input quantity" /></td>
                                        <td><input required required type="number" value="' . $row['rate'] . '" class="table-input rate" /></td>
                                        <td><input type="number" value="0" class="table-input per" /></td>
                                        <td><input required required type="number" value="' . ($row['quantity'] * $row['rate']) . '" class="table-input amount" readonly /></td>
                                        <td>
                                            <button class="btn btn-danger" type="button" onclick="deleteRow(this)">Delete</button>
                                        </td>
                                    </tr>';
                                        $pulledidx++;
                                    }
                                } else {
                                ?>
                                    <tr>
                                        <td>1<input type="hidden" name="pid" class="pid" value="0" /></td>
                                        <td><input required type="text" class="table-input desc desc1" /></td>
                                        <td><input required type="text" class="table-input hsn" /></td>
                                        <td><input required type="number" value="1" min='1' class="table-input quantity" /></td>
                                        <td><input required type="number" value="0" class="table-input rate" /></td>
                                        <td><input type="number" value="0" class="table-input per" /></td>
                                        <td><input required type="number" value="0" class="table-input amount" readonly /></td>
                                        <td>
                                            <button class="btn btn-danger" type="button" onclick="deleteRow(this)">Delete</button>
                                        </td>
                                    </tr>

                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <button id="addRowBtn" class="btn btn-primary" type="button">Add Row</button>
                            <div class="d-flex gap-1 align-items-center">
                                <label for="totalAmount" class="down-text">Total Amount:</label>
                                <input type="text" id="totalAmount" readonly class="form-control m-0" name="total" value="<?= $total ?>">
                            </div>
                            <div class="d-flex gap-1 align-items-center">
                                <label for="totalAmount" class="down-text">GST</label>
                                <input type="number" value="<?= $gst ?>" id="tax" value="0" class="form-control m-0" name="gst">
                            </div>
                            <div class="d-flex gap-1 align-items-center">
                                <label for="totalAmount" class="down-text">After GST</label>
                                <input type="number" value="<?= $aftertax ?>" id="aftertax" readonly class="form-control m-0" name="aftertax ">
                            </div>
                            <button class="btn btn-success saveBtn" type="submit"><?php echo isset($_GET['updId']) ? 'Update' : 'Save'; ?></button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('input4').valueAsDate = new Date();
            const tableBody = document.querySelector('.editableTable tbody');
            const addRowButton = document.querySelector('#addRowBtn');

            let rowCounter = 2;

            addRowButton.addEventListener('click', function() {
                const newRow = `
                <tr>
                    <td>${rowCounter}<input type="hidden" name="pid" class="pid" value="0"/></td>
                    <td><input required type="text" class="table-input desc desc${rowCounter}" /></td>
                    <td><input required type="text" class="table-input hsn" /></td>
                    <td><input required type="number" value="1" min='1' class="table-input quantity" /></td>
                    <td><input required type="number" value="0" class="table-input rate" /></td>
                    <td><input required type="number" value="0" class="table-input per" /></td>
                    <td><input required type="number" value="0" class="table-input amount" readonly /></td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteRow(this)">Delete</button>
                    </td>
                </tr>
            `;
                tableBody.insertAdjacentHTML('beforeend', newRow);
                setupAutoComplete(rowCounter);
                rowCounter++;
                removeEnterEvent();

            });

            tableBody.addEventListener('change', function(event) {
                const target = event.target;
                if (target.classList.contains('quantity')) {
                    updateAmount(target.parentNode.parentNode);
                } else if (target.classList.contains('rate')) {
                    updateAmount(target.parentNode.parentNode);
                }
            });

            document.querySelector('#tax').addEventListener('change', totalAmount)

            removeEnterEvent();
        });

        function removeEnterEvent() {
            document.querySelectorAll('input').forEach(i => {
                i.addEventListener('keydown', function(event) {
                    // Check if Enter key was pressed (key code 13)
                    if (event.keyCode === 13) {
                        event.preventDefault(); // Prevent default form submission
                    }
                })
            })
        }

        document.querySelector('.myform').addEventListener('submit', saveData)

        function saveData(e) {
            e.preventDefault();

            var tableRows = document.querySelectorAll('.billing-table tbody tr');
            billingData = [];
            tableRows.forEach(function(row) {
                var pid = row.querySelector('.pid').value;
                var desc = row.querySelector('.desc').value;
                var hsn = row.querySelector('.hsn').value;
                var quantity = row.querySelector('.quantity').value;
                var rate = row.querySelector('.rate').value;
                var per = row.querySelector('.per').value;
                billingData.push({
                    pid: pid,
                    desc: desc,
                    hsn: hsn,
                    quantity: quantity,
                    rate: rate,
                    per: per,
                });
            });
            console.log(billingData); // You can replace console.log with your data storage logic
            const form = document.querySelector('.myform');
            let jsonString = JSON.stringify(billingData);
            const jsonInput = document.createElement('input');
            jsonInput.type = 'hidden';
            jsonInput.name = 'items'; // Name of the input field
            jsonInput.value = jsonString;
            form.appendChild(jsonInput);

            <?php
            if (isset($_GET['updId'])) {
                echo "
                    let update = document.createElement('input');
                    update.type = 'hidden';
                    update.name = 'update'; // Name of the input field
                    update.value = 1;
                    form.appendChild(update);
                    ";
            }
            ?>

            const formData = new FormData(form);

            const formDataObject = Object.fromEntries(formData.entries());
            console.log(formDataObject);
            form.submit();

        }

        function deleteRow(btn) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
            totalAmount()
        }

        function totalAmount() {
            var total = 0;
            document.querySelectorAll('.amount').forEach(function(a) {
                total += parseFloat(a.value);
            });
            document.querySelector('#totalAmount').value = total.toFixed(2);
            let gst = document.querySelector('#tax').value;
            document.querySelector('#aftertax').value = total + (total * (gst / 100));

        }

        function updateAmount(row) {
            const quantity = parseFloat(row.querySelector('.quantity').value);
            const rate = parseFloat(row.querySelector('.rate').value);
            const amount = quantity * rate;
            row.querySelector('.amount').value = amount.toFixed(2);
            totalAmount()
        }


        var products = [];
        var names = [];
        var auto;
        fetch("http://localhost/invoice-system/api/allProduct.php?bid=1")
            .then(res => res.json())
            .then(data => {
                console.log(data);
                products = data
                names = data.map(d => d.product_name);
                setupAutoComplete(<?= ($pulledidx - 1) ?>);
            })
            .catch(e => console.log(e))

        function setupAutoComplete(row) {
            if (row == 0) row = 1;
            const autoCompleteJS = new autoComplete({
                selector: ".desc" + row,
                placeHolder: "Search for Food...",
                data: {
                    src: names
                },
                resultItem: {
                    highlight: true,
                },
                threshold: 0,
                resultsList: {
                    maxResults: undefined
                },
                events: {
                    input: {
                        selection: (event) => {
                            let p = products.filter(p => p.product_name == event.detail.selection.value)[0]
                            event.target.parentNode.parentNode.parentNode.querySelector('.pid').value = p['product_id']
                            event.target.parentNode.parentNode.parentNode.querySelector('.hsn').value = p['hsn_sac']
                            event.target.parentNode.parentNode.parentNode.querySelector('.rate').value = p['rate']
                            event.target.parentNode.parentNode.parentNode.querySelector('.quantity').value = p['quantity']
                            // event.target.parentNode.parentNode.parentNode.querySelector('.gst').value = p['gst']
                            const selection = event.detail.selection.value;
                            autoCompleteJS.input.value = selection;

                            updateAmount(event.target.parentNode.parentNode.parentNode);
                        }
                    }
                }
            });
        }

        var customers = [];
        var cnames = [];
        fetch("http://localhost/invoice-system/api/customers.php?bid=1")
            .then(res => res.json())
            .then(data => {
                console.log(data);
                customers = data
                cnames = Array.from(new Set(data.map(d => d.customer_name))); 

                const autoCompleteJS = new autoComplete({
                    selector: ".cname",
                    placeHolder: "Name",
                    data: {
                        src: cnames
                    },
                    threshold: 0,
                    resultsList: {
                        maxResults: undefined
                    },
                    events: {
                        input: {
                            selection: (event) => {
                                let c = customers.filter(p => p.customer_name == event.detail.selection.value)[0]
                                // event.target.parentNode.parentNode.parentNode.querySelector('.cid').value = c['customer_id'];
                                event.target.parentNode.parentNode.parentNode.querySelector('.cbname').value = c['customer_business_name'];
                                event.target.parentNode.parentNode.parentNode.querySelector('.caddress').value = c['address'];
                                event.target.parentNode.parentNode.parentNode.querySelector('.cstate').value = c['state'];
                                const selection = event.detail.selection.value;
                                autoCompleteJS.input.value = selection;
                                // event.target.readOnly=true;
                            }
                        }
                    }
                });
            })
            .catch(e => console.log(e))
    </script>
</body>

</html>