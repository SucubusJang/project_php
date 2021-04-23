<?php
include_once("dbcontroller.php");
include_once("util.php");
$debug_mode = false;
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['show_pro'])) { // แสดงรายการสินค้าทั้งหมด
        echo json_encode(show_product($debug_mode));
    } else if (isset($_GET['del_Id'])) { // ลบรายการสินค้าตาม Id
        $Id = $_GET['del_Id'];
        if (del_product($Id, $debug_mode)) { // ตรวจสอบว่าทำงานสำเร็จหรือไม่
            echo "1";
        } else {
            echo "0";
        }
    } else if (isset($_GET['edit_Id'])) { // แก้ไขสินค้าตาม Id
        $Id = $_GET['edit_Id'];
        echo json_encode(show_productById($Id, $debug_mode));
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['name_pro'])) { // เพิ่มสินค้า
        $img = $_POST['img'];
        $name_pro = $_POST['name_pro'];
        $price_pro = $_POST['price_pro'];
        $stock_pro = $_POST['stock_pro'];
        if (insert_product($img,$name_pro, $price_pro, $stock_pro, $debug_mode)) { // ตรวจสอบว่าทำงานสำเร็จหรือไม่
            echo "1";
        } else {
            echo "0";
        }
    } else if (isset($_POST['name'])) { // แก้ไขสินค้า
        $Id = $_POST['Id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        if (update_product($Id, $name, $price, $stock, $debug_mode)) { // ตรวจสอบว่าทำงานสำเร็จหรือไม่
            echo "1";
        } else {
            echo "0";
        }
    }
} else {
    debug_text("Error Unknow this Request", $debug_mode);
    http_response_code(405);
}
function show_product($debug_mode)
{
    $mydb = new db("root", "", "shopping", $debug_mode);
    $data = $mydb->query("SELECT * FROM `product`");
    return $data;
}
function insert_product($img, $name_pro, $price_pro, $stock_pro, $debug_mode)
{
    $mydb = new db("root", "", "shopping", $debug_mode);
    $data = $mydb->query_only("INSERT INTO `product`(`id`, `name`, `price`, `stock`,  `image`) VALUES (null,'{$name_pro}','{$price_pro}','{$stock_pro}','{$img}')");
    return $data;
}
function del_product($Id, $debug_mode)
{
    $mydb = new db("root", "", "shopping", $debug_mode);
    $data = $mydb->query_only("DELETE FROM `product` WHERE `id` = '{$Id}'");
    return $data;
}
function show_productById($Id, $debug_mode)
{
    $mydb = new db("root", "", "shopping", $debug_mode);
    $data = $mydb->query("SELECT `name`, `price`, `stock` FROM `product` WHERE `id` = '{$Id}'");
    return $data;
}
function update_product($Id, $name, $price, $stock, $debug_mode)
{
    $mydb = new db("root", "", "shopping", $debug_mode);
    $data = $mydb->query_only("UPDATE `product` SET `name`='{$name}',`price`='{$price}',`stock`='{$stock}' WHERE `id`='{$Id}'");
    return $data;
}
