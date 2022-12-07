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
    include_once('../Model/M_Proxy.php');
    include_once('../Model/M_Country.php');
    include_once('../Constants.php');

    $control_dir = $server_root ."/Controller/Controller.php";
    $M_Country = new M_Country();

    $array_country = $M_Country->GetAllCountry();
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
    <form id="form" action="<?php echo $control_dir;?>">
    <input id="hidden" type="hidden" name="method">
    <input id="hidden1" type="hidden" name="update_id">
    <table width="1000" cellpadding="0" cellspacing="0" border="0" align='center'>

        <tr>
            <td>
                <table align='center'>
                    <tr>
                        <td>
                            <button class='btn_add' onclick='openAddCountry()'>Thêm mới Country</button>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td width="1000">
            <table width="1000" cellspacing='0' cellpadding='20' border_top='0'>
                        <tr>
                            <td class='item_cell'><strong>ID</strong></td>
                            <td class='item_cell'><strong>Thumbnail</strong></td>
                            <td class='item_cell'><strong>Country name</strong></td>
                            <td class='item_cell'><strong>Type</strong></td>
                            <td class='item_cell'></td>
                            <td class='item_cell'></td>
                        </tr>
                        <?php
                            foreach($array_country as &$country){

                                $id = $country->id;
                                $name = $country->name;
                                $isPremium = $country->isPremium;
                                $thumb = $country->thumb;

                                echo "<tr>";

                                echo "<td class='item_cell'>$id</td>";
                                echo "<td class='item_cell img'><img src='$thumb' width='70' height='70'></td>"; 
                                echo "<td class='item_cell'>$name</td>";

                                if($isPremium == 0){
                                    echo "<td class='item_cell'>FREE</td>";
                                }else{
                                    echo "<td class='item_cell'>
                                        <table>
                                            <tr>
                                                <td>
                                                    PREMIUM
                                                </td>
                                                <td>
                                                    <img src='https://cdn-icons-png.flaticon.com/512/3649/3649801.png' width='30' height='30'>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>";
                                }

                                echo "<td class='item_cell'><button class='btn_update' onclick='updateCountry($id)'>Cập nhập</button></td>";
                                echo "<td class='item_cell'><button class='btn_delete' onclick='confirmDelete($id)'>Xóa</button></td>";
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

    function openAddCountry(){
        document.getElementById("hidden").value = "add_country_view";
        document.getElementById("form").submit();
    }

    function updateCountry(id){
        document.getElementById("hidden").value = "update_country_view";
        document.getElementById("hidden1").value = id;
        document.getElementById("form").submit();
    }

    function confirmDelete(id){

        if(confirm("Bạn thực sự muốn xóa Country có ID = "+id+"?\nĐiều này sẽ đồng thời xóa toàn bộ Proxy của Country này!")){
            document.getElementById("hidden").value = "delete_country";
            document.getElementById("hidden1").value = id;
            document.getElementById("form").submit();
        }

    }

    function SuccessCallback(){
        alert("Cập nhập thông tin thành công!");
    }

    function FailCallback(){
        alert("Đã có lỗi xảy ra, vui lòng thử lại!");
    }
</script>
</html>