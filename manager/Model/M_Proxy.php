<?php
    include_once('E_Proxy.php');

    class M_Proxy{
        public $connect;

        public function __construct(){
            $this->connect = mysqli_connect("localhost","root","","thundervpn");
        }

        function GetListProxyByCountry($id){

            if($id == 0){
                $query = "SELECT * FROM tbl_proxy";
            }else{
                $query = "SELECT * FROM tbl_proxy WHERE `country_id` = $id";
            }

            $rs = mysqli_query($this->connect, $query);

            $list = array();

            while($row = mysqli_fetch_array($rs)){
                $id = $row['id'];
                $host = base64_decode($row['host']);
                $port = base64_decode($row['port']);
                $username = base64_decode($row['username']);
                $password = base64_decode($row['password']);
                $country_id= $row['country_id'];

                $proxy = new Entity_Proxy($id, $host, $port, $username, $password, $country_id);

                array_push($list, $proxy);
            }

            return $list;
        }

        function GetProxyByID($id){
            $query = "SELECT * FROM tbl_proxy WHERE `id` = $id";

            $rs = mysqli_query($this->connect, $query);
            $proxy = null;

            while($row = mysqli_fetch_array($rs)){
                $id = $row['id'];
                $host = base64_decode($row['host']);
                $port = base64_decode($row['port']);
                $username = base64_decode($row['username']);
                $password = base64_decode($row['password']);
                $country_id= $row['country_id'];

                $proxy = new Entity_Proxy($id, $host, $port, $username, $password, $country_id);
            }

            return $proxy;

        }

        function AddNewProxy($proxy, $country_id){
            $arr = explode(":", $proxy);

            $host = base64_encode($arr[0]);
            $port = base64_encode($arr[1]);
            $username = base64_encode($arr[2]);
            $password = base64_encode($arr[3]);

            $query = "INSERT INTO `tbl_proxy`(`id`, `host`, `port`, `username`, `password`, `country_id`)
            VALUES (NULL,'$host','$port','$username','$password',$country_id)";

            if(mysqli_query($this->connect, $query)){
                return mysqli_insert_id($this->connect);
            }else{
                return false;
            }
             
        }

        function UpdateProxy($proxy){

            $id = $proxy->id;
            $host = base64_encode($proxy->host);
            $port = base64_encode($proxy->port);
            $username = base64_encode($proxy->username);
            $password = base64_encode($proxy->password);
            $country_id = $proxy->country_id;

            $query = "UPDATE `tbl_proxy` 
            SET `host`='$host',`port`='$port',`username`='$username',`password`='$password',`country_id`='$country_id' WHERE id = $id";

            echo $query;

            if(mysqli_query($this->connect, $query)){
                return true;
            }else{
                return false;
            }
        }

        function DeleteProxy($id){

            $query = "DELETE FROM `tbl_proxy` WHERE id = $id";

            if(mysqli_query($this->connect, $query)){
                return true;
            }else{
                return false;
            }
             
        }
    }
?>