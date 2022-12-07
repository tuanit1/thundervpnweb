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
    include_once('../Model/M_Proxy.php');
    include_once('../Model/M_Country.php');
    include_once('../Constants.php');

    $control_dir = $server_root ."/Controller/Controller.php";

    $M_Proxy = new M_Proxy();
    $M_Country = new M_Country();

    $proxy_id = $_REQUEST['update_id'];

    $array_country = $M_Country->GetAllCountry();
    $proxy = $M_Proxy->GetProxyByID($proxy_id);
?>  

<body>
    <style>
        .txb{
            height:40px; 
            width:270px; 
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
        
        <input id="hidden" type="hidden" name="method" value="update_proxy"/>
        <input type="hidden" name="update_id" value="<?php echo $proxy_id; ?>" />
        <table width="600" cellpadding="5" cellspacing="0" border="0" align="center">
            <tr>
                <td colspan="2" align="center">
                    <h1>Cập nhập Proxy</h1>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="tilte">ID</p>
                </td>
                <td>
                    <input class="txb" type="text" disabled value="<?php echo $proxy->id;?>">
                </td>
            </tr>
            <tr>
                <td>
                    <p class="tilte">Hostname</p>
                </td>
                <td>
                    <input id="txb_hostname" class="txb" type="text" name="hostname" value="<?php echo $proxy->host;?>">
                </td>
            </tr>
            <tr>
                <td>
                    <p class="tilte">Port</p>
                </td>
                <td>
                    <input id="txb_port" class="txb" type="text" name="port" value="<?php echo $proxy->port;?>">
                </td>
            </tr>
            <tr>
                <td>
                    <p class="tilte">Username</p>
                </td>
                <td>
                    <input id="txb_username" class="txb" type="text" name="username" value="<?php echo $proxy->username;?>">
                </td>
            </tr>
            <tr>
                <td>
                    <p class="tilte">Password</p>
                </td>
                <td>
                    <table class="">
                        <tr>
                            <td>
                                <input id="txb_pass" class="txb" type="password" name="password" value="<?php echo $proxy->password;?>">
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
                <td>
                    <p class="tilte">Country</p>
                </td>
                <td>
                    <select name="country_id" id="cbb">
                        <?php
                            foreach($array_country as &$country){

                                $selected = "";

                                if($proxy->country_id==$country->id){
                                    $selected = "selected";
                                }

                                echo "<option $selected value='$country->id'>$country->name</option>";
                            }
                        ?>                        
                    </select>
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

        var host = document.getElementById("txb_hostname").value;
        var port = document.getElementById("txb_port").value;
        var username = document.getElementById("txb_username").value;
        var password = document.getElementById("txb_pass").value;

        const regex = new RegExp('^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$');

        var isPass = true;
        var err_msg = "";

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

        if(password === ""){
            isPass = false;
            if(err_msg === ""){
                err_msg = err_msg + "- Vui lòng nhập Password";
            }else{
                err_msg = err_msg + "\n- Vui lòng nhập Passsword";
            }
        }

        if(isPass){

            if(confirm("Bạn thật sự muốn cập nhập proxy này?\n- Hostname: "+host+"\n- Port: "+port+"\n- Username: "+username+"\n- Password: "+password)){
                document.getElementById("form").submit();
            }

        }else{
            alert(err_msg);
        }
    }

    function back(){
        document.getElementById("hidden").value = "to_proxy_manage";
        document.getElementById("form").submit();
    }

</script>
</html>