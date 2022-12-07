<?php
    include_once('E_Feedback.php');

    class M_Feedback{
        public $connect;

        public function __construct(){
            $this->connect = mysqli_connect("localhost","root","","thundervpn");
        }

        function GetAllFeedback(){
            $query = "SELECT * FROM tbl_feedback";

            $rs = mysqli_query($this->connect, $query);

            $list = array();

            while($row = mysqli_fetch_array($rs)){
                $id = $row['id'];
                $message = base64_decode($row['message']);
                $date = $row['date'];
                $user_id = base64_decode($row['user_id']);

                $feedback = new Entity_Feedback($id, $message, $date, $user_id);

                array_push($list, $feedback);
            }

            return $list;
        }

        function DeleteFeedback($id){
            $query = "DELETE FROM `tbl_feedback` WHERE id=$id";

            if(mysqli_query($this->connect, $query)){
                return true;
            }else{
                return false;
            }
        }
    }
?>