<?php
    include '../connect.php';
    if(isset($_GET['bid'])){

        $bid = $_GET['bid'];
        $result = mysqli_query($conn,"SELECT * from product where business_id=$bid;");
        $rows=[];
        while($row = mysqli_fetch_assoc($result)){
            $rows[]=$row;
        }
        echo json_encode($rows);
    }else{
        echo json_encode([]);
    }

?>