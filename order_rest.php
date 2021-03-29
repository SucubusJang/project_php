<?php
    include_once("dbcontroller.php");
    include_once("util.php");
    $debug_mode = false;
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(isset($_GET['showlist'])){
            $orderId = searchId($debug_mode);
            echo json_encode(show_orderList($orderId,$debug_mode));
        }
    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['Id']) && isset($_POST['qty'])){
            $qty = $_POST['qty'];
            $pr_Id = $_POST['Id'];
            //insert_order($qty,$debug_mode);
            $orderId = searchId($debug_mode);
            // echo $qty;
            // echo $pr_Id;
            insert_orderDetail($pr_Id,$orderId,$qty,$debug_mode);
        }

    }else{
        debug_text("Error Unknow this Request" ,$debug_mode);
        http_response_code(405);
    }
    function insert_order($qty,$debug_mode){
        $mydb = new db("root","","shopping", $debug_mode);
        $orderId = searchId($debug_mode);
        $orderId = $orderId+1;
        $data = $mydb->query_only("INSERT INTO `orders`(`id`, `date_purchase`, `total`, `status`) VALUES ('{$orderId}',SYSDATE(),'{$qty}','0')");
        return $data;
    }
    function insert_orderDetail($pr_Id,$orderId,$qty,$debug_mode){
        $mydb = new db("root","","shopping", $debug_mode);
        $data = $mydb->query_only("INSERT INTO `order_detail`(`id_product`, `id_orders`, `amount`) VALUES ('{$pr_Id}','{$orderId}','{$qty}')");
        return $data;
    }
    function searchId($debug_mode){
        $mydb = new db("root","","shopping", $debug_mode);
        $data = $mydb->query("SELECT MAX(id) as id FROM `orders` LIMIT 1");
        return $data[0]['id'];
    }
    function show_orderList($orderId,$debug_mode){
        $mydb = new db("root","","shopping", $debug_mode);
        $data = $mydb->query("SELECT product.id, product.name, product.price, order_detail.amount 
                                   FROM orders,order_detail,product 
                                   WHERE product.id = order_detail.id_product && orders.id = order_detail.id_orders && order_detail.id_orders = '{$orderId}'");
        return $data;
    }
?>
