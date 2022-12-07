<?php

    include_once('E_Admin.php');



    class M_Admin{

        public $connect;



        public function __construct(){

            $this->connect = mysqli_connect("localhost","root","","thundervpn");

        }



        function GetAdmin(){

            $query = "SELECT * FROM tbl_admin";

            $rs = mysqli_query($this->connect, $query);



            $admin = NULL;



            while($row = mysqli_fetch_array($rs)){

                $id = $row['id'];

                $username = base64_decode($row['username']);

                $name = base64_decode($row['password']);

                $default_proxy = base64_decode($row['default_proxy']);

                $inter_ads_count = $row['inters_ads_count'];



                $admin = new Entity_Admin($id, $username, $name, $default_proxy, $inter_ads_count);

            }



            return $admin;

        }



        function UpdateLogin($id, $username, $password){



            $username_en = base64_encode($username);

            $password_en = base64_encode($password);



            $query = "UPDATE `tbl_admin` SET `username`='$username_en',`password`='$password_en' WHERE id = $id";



            if(mysqli_query($this->connect, $query)){

                return true;

            }else{

                return false;

            }

        }



        function UpdateSetting($id, $default_proxy, $inters_ads_count){



            $default_proxy_en = base64_encode($default_proxy);


            $query = "UPDATE `tbl_admin` SET `default_proxy`='$default_proxy_en', `inters_ads_count` = '$inters_ads_count' WHERE id = $id";



            echo $query;



            if(mysqli_query($this->connect, $query)){

                return true;

            }else{

                return false;

            }

        }

    }

?>