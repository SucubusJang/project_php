<?php
    include_once("dbcontrol.php");
    include_once("util.php");
    $debug_mode = false;
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        debug_text("For Get Method" ,$debug_mode); 
    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
        debug_text("For POST Method" ,$debug_mode); 
    }

