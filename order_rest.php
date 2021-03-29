<?php
    include_once("dbcontroller.php");
    include_once("util.php");
    $debug_mode = false;
    if($_SERVER['REQUEST_METHOD'] == "GET"){

    }else if($_SERVER['REQUEST_METHOD'] == "POST"){

    }else{
        debug_text("Error Unknow this Request" ,$debug_mode);
        http_response_code(405);
    }

?>
