<?php
include_once("dbcontroller.php");
include_once("util.php");
$debug_mode = false;
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['showlist'])) { // แสดงรายการ
        echo json_encode(show_orderList($debug_mode));
    } else if (isset($_GET['del_order'])) { // ลบรายการตาม Id
        $Id = $_GET['Id'];
        $orId = $_GET['orId'];
        $qty = $_GET['qty'];
        updata_orderById($orId, $qty, $debug_mode); // เปลี่ยนจำนวน total ของ orderss
        del_orderDetail($Id, $orId, $debug_mode); // ลบรายการตาม Id
    } else if (isset($_GET['showOrder'])) { // แสดงรายการทั้งหมด
        echo json_encode(show_order($debug_mode));
    } else if(isset($_GET['list'])){  // แสดงรายการตาม Id
        $orId = $_GET['idx'];
        echo json_encode(show_list($orId,$debug_mode));
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['Id']) && isset($_POST['qty'])) { // เพิ่มข้อมูล order
        openbill($debug_mode);
    } else if (isset($_POST['update_order'])) { // ชำระเงิน
        $Id = $_POST['Id'];
        if(update_status($Id, $debug_mode)){
            echo "1";
        }else {
            echo "0";
        }
    }
} else {
    debug_text("Error Unknow this Request", $debug_mode);
    http_response_code(405);
}
function openbill($debug_mode)
{
    $mydb = new db("root", "", "shopping", $debug_mode);
    $firstbill = $mydb->query("SELECT COUNT(`id`) as Id FROM `orders`"); // เข็คว่าบิลเคยเปิดมาหรือยัง
    $current_bill = $mydb->query("SELECT `id`,`status` FROM `orders` ORDER BY `id` DESC LIMIT 1");  // เช็คสถานะและรหัส ของบิลล่าสุด
    if ($firstbill[0]['Id'] == 0 || $current_bill[0]['status'] == 1) { // เช็คว่าเป็นบิลแรก หรือ รายการล่าสุดปิดรายการหรือยัง
        $Id = $current_bill[0]['id'] + 1; // นำไอดี ล่าสุด มาบวก 1
        $mydb->query_only("INSERT INTO `orders`(`id`, `date_purchase`, `total`, `status`) VALUES ($Id,SYSDATE(),'{$_POST['qty']}',0)");
        $mydb->query_only("INSERT INTO `order_detail`(`id_product`, `id_orders`, `amount`) VALUES ('{$_POST['Id']}','{$Id}','{$_POST['qty']}')");
    } else {
        if ($current_bill[0]['status'] == 0) { // บิลยังไม่ถูกปิด
            // สินค้านี้ถูกเพิ่มไปหรือยัง ถ้ายังไม่มีให้เพิ่มสินค้าลงไป แต่ถ้ามีอยู่แล้วให้ เพิ่มจำนวนสินค้า
            $check_pro = $mydb->query("SELECT COUNT(`id_product`) as Counts FROM `order_detail` WHERE `id_product` = '{$_POST['Id']}' AND `id_orders` = '{$current_bill[0]['id']}'");
            if ($check_pro[0]['Counts'] == 0) {
                $mydb->query_only("INSERT INTO `order_detail`(`id_product`, `id_orders`, `amount`) VALUES ('{$_POST['Id']}','{$current_bill[0]['id']}','{$_POST['qty']}')");
                $mydb->query_only("UPDATE `orders` SET `total`= `total` + '{$_POST['qty']}' WHERE `id` = '{$current_bill[0]['id']}'");
            } else {
                $mydb->query_only("UPDATE `order_detail` SET `amount`= `amount` + '{$_POST['qty']}' WHERE `id_orders` = '{$current_bill[0]['id']}' and `id_product` = '{$_POST['Id']}'");
                $mydb->query_only("UPDATE `orders` SET `total`= `total` + '{$_POST['qty']}' WHERE `id` = '{$current_bill[0]['id']}'");
            }
        }
    }
}

function show_list($orderId, $debug_mode)
{
    $mydb = new db("root", "", "shopping", $debug_mode);
    $data = $mydb->query("SELECT product.id, product.name, product.price, order_detail.amount, orders.id, orders.status, orders.total 
                                FROM orders,order_detail,product 
                                WHERE product.id = order_detail.id_product && orders.id = order_detail.id_orders && orders.id = '{$orderId}'");
    return $data;
}

function show_orderList($debug_mode)
{
    $mydb = new db("root", "", "shopping", $debug_mode);
    $data = $mydb->query("SELECT product.id, product.name, product.price, order_detail.amount, orders.id as or_id, orders.status, orders.total 
                            FROM orders,order_detail,product 
                            WHERE product.id = order_detail.id_product && orders.id = order_detail.id_orders && orders.status = 0");
    return $data;
}

function del_orderDetail($Id, $orId, $debug_mode)
{
    $mydb = new db("root", "", "shopping", $debug_mode);
    $data = $mydb->query_only("DELETE FROM `order_detail` WHERE `id_product` = '{$Id}' and `id_orders` = '{$orId}'");
    return $data;
}

function updata_orderById($orderId, $qty, $debug_mode)
{
    $mydb = new db("root", "", "shopping", $debug_mode);
    $data = $mydb->query_only("UPDATE `orders` SET `total`= `total` - '{$qty}' WHERE `id` = '{$orderId}'");
    return $data;
}

function update_status($orId, $debug_mode)
{
    $mydb = new db("root", "", "shopping", $debug_mode);
    $data = $mydb->query_only("UPDATE `orders` SET `status`= '1' WHERE `id` = '{$orId}'");
    return $data;
}

function show_order($debug_mode)
{
    $mydb = new db("root", "", "shopping", $debug_mode);
    $data = $mydb->query("SELECT * FROM `orders`");
    return $data;
}
