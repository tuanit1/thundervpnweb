<?php
    include_once('E_Country.php');

    class M_Country{
        public $connect;

        public function __construct(){
            $this->connect = mysqli_connect("localhost","root","","thundervpn");
        }

        function GetAllCountry(){
            $query = "SELECT * FROM tbl_country";
            $rs = mysqli_query($this->connect, $query);

            $list = array();

            while($row = mysqli_fetch_array($rs)){
                $id = $row['id'];
                $name = $row['name'];
                $isPremium = $row['isPremium'];
                $thumb = $row['thumb'];

                $country = new Entity_Country($id, $name, $isPremium, $thumb);

                array_push($list, $country);
            }

            return $list;
        }

        function GetCountryByID($id){
            $query = "SELECT * FROM tbl_country WHERE `id` = $id";
            $rs = mysqli_query($this->connect, $query);

            $country = NULL;

            while($row = mysqli_fetch_array($rs)){
                $id = $row['id'];
                $name = $row['name'];
                $isPremium = $row['isPremium'];
                $thumb = $row['thumb'];

                $country = new Entity_Country($id, $name, $isPremium, $thumb);

            }

            return $country;
        }

        function AddCountry($name, $thumb, $isPremium){
            $query = "INSERT INTO `tbl_country`(`id`, `name`, `isPremium`, `thumb`) VALUES (NULL,'$name','$isPremium','$thumb')";

            if(mysqli_query($this->connect, $query)){
                return true;
            }else{
                return false;
            }
        }

        function UpdateCountry($id, $name, $thumb, $isPremium){
            $query = "UPDATE `tbl_country` SET `name`='$name',`isPremium`='$isPremium',`thumb`='$thumb' WHERE id = $id";

            if(mysqli_query($this->connect, $query)){
                return true;
            }else{
                return false;
            }
        }

        function DeleteCountry($id){
            $query = "DELETE FROM `tbl_country` WHERE id = $id";
            $query_proxy = "DELETE FROM `tbl_proxy` WHERE country_id = $id";

            if(mysqli_query($this->connect, $query_proxy)){
                if(mysqli_query($this->connect, $query)){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }      
        }
    }
?>