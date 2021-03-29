<?php
    class db{
        private $db;
        private $debug;
        function __construct($user, $pass, $dbname, $debug){
            $this->debug = $debug;
            $this->db = new mysqli("localhost",$user,$pass,$dbname);
            $this->db->set_charset("utf8");
            // Check Connection
            if($this->db->connect_errno){
                echo "Fail to connect to MYSQL: ".$this->db->connect_error;
                exit();
            }else{
                $this->debug_text("Connect Sucess......!");
            }
        }
       function debug_text($text){
            if($this->debug){
                echo "Debug :{$text}\n";
            }
       }

       function query($sql){
           $result = $this->db->query($sql);
           $this->debug_text($sql);
           $data = $result->fetch_all(MYSQLI_ASSOC);
           return $data;
       }
       function query_show($sql){
        $result = $this->db->query($sql);
        $this->debug_text($sql);
            while($data = $result->fetch_all(MYSQLI_ASSOC)){
                $resultarray[] = $data;
            }
        return $resultarray;
       }
       function query_only($sql){
           $result = $this->db->query($sql);
       }

       function close(){
           $this->db->close();
       }
    }
