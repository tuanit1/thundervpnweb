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

<?php

    include_once('../Constants.php');

    include_once('../Model/M_User.php');



    $control_dir = $server_root ."/Controller/Controller.php";



    $uid = $_REQUEST['update_id'];



    $M_User = new M_User();



    $user = $M_User->GetUserByID($uid);



?>  



<body>

    <style>

        .txb{

            height:40px; 

            width:320px; 

            font-size: 17px;

            padding-left: 15px;

            border-radius: 10px;

            border: 2px solid #2A6759;

        }



        .tilte{

            font-size: 20px;

            font-weight: bold;

            text-align: right;

            margin-right: 20px;

        }



        #cbb{

            border: 2px solid #2A6759;

            font-size: 20px;

            width: 300px;

            height: 40px;

            border-radius: 10px;

        }



        .btn{

            width: 150px;

            height: 50px;

            font-size: 17px;

            background-color: #13A684;

            border-radius: 10px;

            color: #fff;

        }



        .btn_back{

            width: 150px;

            height: 50px;

            font-size: 17px;

            background-color: #808080;

            border-radius: 10px;

            color: #fff;

        }



    </style>

    <form id="form" method="post" action="<?php echo $control_dir; ?>">

        

        <input id="hidden" type="hidden" name="method"/>

        <input type="hidden" name="update_id" value="<?php echo $uid; ?>">

        <table width="600" cellpadding="5" cellspacing="0" border="0" align="center">

            <tr>

                <td colspan="2" align="center">

                    <h1>Cập nhập User</h1>

                </td>

            </tr>

            <tr>

                <td>

                    <p class="tilte">UID</p>

                </td>

                <td>

                    <input id="txb_uid" class="txb" readonly type="text" name="uid" value="<?php echo $user->uid; ?>">

                </td>

            </tr>

            <tr>

                <td>

                    <p class="tilte">Email</p>

                </td>

                <td>

                    <input id="txb_email" class="txb" readonly type="text" name="email" value="<?php echo $user->email; ?>">

                </td>

            </tr>

            <tr>

                <td>

                    <p class="tilte">Tên</p>

                </td>

                <td>

                    <input id="txb_name" class="txb" type="text" name="name" value="<?php echo $user->name; ?>">

                </td>

            </tr>

            <tr>

                <td>

                    <p class="tilte">Ngày hết hạn</p>

                </td>

                <td>

                    <input id="date" class="txb" type="date" name="date" value="<?php 

                        $expired_date = strtotime($user->expired_date);

                        $str_date = date('Y-m-d', $expired_date);

                        echo $str_date;

                    ?>">

                </td>

            </tr>



            <tr>

                <td colspan="2">

                    <table width="100%" border="0">

                        <tr>

                            <td align="center">

                                <button class="btn" onclick="addMonth(1)">+1 tháng</button>

                            </td>

                            <td align="center">

                                <button class="btn" onclick="addMonth(6)">+6 tháng</button>

                            </td>

                            <td align="center">

                                <button class="btn" onclick="addMonth(12)">+12 tháng</button>

                            </td>

                        </tr>

                    </table>

                </td>

            </tr>

                 

            <tr>

                <td colspan="2">

                    <table width="100%" style="margin-top: 25px">

                        <tr>

                            <td align="center">

                                <button class="btn_back" onclick="back()">Trở về</button>

                            </td>



                            <td align="center">

                                <button class="btn" onclick="validate()">Cập nhập</button>

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



    function addMonth(addMonth){

        var date_element = document.getElementById("date");



        var d = new Date(date_element.value);
        var crr_d = new Date();

        if(d < crr_d){
            crr_d.setMonth(crr_d.getMonth() + addMonth);

            var day = ("0" + crr_d.getDate()).slice(-2);

            var month = ("0" + (crr_d.getMonth() + 1)).slice(-2);

            var today = crr_d.getFullYear()+"-"+(month)+"-"+(day);

            date_element.value = today;
        }else{
            d.setMonth(d.getMonth() + addMonth);

            var day = ("0" + d.getDate()).slice(-2);

            var month = ("0" + (d.getMonth() + 1)).slice(-2);

            var today = d.getFullYear()+"-"+(month)+"-"+(day);

            date_element.value = today;
        }

    
        alert("Đã thêm "+addMonth+" tháng!");

    }



    function validate(){



        var name = document.getElementById("txb_name").value;

        var date = document.getElementById("date").value;



        if(name === ""){

            alert("- Vui lòng nhập Tên");

        }else{

            if(confirm("Bạn thật sự muốn cập nhập User này?\n- Tên: "+name+"\n- Ngày hết hạn: "+date)){

                document.getElementById("hidden").value = "update_user";

                document.getElementById("form").submit();

            }

        }

    }



    function back(){

        document.getElementById("hidden").value = "to_user_manage";

        document.getElementById("form").submit();

    }



</script>

</html>