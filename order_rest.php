<?php
    include_once("dbcontroller.php");
    include_once("util.php");
    $debug_mode = false;
    if($_SERVER['REQUEST_METHOD'] == "GET"){

    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['Id']) && isset($_POST['qty'])){
            $qty = $_POST['qty'];
            $Id = $_POST['Id'];
            // insert_order($qty,$debug_mode);
            $orderId = searchId($debug_mode);
            echo $qty;
            echo $Id;
            print_r($orderId);
            //insert_orderDetail($pr_Id,$orderId,$qty,$debug_mode);
        }

    }else{
        debug_text("Error Unknow this Request" ,$debug_mode);
        http_response_code(405);
    }
    function insert_order($qty,$debug_mode){
        $mydb = new db("root","","shopping", $debug_mode);
        $data = $mydb->query_only("INSERT INTO `orders`(`date_purchase`, `total`, `status`) VALUES (SYSDATE(),'{$qty}','0')");
        return $data;
    }
    function insert_orderDetail($pr_Id,$orderId,$qty,$debug_mode){
        $mydb = new db("root","","shopping", $debug_mode);
        $data = $mydb->query_only("INSERT INTO `order_detail`(`id_product`, `id_orders`, `amount`) VALUES ('{$pr_Id}','{$orderId}','{$qty}')");
        return $data;
    }
    function searchId($debug_mode){
        $mydb = new db("root","","shopping", $debug_mode);
        $data = $mydb->query_show("SELECT MAX(id) as id FROM `orders` LIMIT 1");
        return $data;
    }
?>
