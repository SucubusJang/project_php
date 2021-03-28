<?php
    include_once("restful/dbcontrol.php");
    include_once("restful/util.php");
    $debug_mode = false;

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){ # select
        debug_text("For Get Method" ,$debug_mode); 
        echo json_encode(show_order($debug_mode));
    }else if($_SERVER['REQUEST_METHOD'] == 'POST'){ # insert , update //ถ้ามีตัวแปรเข้ามาจะทำการเช็ค
        debug_text("For POST Method" ,$debug_mode);

    } else{
        debug_text("Error Unknow this Request" ,$debug_mode);
        http_response_code(405);
    }
    function show_order($debug_mode){
        $mydb = new db("root","","shopping" ,$debug_mode);
        $data = $mydb->query("SELECT * FROM `orders`");
        return $data;
    }
