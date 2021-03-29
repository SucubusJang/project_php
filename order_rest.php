<?php
    include_once("dbcontroller.php");
    include_once("util.php");
    $debug_mode = false;
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(isset($_GET['showlist'])){
            $orderId = searchId($debug_mode);
            echo json_encode(show_orderList($orderId[0]['Id'],$debug_mode));
        }else if(isset($_GET['del_order'])){
            $Id = $_GET['Id'];
            $orId = $_GET['orId'];
            del_orderDetail($Id,$orId,$debug_mode);
        }
    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['Id']) && isset($_POST['qty'])){
            $qty = $_POST['qty'];
            $pr_Id = $_POST['Id'];
            $orderId = searchId($debug_mode);
            if($_POST['orId'] == "" || $orderId[0]['status'] != 0){
                insert_order($qty,$debug_mode);
            }
            $orderId = searchId($debug_mode);
            insert_orderDetail($pr_Id,$orderId[0]['Id'],$qty,$debug_mode);
            updata_orderById($pr_Id,$orderId[0]['Id'],$qty,$debug_mode);
        }else if(isset($_POST['update_order'])){
            $orId  = $_POST['Id'];
            // update_status($orId,$debug_mode);
            echo "no";
        }
    }else{
        debug_text("Error Unknow this Request" ,$debug_mode);
        http_response_code(405);
    }
    function insert_order($qty,$debug_mode){
        $mydb = new db("root","","shopping", $debug_mode);
        $orderId = searchId($debug_mode);
        $orderId[0]['Id'] = $orderId[0]['Id']+1;
        $data = $mydb->query_only("INSERT INTO `orders`(`id`, `date_purchase`, `total`, `status`) VALUES ('{$orderId[0]['Id']}',SYSDATE(),'{$qty}','0')");
        return $data;
    }
    function insert_orderDetail($pr_Id,$orderId,$qty,$debug_mode){
        $mydb = new db("root","","shopping", $debug_mode);
        $data = $mydb->query_only("INSERT INTO `order_detail`(`id_product`, `id_orders`, `amount`) VALUES ('{$pr_Id}','{$orderId}','{$qty}')");
        return $data;
    }
    function searchId($debug_mode){
        $mydb = new db("root","","shopping", $debug_mode);
        $data = $mydb->query("SELECT `status`,MAX(`id`) as Id FROM `orders` LIMIT 1");
        return $data;
    }
    function show_orderList($orderId,$debug_mode){
        $mydb = new db("root","","shopping", $debug_mode);
        $data = $mydb->query("SELECT product.id, product.name, product.price, order_detail.amount, orders.id as or_id, orders.status
                              FROM orders,order_detail,product 
                              WHERE product.id = order_detail.id_product && orders.id = order_detail.id_orders && order_detail.id_orders = '{$orderId}'");
        return $data;
    }
    function del_orderDetail($Id,$orId,$debug_mode){
        $mydb = new db("root","","shopping", $debug_mode);
        $data = $mydb->query_only("DELETE FROM `order_detail` WHERE `id_product` = '{$Id}' and `id_orders` = '{$orId}'");
        return $data;
    }
    function updata_orderById($pr_Id,$orderId,$qty,$debug_mode){
        $mydb = new db("root","","shopping" ,$debug_mode);
        $data = $mydb->query_only("UPDATE `order_detail` SET `amount`= `amount` + '{$qty}' WHERE `id_orders` = '{$orderId}' and `id_product` = '{$pr_Id}'");
        return $data;
    }

    function update_status($orId,$debug_mode){
        $mydb = new db("root","","shopping" ,$debug_mode);
        $data =$mydb->query_only("UPDATE `orders` SET `status`= '1' WHERE `id` = '{$orId}'");
        return $data;
    }

 