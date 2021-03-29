<?php
    include_once("dbcontroller.php");
    include_once("util.php");
    $debug_mode = false;
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        // debug_text("For Get Method" ,$debug_mode); 
        if(isset($_GET['show_pro'])){
           echo json_encode(show_product($debug_mode));
        }else if(isset($_GET['del_Id'])){
            $Id = $_GET['del_Id'];
            del_product($Id,$debug_mode);
        }else if(isset($_GET['edit_Id'])){
            $Id = $_GET['edit_Id'];
            echo json_encode(show_productById($Id,$debug_mode));
        }
    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
        debug_text("For POST Method" ,$debug_mode); 
        if(isset($_POST['name_pro'])){
            $name_pro = $_POST['name_pro'];
            $price_pro = $_POST['price_pro'];
            $stock_pro = $_POST['stock_pro'];
            insert_product($name_pro,$price_pro,$stock_pro,$debug_mode);
        }else if(isset($_POST['name'])){
            $Id = $_POST['Id'];
            $name = $_POST['name']; 
            $price = $_POST['price'];
            $stock = $_POST['stock'];  
            update_product($Id,$name,$price,$stock,$debug_mode);
        }
    }
    function show_product($debug_mode){
        $mydb = new db("root","","shopping" ,$debug_mode);
        $data = $mydb->query("SELECT * FROM `product`");
        return $data;
    }
    function insert_product($name_pro,$price_pro,$stock_pro,$debug_mode) {
        $mydb = new db("root","","shopping" ,$debug_mode);
        $data = $mydb->query_only("INSERT INTO `product`(`id`, `name`, `price`, `stock`) VALUES (null,'{$name_pro}','{$price_pro}','{$stock_pro}')");
        return $data;
    }
    function del_product($Id,$debug_mode){
        $mydb = new db("root","","shopping", $debug_mode);
        $data = $mydb->query_only("DELETE FROM `product` WHERE `id` = '{$Id}'");
        return $data;
    }
    function show_productById($Id,$debug_mode){
        $mydb = new db("root","","shopping" ,$debug_mode);
        $data = $mydb->query("SELECT `name`, `price`, `stock` FROM `product` WHERE `id` = '{$Id}'");
        return $data;
    }
    function update_product($Id,$name,$price,$stock,$debug_mode){
        $mydb = new db("root","","shopping", $debug_mode);
        $data = $mydb->query_only("UPDATE `product` SET `name`='{$name}',`price`='{$price}',`stock`='{$stock}' WHERE `id`='{$Id}'");
        return $data;
    }
?>
