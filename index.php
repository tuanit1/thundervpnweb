<?php

    require "connection.php";



    if(!array_key_exists("data", $_POST)){

        echo "Đây là phương thức POST, không thể gọi được như thế này!";

        die();

    }



    $post_data = ($_POST['data']);



    $postObj = json_decode($post_data, true);



    switch($postObj['method_name']){

        case "method_signup":

            $uid = $postObj['uid'];

            $name = $postObj['name'];

            $email = $postObj['email'];

            $date = $postObj['date'];



            $query = "INSERT INTO `tbl_user` (`uid`, `email`, `name`, `expired_date`) VALUES ('$uid', '$email','$name', '$date')";



            if(mysqli_query($connect, $query)){

                echo "success";

            }else{

                echo "query false: $query";

            }



            break;



        case "method_get_allcountry":



            $query = "SELECT * FROM tbl_country";



            $query_result = mysqli_query($connect, $query);



            $jsObjAll = array();

            $jsObj_country = array();



            while($row = mysqli_fetch_assoc($query_result)){

                $data['id'] = $row['id'];

                $data['name'] = $row['name'];

                $data['isPremium'] = $row['isPremium'];

                $data['thumb'] = $row['thumb'];



                array_push($jsObj_country, $data);

            }



            $jsObjAll['array_country'] = $jsObj_country;



            echo json_encode($jsObjAll);



            break;



        case "method_get_proxy":



            $country_id = $postObj['id'];



            $jsObjAll = array();

            $jsObj_country = array();

            $jsObj_proxy = array();



            $query_country = "SELECT * FROM tbl_country WHERE id = $country_id";

            $query_proxy = "SELECT * FROM tbl_proxy WHERE country_id = $country_id";



            $country_rs = mysqli_query($connect, $query_country);

            $proxy_rs = mysqli_query($connect, $query_proxy);





            while($row = mysqli_fetch_assoc($country_rs)){

                $data['id'] = $row['id'];

                $data['name'] = $row['name'];

                $data['isPremium'] = $row['isPremium'];

                $data['thumb'] = $row['thumb'];



                array_push($jsObj_country, $data);

            }



            while($row1 = mysqli_fetch_assoc($proxy_rs)){

                $data1['id'] = $row1['id'];

                $data1['host'] = $row1['host'];

                $data1['port'] = $row1['port'];

                $data1['username'] = $row1['username'];

                $data1['password'] = $row1['password'];

                $data1['country_id'] = $row1['country_id'];



                array_push($jsObj_proxy, $data1);

            }



            $jsObjAll['array_country'] = $jsObj_country;

            $jsObjAll['array_proxy'] = $jsObj_proxy;



            echo json_encode($jsObjAll);



            break;



        case "method_get_user":



            $uid = $postObj['uid'];



            $jsObjAll = array();

            $jsObj_user = array();



            $query = "SELECT * FROM tbl_user WHERE `uid` = '$uid'";



            $query_rs = mysqli_query($connect, $query);



            while($row = mysqli_fetch_assoc($query_rs)){

                $data['uid'] = $row['uid'];

                $data['name'] = $row['name'];

                $data['expired_date'] = $row['expired_date'];



                array_push($jsObj_user, $data);

            }



            $jsObjAll['array_user'] = $jsObj_user;

            echo json_encode($jsObjAll);



            break;

        case "method_change_name":



            $name = $postObj['name'];

            $uid = $postObj['uid'];



            $query = "UPDATE `tbl_user` SET `name`='$name' WHERE `uid`='$uid'";



            if(mysqli_query($connect, $query)){

                echo "success";

            }else{

                echo "query false: $query";

            }



            break;

        case "method_get_settings":

            $query = "SELECT * FROM `tbl_admin` WHERE id = 1";

            $query_rs = mysqli_query($connect, $query);

            $jsObj_settings = array();
            $jsObj_All = array();

            while($row = mysqli_fetch_assoc($query_rs)){
                $data['default_proxy'] = $row['default_proxy'];
                $data['inters_ads_count']=$row['inters_ads_count'];
                array_push($jsObj_settings, $data);

            }

            $jsObj_All['array_setting'] = $jsObj_settings;
            
            echo json_encode($jsObj_All);

            break;

        case "method_send_feedback":

            $uid = $postObj['uid'];
            $msg = $postObj['msg'];

            $query = "INSERT INTO `tbl_feedback`(`id`, `message`, `date`, `user_id`) VALUES (NULL,'$msg',current_timestamp(),'$uid')";

            if(mysqli_query($connect, $query)){
                echo "success";
            }else{
                echo "failed: $query";
            }

            break;


            
    }



?>