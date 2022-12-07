<?php

    include_once("../Model/M_User.php");

    include_once("../Model/M_Proxy.php");

    include_once("../Model/M_Country.php");

    include_once("../Model/E_Proxy.php");

    include_once("../Model/M_Feedback.php");

    include_once("../Model/M_Admin.php");

    session_start();



    class Ctrl{

        public function invoke(){



            if(isset($_REQUEST['method'])){



                include('../Constants.php');

                include('../connection.php');



                $M_User = new M_User();

                $M_Proxy = new M_Proxy();

                $M_Country = new M_Country();

                $M_Feedback = new M_Feedback();

                $M_Admin = new M_Admin();



                $method = $_REQUEST['method'];



                switch($method){



                    case 'method_logout':



                        session_start();



                        $_SESSION['is_login'] = 'false';



                        header("Location: $server_root/View/Setting.php");



                        break;





                    case 'method_login':



                        $username = $_REQUEST['username'];

                        $password = $_REQUEST['password'];

                        

                        if($M_User->CheckLogin($username, $password)){      

                            

                            $_SESSION["is_login"] = "true";

            

                            header("Location: $server_root/View/HomePage.php");               

                        }else{
                    
                            header("Location: $server_root/index.php?wrong=1");

                        }



                        break;



                    case 'see_proxy_list':



                        $selected_country = $_REQUEST['selected_country'];



                        header("Location: $server_root/View/ProxyManage.php/?selected_country=".$selected_country);



                        break;



                    case 'add_proxy':



                        $proxy_string = $_REQUEST['proxy'];

                        $added_country = $_REQUEST['added_country'];



                        $inserted = $M_Proxy->AddNewProxy($proxy_string, $added_country);



                        if($inserted){

                            header("Location: $server_root/View/ProxyManage.php?status=1&inserted=$inserted&selected_country=$added_country"); 

                        }else{

                            header("Location: $server_root/View/ProxyManage.php?status=0&selected_country=$added_country"); 

                        }



                        break;



                    case 'delete_proxy':

                        $update_id = $_REQUEST['update_id'];

                        $selected_country = $_REQUEST['selected_country'];



                        if($M_Proxy->DeleteProxy($update_id)){

                            header("Location: $server_root/View/ProxyManage.php?status=1&selected_country=$selected_country"); 

                        }else{

                            header("Location: $server_root/View/ProxyManage.php?status=0&selected_country=$selected_country"); 

                        }



                        break;



                    case 'update_view':



                        $update_id = $_REQUEST['update_id'];



                        header("Location: $server_root/View/UpdateProxy.php?update_id=$update_id"); 



                        break;



                    case 'update_proxy':



                        echo "sdsd";



                        $update_id = $_REQUEST['update_id'];

                        $hostname = $_REQUEST['hostname'];

                        $port = $_REQUEST['port'];

                        $username = $_REQUEST['username'];

                        $password = $_REQUEST['password'];

                        $country_id = $_REQUEST['country_id'];



                        $proxy = new Entity_Proxy($update_id, $hostname, $port, $username, $password, $country_id);



                        if($M_Proxy->UpdateProxy($proxy)){

                            header("Location: $server_root/View/ProxyManage.php?status=1&inserted=$update_id&selected_country=0"); 

                        }else{

                            header("Location: $server_root/View/ProxyManage.php?status=0&selected_country=0"); 

                        }



                        break;



                    case "to_proxy_manage":



                        header("Location: $server_root/View/ProxyManage.php?selected_country=0"); 



                        break;



                    case "to_country_manage":



                        header("Location: $server_root/View/CountryManage.php"); 

    

                        break;



                    case "add_country_view":

                        header("Location: $server_root/View/AddCountry.php"); 

                        break;



                    case "add_country":



                        $name = $_REQUEST['name'];

                        $thumb = $_REQUEST['thumb'];

                        $isPremium = $_REQUEST['isPremium'];



                        if($M_Country->AddCountry($name, $thumb, $isPremium)){

                            header("Location: $server_root/View/CountryManage.php?status=1"); 

                        }else{

                            header("Location: $server_root/View/CountryManage.php?status=0"); 

                        }

                        



                        break;



                    case "update_country_view":



                        $update_id = $_REQUEST['update_id'];



                        header("Location: $server_root/View/UpdateCountry.php?update_id=$update_id"); 

                        break;



                        break;



                    case "update_country":



                        $update_id = $_REQUEST['update_id'];

                        $name = $_REQUEST['name'];

                        $thumb = $_REQUEST['thumb'];

                        $isPremium = $_REQUEST['isPremium'];



                        if($M_Country->UpdateCountry($update_id, $name, $thumb, $isPremium)){

                            header("Location: $server_root/View/CountryManage.php?status=1"); 

                        }else{

                            header("Location: $server_root/View/CountryManage.php?status=0"); 

                        }





                        break;



                    case "delete_country":



                        $update_id = $_REQUEST['update_id'];



                        if($M_Country->DeleteCountry($update_id)){

                            header("Location: $server_root/View/CountryManage.php?status=1"); 

                        }else{

                            header("Location: $server_root/View/CountryManage.php?status=0"); 

                        }



                        break;

                    case 'update_user_view':



                        $update_id = $_REQUEST['update_id'];



                        header("Location: $server_root/View/UpdateUser.php?update_id=$update_id"); 



                        break;



                    case 'to_user_manage':



                        header("Location: $server_root/View/UserManage.php");



                        break;



                    case 'update_user':



                        $update_id = $_REQUEST['update_id'];

                        $name = $_REQUEST['name'];

                        $date = $_REQUEST['date'];



                        if($M_User->UpdateUser($update_id, $name, $date)){

                            header("Location: $server_root/View/UserManage.php?status=1");

                        }else{

                            header("Location: $server_root/View/UserManage.php?status=0");

                        }



                        break;



                    case 'search_user':



                        $search_text = $_REQUEST['search'];

                    

                        header("Location: $server_root/View/UserManage.php?search=$search_text");



                        break;



                    case 'delete_feedback':



                        $update_id = $_REQUEST['update_id'];



                        if($M_Feedback->DeleteFeedback($update_id)){

                            header("Location: $server_root/View/Feedback.php?status=1");

                        }else{

                            header("Location: $server_root/View/Feedback.php?status=0");

                        }



                        break;



                    case 'check_login':



                        $username = $_REQUEST['username'];

                        $password = $_REQUEST['password'];



                        if($M_User->CheckLogin($username, $password)){

                            header("Location: $server_root/View/UpdateLogin.php");

                        }else{

                            header("Location: $server_root/View/Setting.php?status=0");

                        }



                        break;

                    

                    case 'to_setting':



                        header("Location: $server_root/View/Setting.php");



                        break;



                    case 'update_login_admin':



                        $id = $_REQUEST['update_id'];

                        $username = $_REQUEST['username'];

                        $password = $_REQUEST['password'];



                        if($M_Admin->UpdateLogin($id, $username, $password)){

                            header("Location: $server_root/View/Setting.php?status=1");

                        }else{

                            header("Location: $server_root/View/Setting.php?status=0");

                        }



                        break;



                    case 'update_setting':



                        $default_proxy = $_REQUEST['default_proxy'];
                        $inters_ads_count = $_REQUEST['inters_ads_count'];

                        $update_id = $_REQUEST['update_id'];

    

                        if($M_Admin->UpdateSetting($update_id, $default_proxy, $inters_ads_count)){

                            header("Location: $server_root/View/Setting.php?status=1");

                        }else{

                            header("Location: $server_root/View/Setting.php?status=0");

                        }



                        break;

                    case 'upload':
                        echo "aaaaaaa";


                }

            }

        }

    }

    $Ctrl = new Ctrl();

    $Ctrl->invoke();

?>