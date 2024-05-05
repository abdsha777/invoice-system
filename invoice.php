<?php
    session_start();
function getIndianCurrency(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}

if (!isset($_GET['id'])) {
    header('Location: pastOrders.php');
    exit();
} else {
    include './connect.php';
    include './util/checkLogin.php';

    $id = $_GET['id'];
    $invoice = mysqli_query($conn, "Select * from invoice where invoice_id=" . $id);
    $inv = mysqli_fetch_assoc($invoice);

    $customer = mysqli_query($conn, "Select * from customer where customer_id=" . $inv['customer_id']);
    $c = mysqli_fetch_assoc($customer);

    $employee = mysqli_query($conn, "Select * from employee where employee_id=" . $inv['employee_id']);
    $e = mysqli_fetch_assoc($employee);

    $items = mysqli_query($conn, "Select * from invoice_items where invoice_id=" . $inv['invoice_id']);
    $aftertax = $inv['total_amount']+($inv['total_amount'] * ($inv['gst']) / 100);

    $b = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from business where business_id=" . $_SESSION['business_id']));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVOICE NO:<?= $id ?> </title>
    <link rel="stylesheet" href="./css/invoice.css">
</head>

<body>

    <a class="goBack" href="index.php">
        Go Back
    </a>
    <section>
        <div class="wrapper">
            <div class="top">
                <div class="left">
                    <div class="l1">
                        <p class="p1"><?=$b['business_name']?></p>
                        <p class="p2"><?=$b['tagline']?></p>
                        <p class="p3"><span>Deals in</span> : <?=$b['services']?></p>
                        <span>
                            <p>Address : <?=$b['address']?></p>
                            <p>Mobile : <?=$b['contact']?></p>
                            <p>GSTIN/UIN : <?=$b['gst_no']?></p>
                            <p>E-Mail : <?=$b['email']?></p>
                        </span>
                    </div>
                    <div class="l2">
                        <span>
                            <p>Buyer</p>
                            <p><?= $c['customer_name'] ?></p>
                        </span>
                        <p><span>Address</span>: <?= $c['address'] ?></p>
                        <p>State : <?= $c['state'] ?> India</p>
                    </div>
                </div>
                <div class="right">
                    <div class="r1">
                        <p class="p4"><span>Invoice No. PN : <?= $id ?></span></p>
                        <p><span>Dated
                                <?= $inv['invoice_date'] ?></span></p>
                        <p class="p4"><span>Delivery Note</span>: <?= $inv['delivery_note'] ?></p>
                        <p><span>Mode/Terms of
                                Payment: </span><?= $inv['payment_mode'] ?></p>

                        <p class="p4">Dispatch Document No: <?= $inv['dispatcher_doc_no'] ?></p>
                        <p>Destination: <?= $inv['destination'] ?></p>
                        <!-- <table border="1">
                                <tr>
                                    <td><span>Invoice No. PN-15</span></td>
                                    <td><span>Dated 19 June 2022</span></td>
                                </tr>
                                <tr>
                                    <td><span>Delivery Note</span></td>
                                    <td><span>Mode/Terms of
                                        Payment</span></td>
                                </tr>
                                <tr>
                                    <td>Supplier&#39;s Ref.
                                        <span>PN – 15</span> 
                                        </td>
                                    <td><span>Other Reference</span></td>
                                </tr>
                                <tr>
                                    <td>Buyer&#39;s Order No</td>
                                    <td><span>Dated
                                        19 Jun 2022</span></td>
                                </tr>
                                <tr>
                                    <td>Dispatch Document No</td>
                                    <td>Delivery Note Date</td>
                                </tr>
                                <tr>
                                    <td>Dispatched through</td>
                                    <td>Destination</td>
                                </tr>
                            </table> -->
                    </div>
                    <div class="r2">
                        <p><span>Terms of Delivery: </span> <?= $inv['terms'] ?></p>
                    </div>
                </div>
            </div>
            <div class="middle">
                <div class="m1">
                    <p class="p5"><span>SI No</span></p>
                    <p class="p6"><span>Description of Goods</span></p>
                    <p class="p7"><span>HSN/SAC</span></p>
                    <p class="p8"><span>Quantity</span></p>
                    <p class="p9"><span>Rate</span></p>
                    <p class="p11"><span>Amount</span></p>
                </div>
                <div class="m2">
                    <?php
                    $idx = 1;
                    foreach ($items as $i) {
                        $product = mysqli_query($conn, "Select * from product where product_id=" . $i['product_id']);
                        $p = mysqli_fetch_assoc($product);
                        echo "
                            <div class='innerm2'>
                                <div class='p5'>$idx</div>
                                <div class='p6'>" . $p['product_name'] . "</div>
                                <div class='p7'>" . $p['hsn_sac'] . "</div>
                                <div class='p8'>" . $i['quantity'] . "</div>
                                <div class='p9'>" . $i['rate'] . "</div>
                                <div class='p11'>" . $i['total'] . "</div>
                            </div>
                        ";
                        $idx++;
                    }

                    ?>

                    <div class="innerm3">
                        <div class="p5"></div>
                        <div class="p6"></div>
                        <div class="p7"></div>
                        <div class="p8"></div>
                        <div class="p9"></div>
                        <div class="p11"></div>
                    </div>
                </div>
                <div class="m3">
                    <div class="p5"></div>
                    <div class="p6"><span>Total</span></div>
                    <div class="p7"><?= $inv['total_amount'] ?></div>
                    <div class="p8"></div>
                    <div class="p9"></div>
                    <div class="p11"></div>
                </div>
                <div class="m4">
                    <p><span>Amount Chargeable (in words) Four Thousand Nine Hundred & Three Only
                        </span></p>
                </div>
                <div class="m5">
                    <div class="m51">
                        <p class="p12"><span>HSN/ACN</span></p>
                    </div>
                    <div class="m52">
                        <p class="p14"><span>Taxable</span></p>
                        <p class="p15"><span>Value</span></p>
                    </div>
                    <div class="m53">
                        <p class="p17">Central Tax</p>
                        <p class="p18">State Tax</p>
                        <p class="p19">Rate</p>
                        <p class="p20">Amount</p>
                        <p class="p21">Rate</p>
                        <p class="p22">Amount</p>
                    </div>
                    <div class="m54">
                        <p class="p24">Total Tax</p>
                        <p class="p25">Amount</p>
                    </div>
                    <div class="m55">
                        <p class="p13"><span>Total</span></p>
                        <p class="p16"><span><?= $inv['total_amount']?></span></p>
                        <p class="p23"><?= $inv['gst'] / 2 ?>%</p>
                        <p class="p23"><span><?= $inv['total_amount'] * ($inv['gst'] / 2) / 100 ?></span></p>
                        <p class="p23"><?= $inv['gst'] / 2 ?>%</p>
                        <p class="p23 none"><span><?= $inv['total_amount'] * ($inv['gst'] / 2) / 100 ?></span></p>
                        <p class="p26"><span><?= $inv['total_amount']+($inv['total_amount'] * ($inv['gst']) / 100) ?></span></p>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <p class="p27"><span>Total Amount (in words) <?=getIndianCurrency($aftertax)?></span></p>
                <p><span>Bank Details Branch <?=$b['branch']?></span></p>
                <p><span>Bank Name : <?=$b['bankname']?></span></p>
                <p><span>Current : A/c <?=$b['accno']?> </span></p>
                <p><span>IFS Code : <?=$b['ifsc']?></span></p>
            </div>
            <div class="footer">
                <div class="f1">
                    <p><span>Customer&#39;s Seal and Signature</span></p>
                </div>
                <div class="f2">
                    <p class="p28"><span>For R. R. Enterprises</span></p>
                    <p class="p29">Authorized signatory</p>
                </div>
            </div>
        </div>
    </section>
    <script>
        window.print();
    </script>
</body>

</html>