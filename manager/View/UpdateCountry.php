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
    include_once('../Model/M_Country.php');

    $control_dir = $server_root ."/Controller/Controller.php";

    $country_id = $_REQUEST['update_id'];

    $M_Country = new M_Country();

    $country = $M_Country->GetCountryByID($country_id);

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
        <input type="hidden" name="update_id" value="<?php echo $country_id; ?>">
        <table width="600" cellpadding="5" cellspacing="0" border="0" align="center">
            <tr>
                <td colspan="2" align="center">
                    <h1>Cập nhập Country</h1>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="tilte">Tên Country</p>
                </td>
                <td>
                    <input id="txb_name" class="txb" type="text" name="name" value="<?php echo $country->name; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <p class="tilte">Link url ảnh (dạng tròn)</p>
                </td>
                <td>
                    <input id="txb_thumb" class="txb" type="text" name="thumb" value="<?php echo $country->thumb; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <p class="tilte">Type</p>
                </td>
                <td>
                    <table class="">
                        <tr>
                            <?php
                                $freeCheck = "";
                                $premiumCheck = "";

                                if($country->isPremium == 0){
                                    $freeCheck = "checked";
                                }else{
                                    $premiumCheck = "checked";
                                }
                            ?>

                            <td>
                                <input id="radio_free" type="radio" name="isPremium" value="0" <?php echo $freeCheck;?>
                                <label style="font-size: 25px">Free</label><br>
                            </td>
                            <td>
                            <input type="radio" style="margin-left: 30px" name="isPremium" value="1" <?php echo $premiumCheck;?>
                                <label style="font-size: 25px">Premium</label><br>
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

    function validate(){

        var name = document.getElementById("txb_name").value;
        var thumb = document.getElementById("txb_thumb").value;
        var isFree = document.getElementById("radio_free").checked;
        var premium_text = "";
        if(isFree){
            premium_text = "FREE";
        }else{
            premium_text = "PREMIUM";
        }

        var isPass = true;
        var err_msg = "";

        if(name === ""){
            err_msg = err_msg + "- Vui lòng nhập tên Country";
            isPass = false;
        }

        if(thumb === ""){
            isPass = false;
            if(err_msg === ""){
                err_msg = err_msg + "- Vui lòng nhập link url ảnh";
            }else{
                err_msg = err_msg + "\n- Vui lòng nhập link url ảnh";
            }
        }
        
        if(isPass){

            if(confirm("Bạn thật sự muốn thêm Country này?\n- Tên Country: "+name+"\n- Url: "+thumb+"\n- Type: "+premium_text)){
                document.getElementById("hidden").value = "update_country";
                document.getElementById("form").submit();
            }

        }else{
            alert(err_msg);
        }
    }

    function back(){
        document.getElementById("hidden").value = "to_country_manage";
        document.getElementById("form").submit();
    }

</script>
</html>