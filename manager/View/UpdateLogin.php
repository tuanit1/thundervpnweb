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
    include_once('../Model/M_Admin.php');

    $control_dir = $server_root ."/Controller/Controller.php";

    $M_Admin = new M_Admin();

    $admin = $M_Admin->GetAdmin();

?>  

<body>
    <style>
        input[type=radio] {
            border: 0px;
            width: 20px;
            height: 20px;
        }
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
        <input type="hidden" name="update_id" value="<?php echo $admin->id; ?>">
        <table width="600" cellpadding="5" cellspacing="0" border="0" align="center">
            <tr>
                <td colspan="2" align="center">
                    <h1>Cập nhập Đăng nhập</h1>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="tilte">Tên đăng nhập</p>
                </td>
                <td>
                    <input id="txb_username" class="txb" type="text" name="username" value="<?php echo $admin->username; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <p class="tilte">Mật khẩu</p>
                </td>
                <td>
                    <table class="">
                            <tr>
                                <td>
                                    <input id="txb_pass" class="txb" type="password" name="password" value="<?php echo $admin->password;?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input id="cbk_pass" type="checkbox" onclick="tooglePass()">Hiện mật khẩu
                                </td>
                            </tr>
                        </table>
                </td>
            </tr>
           
            <tr>

                <td align="center">
                    <button class="btn_back" onclick="back()">Trở về</button>
                </td>

                <td align="center">
                    <button class="btn" onclick="validate()">Cập nhập</button>
                </td>

                
            </tr>
        </table>
    </form>
</body>
<script>
    document.getElementById("form").onsubmit = function(e){
        e.preventDefault();
    }

    function tooglePass(){
        var x = document.getElementById("txb_pass");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function validate(){

        var username = document.getElementById("txb_username").value;
        var password = document.getElementById("txb_pass").value;

        var isPass = true;
        var err_msg = "";

        if(username === ""){
            err_msg = err_msg + "- Vui lòng nhập tên đăng nhập";
            isPass = false;
        }

        if(password === ""){
            isPass = false;
            if(err_msg === ""){
                err_msg = err_msg + "- Vui lòng nhập mật khẩu";
            }else{
                err_msg = err_msg + "\n- Vui lòng nhập mật khẩu";
            }
        }
        
        if(isPass){

            if(confirm("Bạn thật sự muốn cập nhập thông tin này?\n- Tên đăng nhập: "+username+"\n- Password: "+password)){
                document.getElementById("hidden").value = "update_login_admin";
                document.getElementById("form").submit();
            }

        }else{
            alert(err_msg);
        }
    }

    function back(){
        document.getElementById("hidden").value = "to_setting";
        document.getElementById("form").submit();
    }

</script>
</html>