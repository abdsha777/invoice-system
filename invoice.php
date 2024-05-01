<?php

if (!isset($_GET['id'])) {
    header('Location: pastOrders.php');
    exit();
} else {
    include './connect.php';
    $id = $_GET['id'];
    $invoice = mysqli_query($conn, "Select * from invoice where invoice_id=" . $id);
    $inv = mysqli_fetch_assoc($invoice);

    $customer = mysqli_query($conn, "Select * from customer where customer_id=" . $inv['customer_id']);
    $c = mysqli_fetch_assoc($customer);

    $employee = mysqli_query($conn, "Select * from employee where employee_id=" . $inv['employee_id']);
    $e = mysqli_fetch_assoc($employee);

    $items = mysqli_query($conn, "Select * from invoice_items where invoice_id=" . $inv['invoice_id']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVOICE NO:<?= $id ?> </title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        body p {
            font-size: 10px;
        }

        section {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h1 {
            margin-top: 40px;
        }

        .wrapper {
            border: 1px solid;
            width: 85%;
            height: 100%;
        }

        .top {
            display: flex;
            border-bottom: 1px solid;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .left {
            border-right: 1px solid;
            width: 57%;
            display: flex;
            flex-direction: column;
        }

        .left .l1 {
            padding: 7px;
            padding-bottom: 1rem;
        }

        .left .p1 {
            font-size: 25px;
            font-weight: bolder;
            margin-bottom: 3px;
            color: hsl(240, 99%, 60%)
        }

        .left .p2 {
            font-size: 12.5px;
            color: lightseagreen;
        }

        .left .p3 {
            margin-bottom: 1.5rem;
            font-size: 10px;
        }

        span {
            font-weight: bold;
        }

        .left .l2 {
            border-top: 1px solid;
            padding: 7px;
            padding-bottom: 1rem;
        }

        .right {
            display: flex;
            flex-direction: column;
            width: 43%;
        }

        .right .r1 {
            width: 100%;
            height: 55%;
            display: flex;
            flex-wrap: wrap;
        }

        .r1 p {
            width: 50%;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .r1 .p4 {
            border-right: 1px solid;
        }

        .r1 p {
            border-bottom: 1px solid;
        }

        .right .r2 {
            width: 100%;
            padding: 7px;
        }

        .middle {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .m1 {
            display: flex;

        }

        .m1 p {
            height: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .p5 {
            width: 4%;
            border-right: 1px solid;
        }

        .p6 {
            width: 43%;
            border-right: 1px solid;
        }

        .p7 {
            width: 10%;
            border-right: 1px solid;
        }

        .p8 {
            width: 10%;
            border-right: 1px solid;
        }

        .p9 {
            width: 10%;
            border-right: 1px solid;
        }

        .p10 {
            width: 8%;
            border-right: 1px solid;
        }

        .p11 {
            width: 15%;
        }

        .m2 {
            border-top: 1px solid;
            width: 100%;
            height: 35vh;
            display: flex;
        }

        .m2 div {
            height: 100%;
        }

        .m3 {
            width: 100%;
            height: 1.5rem;
            display: flex;
            border-top: 1px solid;
            border-bottom: 1px solid;
        }

        .m3 .p6 {
            display: flex;
            justify-content: flex-end;
            padding-right: 5px;
        }

        .m4 {
            height: 3rem;
            padding: 5px;
        }

        .m5 {
            width: 100%;
            border-top: 1px solid;
            display: flex;
            flex-wrap: wrap;
        }

        .m51 {
            width: 45%;
            border-right: 1px solid;
        }

        .p12 {
            height: 1rem;
            display: flex;
            justify-content: center;
            padding: 1px;
        }

        .p13 {
            display: flex;
            justify-content: end;
            width: 45%;
            border-right: 1px solid;
            padding-right: 5px;
        }

        .m52 {
            border-right: 1px solid;
            width: 8%;
        }

        .p16 {
            width: 8%;
            border-right: 1px solid;
            display: flex;
            justify-content: center;
        }

        .p14 {
            padding-top: 0.3rem;
            display: flex;
            justify-content: center;
        }

        .p15 {
            padding-bottom: 0.3rem;
            height: 1rem;
            display: flex;
            justify-content: center;
        }

        .m53 {
            display: flex;
            flex-wrap: wrap;
            width: 30%;
            border-right: 1px solid;
        }

        .p17 {
            width: 50%;
            height: 50%;
            border-right: 1px solid;
            border-bottom: 1px solid;
            display: flex;
            justify-content: center;

        }

        .p18 {
            width: 50%;
            height: 50%;
            display: flex;
            justify-content: center;
            border-bottom: 1px solid;
        }

        .p19,
        .p20,
        .p21,
        .p22 {
            width: 25%;
            height: 50%;
            border-right: 1px solid;
            display: flex;
            justify-content: center;
        }

        .p22 {
            border-right: none;
        }

        .p23 {
            border-right: 1px solid;
            display: flex;
            justify-content: center;
            width: 7.5%;
        }

        .m54 {
            width: 17%;
            height: 50%;
        }

        .p24,
        .p25 {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .p26 {
            display: flex;
            justify-content: center;
            width: 17%;
        }

        .m55 {
            width: 100%;
            display: flex;
            border-bottom: 1px solid;
            border-top: 1px solid;
        }

        .bottom {
            border-bottom: 1px solid;
            padding: 1rem;
            height: 8rem;
        }

        .p27 {
            margin-bottom: 1.5rem;
        }

        .footer {
            display: flex;
            height: 7rem;
        }

        .f1,
        .f2 {
            width: 50%;
        }

        .f1 {
            border-right: 1px solid;
            padding-left: 10px;
            padding-top: 5px;
        }

        .p28 {
            font-style: italic;
            margin-top: 5px;
        }

        .p29 {
            font-weight: bolder;
            font-size: large;
            margin-top: 4rem;
        }

        .f2 {
            padding-left: 10px;
        }
    </style>
</head>

<body>
    <section>
        <div class="wrapper">
            <div class="top">
                <div class="left">
                    <div class="l1">
                        <p class="p1">R. R. Enterprises</p>
                        <p class="p2">AUTHORISED DEALER , SALES & SERVICES</p>
                        <p class="p3"><span>Deals in</span> : Electronic Items, Electrical, Tools Kits, Split AC, AMC,
                            Computer Accessories, Hardware, CCTV Camera, UPS Batteries, 1 KVA
                            to 50 KVA Uniform Item &Tailoring Services, Furniture, Fabrication,
                            Civil work, Stationery, Paints & Printing, Packing Materials, D. J SOUND
                            SYSTEM, All Types & Decorations, Gazebo Tent, Alarm Systems</p>
                        <span>
                            <p>Address : Shree Hans Avenue Flat No 3 Lane No7D/ 10D4 Tingre Nagar Pune- 411032</p>
                            <p>Mobile : 9765479112</p>
                            <p>GSTIN/UIN : 27FZJPS0886K1ZH</p>
                            <p>E-Mail : r.renterprises1497@gmail.com</p>
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

                        <p class="p4">Dispatch Document No: <?=$inv['dispatcher_doc_no']?></p>
                        <p>Destination: <?=$inv['destination']?></p>
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
                        <p><span>Terms of Delivery: </span> <?=$inv['terms']?></p>
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
                    <p class="p10"><span>per</span></p>
                    <p class="p11"><span>Amount</span></p>
                </div>
                <div class="m2">
                    <div class="p5"></div>
                    <div class="p6"></div>
                    <div class="p7"></div>
                    <div class="p8"></div>
                    <div class="p9"></div>
                    <div class="p10"></div>
                    <div class="p11"></div>
                </div>
                <div class="m3">
                    <div class="p5"></div>
                    <div class="p6"><span>Total</span></div>
                    <div class="p7"></div>
                    <div class="p8"></div>
                    <div class="p9"></div>
                    <div class="p10"></div>
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
                        <p class="p16"><span>0000.00</span></p>
                        <p class="p23">9%</p>
                        <p class="p23"><span>000.0</span></p>
                        <p class="p23">9%</p>
                        <p class="p23 none"><span>000.0</span></p>
                        <p class="p26"><span>0000</span></p>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <p class="p27"><span>Tax Amount (in words) Seven Hundred Forty Seven</span></p>
                <p><span>Bank Details Branch Lohegaon Pune</span></p>
                <p><span>Bank Name : Canara Bank</span></p>
                <p><span>Current : A/c 0220201001058 </span></p>
                <p><span>IFS Code : CNRB0000220</span></p>
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