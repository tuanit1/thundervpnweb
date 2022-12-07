<?php
    session_start();
    $_SESSION["is_login"] = "false";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel = "icon" href = 
        "ic_app.png"
        type = "image/x-icon">
</head>
<style>
        .txb{
            height:40px; 
            width:270px; 
            font-size: 19px;
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

        .btn{
            width: 150px;
            height: 50px;
            font-size: 17px;
            margin-top: 30px;
            background-color: #13A684;
            border-radius: 10px;
            color: #fff;
        }
</style>
<body onLoad="<?php echo isset($_REQUEST['wrong'])?"WrongAuth()":"";?>">
    <style>
        .input{
            margin: 10px;
        }
        #form{
            padding: 15px;
        }
    </style>
    
    <div >
        <form id="form" action="Controller/Controller.php" method="post">
            <table id="form" width="500" cellspacing="0" cellpadding="0" border="0" align="center">
                <tr>
                    <td colspan="2" align="center">
                        <p><h1>Đăng Nhập</h1></p>
                    </td>
                </tr>
                <tr>
                    <td width="150" align="center">
                        <p class="tilte">Username</p>
                    </td>
                    <td>
                        <input id="txb_usname" class="txb" name="username" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="150" align="center">
                        <p class="tilte">Password</p>
                    </td>
                    <td>
                        <input id="txb_pass" class="txb" name="password" type="password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="hidden" name="method" value="method_login">
                        <input type="button" class="btn"onclick="Validate()" value="Đăng nhập">
                    </td>
                </tr>
                
            </table>
        </form>
    </div>
</body>
<script>

    document.getElementById("form").onsubmit = function(e){
        e.preventDefault();
    }
    function WrongAuth(){
        alert("Sai tên đăng nhập hoặc mật khẩu");
    }

    function Validate(){

        var form = document.getElementById("form");
        var txb_usname = document.getElementById("txb_usname");
        var txb_pass = document.getElementById("txb_pass");

        var isPass = true;
        var msg = "";

        if(txb_usname.value === ""){
            isPass = false;
            msg = msg + "Vui lòng nhập username!"
        }

        if(txb_pass.value === ""){
            isPass = false;
            if(msg === ""){
                msg = msg + "Vui lòng nhập mật khẩu!"
            }else{
                msg = msg + "\nVui lòng nhập mật khẩu!"
            }
        }

        if(isPass){
            form.submit();
        }else{
            alert(msg);
        }

    }
</script>
</html>

