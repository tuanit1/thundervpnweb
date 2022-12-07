<?php
    include_once('E_User.php');

    class M_User{
        public $connect;

        public function __construct(){
            $this->connect = mysqli_connect("localhost","root","","thundervpn");
        }

        function CheckLogin($username,$password){

            // $username_en = base64_encode($username);
            // $password_en = base64_encode($password);

            $query = "SELECT * FROM `tbl_admin` WHERE username = '$username' AND `password` = '$password'";
            $query_rs = mysqli_query($this->connect, $query);
            $row = mysqli_num_rows($query_rs);

            if($row > 0){
                return true;
            }else{
                return false;
            }
        }

        function GetAllUser(){
            $query = "SELECT * FROM tbl_user";
            $rs = mysqli_query($this->connect, $query);

            $list = array();

            while($row = mysqli_fetch_array($rs)){
                $uid = $row['uid'];
                $email = $row['email'];
                $name = $row['name'];
                $expired_date = $row['expired_date'];

                $user = new Entity_User($uid, $email, $name, $expired_date);

                array_push($list, $user);
            }

            return $list;
        }

        function GetSearchUser($search){
            $query = "SELECT * FROM `tbl_user` WHERE name LIKE '%$search%' OR uid LIKE '%$search%' OR email LIKE '%$search%'";
            $rs = mysqli_query($this->connect, $query);

            $list = array();

            while($row = mysqli_fetch_array($rs)){
                $uid = ($row['uid']);
                $email = ($row['email']);
                $name = ($row['name']);
                $expired_date = $row['expired_date'];

                $user = new Entity_User($uid, $email, $name, $expired_date);

                array_push($list, $user);
            }

            return $list;
        }

        function GetUserByID($uid){

            $id = base64_encode($uid);

            $query = "SELECT * FROM tbl_user WHERE `uid` = '$id'";
      
            $rs = mysqli_query($this->connect, $query);

            $user = NULL;

            while($row = mysqli_fetch_array($rs)){
                $uid = base64_decode($row['uid']);
                $email = base64_decode($row['email']);
                $name = base64_decode($row['name']);
                $expired_date = $row['expired_date'];

                $user = new Entity_User($uid, $email, $name, $expired_date);
            }

            return $user;
        }

        function UpdateUser($uid, $name, $expired_date){
            $uid_en = base64_encode($uid);
            $name_en = base64_encode($name);
            
            $query = "UPDATE `tbl_user` SET `name`='$name_en',`expired_date`='$expired_date' WHERE `uid` = '$uid_en'";

            echo $query;

            if(mysqli_query($this->connect, $query)){
                return true;
            }else{
                return false;
            }
        }
    }
?>