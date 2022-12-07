<?php
    session_start();
    if(!isset($_SESSION['is_login']) || $_SESSION['is_login'] == 'false'){
        include('../Constants.php');
        header("Location: $server_root");
    }
?>
<html>
    <body onLoad="
    <?php 
        if(isset($_REQUEST['status'])){
            if($_REQUEST['status'] == 1){
                echo "AddProxyCallback()";
            }else{
                echo "FailCallback()";
            }
        }
    ?>">
    <style>
        #txb_newproxy{
            height:40px; 
            width:290px;
            padding-left: 15px;
            font-size: 15; 
        }
        #table{
            width:1000;
        }
        #khoa_cbb{
            border: 2px solid #2A6759;
            width: 250;
            height: 40;
        }
        #add_cbb{
            border: 2px solid #2A6759;
            margin-left: 5px;
            width: 100;
            height: 40;
        }
        .btn{
            width: 100px;
            height: 40px;
            margin-left: 15px;
            border-radius: 5px;
            background-color: #13A684;
            color: #fff;
        }
        .btn_update{
            width: 100;
            height: 40;
            border-radius: 5px;
            background-color: #13A684;
            color: #fff;
        }
        .btn_delete{
            width: 100;
            height: 40;
            border-radius: 5px;
            background-color: indianred;
            color: #fff;
        }
        .item_cell{
            border-bottom: 2px solid #13A684;
            font-size: 17px;
        }
        #link_update{
            color: blue;
            text-decoration: none;
        }
        #link_delete{
            color: tomato;
            text-decoration: none;
        }
    </style>
    <?php
        include_once('../Model/M_Proxy.php');
        include_once('../Model/M_Country.php');
        include_once('../Constants.php');

        $control_dir = $server_root ."/Controller/Controller.php";

        $M_Proxy = new M_Proxy();
        $M_Country = new M_Country();

        $selected_country = $_REQUEST['selected_country'];

        $array_country = $M_Country->GetAllCountry();
        $array_proxy = $M_Proxy->GetListProxyByCountry($selected_country);
    ?>  
    <form id="form" method="post" action="<?php echo $control_dir;?>">
        <table id="table" align='center' cellspacing='0' cellpadding='0' border='0'>
            <tr>
                <td>
                    <table width="1000" cellspacing='0' cellpadding='30' border='0'> 
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <h3>Chọn quốc gia</h3>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="hidden" type="hidden" name="method">
                                            <input id="hidden1" type="hidden" name="update_id">
                                            <select name="selected_country" id="khoa_cbb">
                                                <?php
                                                    echo "<option value='0'>Tất cả</option>";
                                                    foreach($array_country as &$country) {

                                                        $selected = "";

                                                        if($selected_country==$country->id){
                                                            $selected = "selected";
                                                        }

                                                        echo "<option $selected value='$country->id'>$country->name</option>";
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <button class="btn" onclick="SeeProxyList()">Xem</button>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        <td>
                            <table border="0" cellspacing="0">
                                <tr>
                                    <h3>Thêm Proxy</h3>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="txb_newproxy" name="proxy" type="text" placeholder="Hostname:Port:Username:Password">
                                    </td>
                                    <td>
                                        <select name="added_country" id="add_cbb">
                                            <?php
                                                foreach($array_country as &$country) {

                                                    $selected = "";

                                                    if($selected_country==$country->id){
                                                        $selected = "selected";
                                                    }

                                                    echo "<option $selected value='$country->id'>$country->name</option>";
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn" onclick="Validate()">Thêm mới</button>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="1000" cellspacing='0' cellpadding='20' border_top='0'>
                        <tr>
                            <td class='item_cell'><strong>ID</strong></td>
                            <td class='item_cell'><strong>Hostname</strong></td>
                            <td class='item_cell'><strong>Port</strong></td>
                            <td class='item_cell'><strong>Username</strong></td>
                            <td class='item_cell'><strong>Password</strong></td>
                            <td class='item_cell'><strong>Country</strong></td>
                            <td class='item_cell'></td>
                            <td class='item_cell'></td>
                        </tr>
                        <?php
                            foreach($array_proxy as &$proxy){

                                $id = $proxy->id;
                                $host = $proxy->host;
                                $port = $proxy->port;
                                $username = $proxy->username;
                                $country = $M_Country->GetCountryByID($proxy->country_id);
                                $country_name = $country->name;
                                $inserted = NULL;

                                if(isset($_REQUEST["inserted"])){
                                    $inserted = $_REQUEST["inserted"];
                                }

                                echo "<tr>";

                                if($id === $inserted){
                                    echo "<td class='item_cell'><strong style='color: blue'>$id</strong></td>";
                                    echo "<td class='item_cell'><strong style='color: blue'>$host</strong></td>";
                                    echo "<td class='item_cell'><strong style='color: blue'>$port</strong></td>";
                                    echo "<td class='item_cell'><strong style='color: blue'>$username</strong></td>";
                                    echo "<td class='item_cell'><strong style='color: blue'>*******</strong></td>";
                                    echo "<td class='item_cell'><strong style='color: blue'>$country_name</strong></td>";
                                }else{
                                    echo "<td class='item_cell'>$id</td>";
                                    echo "<td class='item_cell'>$host</td>";
                                    echo "<td class='item_cell'>$port</td>";
                                    echo "<td class='item_cell'>$username</td>";
                                    echo "<td class='item_cell'>*******</td>";
                                    echo "<td class='item_cell'>$country_name</td>";
                                }

                                echo "<td class='item_cell'><button class='btn_update' onclick='UpdateProxy($id)'>Cập nhập</button></td>";
                                echo "<td class='item_cell'><button class='btn_delete' onclick='ConfirmDelete($id)'>Xóa</button></td>";
                                echo "</tr>";

                               
                            
                            }  
                        ?>
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

    function SeeProxyList(){
        document.getElementById("hidden").value = "see_proxy_list";
        document.getElementById("form").submit();
    }

    function Validate(){
        var proxy_str = document.getElementById("txb_newproxy").value;

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

        if(password === ""){
            isPass = false;
            if(err_msg === ""){
                err_msg = err_msg + "- Vui lòng nhập Password";
            }else{
                err_msg = err_msg + "\n- Vui lòng nhập Passsword";
            }
        }

        if(isPass){

            if(confirm("Bạn thật sự muốn thêm proxy này?\n- Hostname: "+host+"\n- Port: "+port+"\n- Username: "+username+"\n- Password: "+password)){
                document.getElementById("hidden").value = "add_proxy";
                document.getElementById("form").submit();
            }

        }else{
            alert(err_msg);
        }
    }

    function AddProxyCallback(status){
        alert("Cập nhập dữ liệu thành công!");
    }

    function FailCallback(){
        alert("Đã có lỗi xảy ra, vui lòng thử lại!");
    }

    function ConfirmDelete(val){
        if(confirm("Bạn thật sự muốn xóa proxy có ID = "+val+"?")){
            document.getElementById("hidden").value = "delete_proxy";
            document.getElementById("hidden1").value = val;
            document.getElementById("form").submit();
        }
    }

    function UpdateProxy(id){
        document.getElementById("hidden").value = "update_view";
        document.getElementById("hidden1").value = id;
        document.getElementById("form").submit();
    }
    
</script>
</html>