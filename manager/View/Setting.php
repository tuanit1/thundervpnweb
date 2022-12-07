<?php

    session_start();

    if(!isset($_SESSION['is_login']) || $_SESSION['is_login'] == 'false'){

        include('../Constants.php');

        header("Location: $server_root");

    }

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>

</head>

<style>

        .txb{

            height:40px; 

            width:350px; 

            font-size: 17px;

            padding-left: 15px;

            border-radius: 10px;

            border: 2px solid #2A6759;

        }



        .tilte{

            font-size: 20px;

            font-weight: bold;

            text-align: right;

            margin-right: 30px;

        }

        .btn{

            width: 100px;

            height: 40px;

            margin-left: 15px;

            border-radius: 5px;

            background-color: #13A684;

            color: #fff;

        }

        .btn_add{

            width: 200px;

            height: 40px;

            font-size: 20px;

            border-radius: 5px;

            background-color: #13A684;

            color: #fff;

        }

        .btn_update{

            width: 100px;

            height: 40px;

            border-radius: 5px;

            background-color: #13A684;

            color: #fff;

        }

        .btn_delete{

            width: 100px;

            height: 40px;

            border-radius: 5px;

            background-color: indianred;

            color: #fff;

        }

        .item_cell{

            border-bottom: 2px solid #13A684;

            font-size: 20px;

        }

        img{

            border: 1px solid #000;

            border-radius: 40px;

        }

    </style>



<?php

    include_once('../Constants.php');

    include_once('../Model/M_Admin.php');



    $M_Admin = new M_Admin();

    $admin = $M_Admin->getAdmin();



    $control_dir = $server_root ."/Controller/Controller.php";



?>  

<body

onLoad="

    <?php 

        if(isset($_REQUEST['status'])){

            if($_REQUEST['status'] == 1){

                echo "SuccessCallback()";

            }else{

                echo "FailCallback()";

            }

        }

    ?>"

>

    <form id="form" method="post" action="<?php echo $control_dir; ?>">

        <input id="hidden" type="hidden" name="method"/>

        <input id="username" type="hidden" name="username"/>

        <input id="password" type="hidden" name="password"/>  

        <input id="update_id" type="hidden" name="update_id" value="<?php echo $admin->id;?>"/> 

        <table width="1400" border="1" cellspacing="0" cellpadding="0"  align='center'>

            <tr>

                <td>

                    <table align='center'>

                        <tr>

                            <td>

                                <button class='btn_add' onclick='checkLogin()'>Đổi đăng nhập</button>

                            </td>

                            <td>

                                <button style="margin-left: 25px" class='btn_add' onclick='logout()'>Đăng xuất</button>

                            </td>

                        </tr>

                    </table>

                </td>

            </tr>

            <tr>

                <td>

                    <table width="800" align='center' border='0'>

                        <tr>

                            <td colspan="2" align="center">

                                <h1>Tùy chỉnh các biến</h1>

                            </td>

                        </tr>

                        <tr>

                            <td width="300">

                                <p class="tilte">DEFAULT PROXY</p>

                            </td>

                            <td>

                                <input id="txb_proxy" class="txb" type="text" name="default_proxy" value="<?php echo $admin->default_proxy?>">

                            </td>

                        </tr>

                        <tr>

                            <td width="300">

                                <p class="tilte">SỐ BƯỚC HIỆN INTERS ADS</p>

                            </td>

                            <td>

                                <input id="txb_inter" class="txb" type="text" name="inters_ads_count" value="<?php echo $admin->inters_ads_count?>">

                            </td>

                        </tr>

                        <tr>

                            <td align="center" colspan="2">

                                <button class="btn_add" style="margin-top:20px" onclick="Validate()">Cập nhập</button>

                            </td>

                        </tr>   

                    </table>

                </td>

            </tr>

        </table>

    </form>

</body>

<script>

    document.getElementById("form").onsubmit = function(e){

        e.preventDefault();

    }



    function checkLogin(){

        var input = prompt("Nhập thông tin đăng nhập:", "Username_Password");



        if(!input.includes("_")){

            alert("Vui lòng nhập đầy đủ username và password");

            return;

        }



        var arr = input.split("_");

        var username = arr[0];

        var password = arr[1];



        if(username === "" || password === ""){

            alert("Vui lòng nhập đầy đủ username và password");

        }else{    

            document.getElementById("hidden").value = "check_login";

            document.getElementById("username").value = username;

            document.getElementById("password").value = password;

            document.getElementById("form").submit();

        } 

    }



    function Validate(){

        var proxy_str = document.getElementById("txb_proxy").value;
        var inters_ads_count = document.getElementById("txb_inter").value;

        var arr = proxy_str.split(":");

        var host = arr[0];

        var port = arr[1];

        var username = arr[2];

        var password = arr[3];



        const regex = new RegExp('^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$');



        var isPass = true;

        var err_msg = "";



        if(proxy_str === ""){

            alert("- Vui lòng nhập chuỗi Proxy");

            return;

        }



        if(host == ""){

            err_msg = err_msg + "- Vui lòng nhập Hostname IPv4 (vd: 123.123.123.123)";

        }else{

            if(!regex.test(host)){

                isPass = false;

                err_msg = err_msg + "- Sai định dạng Hostname IPv4 (vd: 123.123.123.123)";

            }

        }


        if(port === ""){

            isPass = false;

            if(err_msg === ""){

                err_msg = err_msg + "- Vui lòng nhập Port";

            }else{

                err_msg = err_msg + "\n- Vui lòng nhập Port";

            }

        }else{

            if(!Number.isInteger(parseInt(port))){

                isPass = false;

                if(err_msg === ""){

                    err_msg = err_msg + "- Port là một giá trị integer";

                }else{

                    err_msg = err_msg + "\n- Port là một giá trị integer";

                }

            }

        }

        

        if(username === ""){

            isPass = false;

            if(err_msg === ""){

                err_msg = err_msg + "- Vui lòng nhập Username";

            }else{

                err_msg = err_msg + "\n- Vui lòng nhập Username";

            }

        }

            if(port === ""){

            isPass = false;

            if(err_msg === ""){

                err_msg = err_msg + "- Vui lòng nhập Port";

            }else{

                err_msg = err_msg + "\n- Vui lòng nhập Port";

            }

        }else{

            if(!Number.isInteger(parseInt(port))){

                isPass = false;

                if(err_msg === ""){

                    err_msg = err_msg + "- Port là một giá trị integer";

                }else{

                    err_msg = err_msg + "\n- Port là một giá trị integer";

                }

            }

        }

        if(password === ""){

            isPass = false;

            if(err_msg === ""){

                err_msg = err_msg + "- Vui lòng nhập Password";

            }else{

                err_msg = err_msg + "\n- Vui lòng nhập Passsword";

            }

        }

        if(inters_ads_count === ""){

            isPass = false;

            if(err_msg === ""){

                err_msg = err_msg + "- Vui lòng nhập Số bước nhảy Inters Ads";

            }else{

                err_msg = err_msg + "\n- Vui lòng nhập Số bước nhảy Inters Ads";

            }

        }else{

            if(!Number.isInteger(parseInt(inters_ads_count))){

                isPass = false;

                if(err_msg === ""){

                    err_msg = err_msg + "- Số bước nhảy Inters Ads là một giá trị integer";

                }else{

                    err_msg = err_msg + "\n- Số bước nhảy Inters Ads là một giá trị integer";

                }

            }

        }

        if(isPass){



            if(confirm("Bạn thật sự muốn cập nhập?")){

                document.getElementById("hidden").value = "update_setting";

                document.getElementById("form").submit();

            }



        }else{

            alert(err_msg);

        }

    }



    function SuccessCallback(){

        alert("Cập nhập thông tin thành công!");

    }



    function FailCallback(){

        alert("Đã có lỗi xảy ra, vui lòng thử lại!");

    }



    function logout(){

        if(confirm("Bạn thật sự muốn đăng xuất?")){

            document.getElementById("hidden").value = "method_logout";

            document.getElementById("form").submit();



            alert("Vui lòng refresh lại trang để có hiệu lực!");

        }

    }



</script>

</html>