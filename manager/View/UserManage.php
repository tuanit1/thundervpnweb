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
    .btn {
        width: 100px;
        height: 40px;
        margin-left: 15px;
        border-radius: 5px;
        background-color: #13A684;
        color: #fff;
    }

    .btn_add {
        width: 200px;
        height: 40px;
        font-size: 20px;
        border-radius: 5px;
        background-color: #13A684;
        color: #fff;
    }

    .btn_update {
        width: 100px;
        height: 40px;
        border-radius: 5px;
        background-color: #13A684;
        color: #fff;
    }

    .btn_delete {
        width: 100px;
        height: 40px;
        border-radius: 5px;
        background-color: indianred;
        color: #fff;
    }

    .item_cell {
        border-bottom: 2px solid #13A684;
        font-size: 17px;
    }

    img {
        border: 1px solid #000;
        border-radius: 40px;
    }
</style>

<body onLoad="
    <?php 
        if(isset($_REQUEST['status'])){
            if($_REQUEST['status'] == 1){
                echo " SuccessCallback()"; }else{ echo "FailCallback()" ; } } ?>"
    >

    <?php
    include_once('../Model/M_User.php');
    include_once('../Constants.php');

    $control_dir = $server_root ."/Controller/Controller.php";
    $M_User = new M_User();


    if(isset($_REQUEST['search'])){
        $search = $_REQUEST['search'];
        $array_user = $M_User->GetSearchUser($search);
    }else{
        $array_user = $M_User->GetAllUser();
    }

    
?>

    <form id="form" method="post" action="<?php echo $control_dir;?>">
        <input id="hidden" type="hidden" name="method">
        <input id="hidden1" type="hidden" name="update_id">
        <table width="1200" cellpadding="0" cellspacing="0" border="0" align='center'>

            <tr>
                <td colspan="6" align="center">
                    <table width="600" border="0" cellpadding="">
                        <tr width="600">
                            <td>
                                <input id="search" name="search" type="text" placeholder="Tìm kiếm theo UID, Email, Tên"
                                    style="padding: 15px; margin-right:20px; width: 500px; font-size: 17px;" value="<?php
                                    if(isset($_REQUEST['search'])){
                                        echo $search;
                                    }
                                ?>" />
                            </td>
                            <td>
                                <button class='btn_update' onclick="Search()" value="">Tìm kiếm</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Result for
                                <?php
                                if(isset($_REQUEST['search'])){
                                    echo $search;
                                }
                            ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td width="1200">
                    <table width="1200" cellspacing='0' cellpadding='20' border_top='0'>
                        <tr>
                            <td class='item_cell'><strong>UID</strong></td>
                            <td class='item_cell'><strong>Email</strong></td>
                            <td class='item_cell'><strong>Tên</strong></td>
                            <td class='item_cell'><strong>Loại tài khoản</strong></td>
                            <td class='item_cell'><strong>Ngày hết hạn</strong></td>
                            <td class='item_cell'></td>
                        </tr>
                        <?php
                            foreach($array_user as &$user){

                                $uid = $user->uid;
                                $email = $user->email;
                                $name = $user->name;
                                $expired_date_str = $user->expired_date;

                                $expired_date = strtotime($expired_date_str);
                                $current_date = strtotime(date('Y-m-d H:i:s')); 

                                $str_date = (new DateTime($expired_date_str))->format('F d, Y');

                                if($expired_date <= $current_date){
                                    $isPremium = 0;
                                }else{
                                    $isPremium = 1;
                                }

                                echo "<tr>";

                                echo "<td class='item_cell'>$uid</td>";
                                echo "<td class='item_cell'>$email</td>";
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

                                if($isPremium == 0){
                                    echo "<td class='item_cell'>NONE</td>";
                                }else{
                                    echo "<td class='item_cell'>$str_date</td>";
                                }

                                echo "<td class='item_cell'><button class='btn_update' onclick='updateUser(\"". $uid . "\")'>Cập nhập</button></td>";
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
    document.getElementById("form").onsubmit = function (e) {
        e.preventDefault();
    }

    function updateUser(uid) {
        document.getElementById("hidden").value = "update_user_view";
        document.getElementById("hidden1").value = uid;
        document.getElementById("form").submit();
    }

    function SuccessCallback() {
        alert("Cập nhập thông tin thành công!");
    }

    function FailCallback() {
        alert("Đã có lỗi xảy ra, vui lòng thử lại!");
    }

    function Search() {
        var txb_search = document.getElementById("search");
        var text = txb_search.value;

        document.getElementById("hidden").value = "search_user";
        document.getElementById("form").submit();
    }
</script>

</html>