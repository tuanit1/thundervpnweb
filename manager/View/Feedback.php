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
            font-size: 17px;
        }
        img{
            border: 1px solid #000;
            border-radius: 40px;
        }
    </style>
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

<?php
    include_once('../Model/M_Feedback.php');
    include_once('../Model/M_User.php');
    include_once('../Constants.php');

    $control_dir = $server_root ."/Controller/Controller.php";
    $M_Feedback = new M_Feedback();
    $M_User = new M_User();

    $array_feedback = $M_Feedback->GetAllFeedback();

?>  

<form id="form" method="post" action="<?php echo $control_dir;?>">
    <input id="hidden" type="hidden" name="method">
    <input id="hidden1" type="hidden" name="update_id">
    <table width="1200" cellpadding="0" cellspacing="0" border="0" align='center'>
        <tr>
            <td width="1200">
            <table width="1200" cellspacing='0' cellpadding='20' border_top='0'>
                        <tr>
                            <td class='item_cell'><strong>ID</strong></td>
                            <td class='item_cell'><strong>Email</strong></td>
                            <td class='item_cell'><strong>Tên</strong></td>
                            <td class='item_cell'><strong>Ngày</strong></td>
                            <td class='item_cell'><strong>Nội dung</strong></td>
                            <td class='item_cell'></td>
                        </tr>
                        <?php
                            foreach($array_feedback as &$feedback) {

                                $id = $feedback->id;
                                $message = $feedback->message;
                                $user_id = $feedback->user_id;
                                $date = $feedback->date;

                                $user = $M_User->GetUserByID($feedback->user_id);
                                
                                $name = $user->name;
                                $email = $user->email;

                                $str_date = (new DateTime($date))->format('Y-m-d H:i:s');

                                echo "<tr>";

                                echo "<td class='item_cell'>$id</td>";
                                echo "<td class='item_cell'>$email</td>";
                                echo "<td class='item_cell'>$name</td>";
                                echo "<td class='item_cell'>$str_date</td>";
                                echo "<td class='item_cell'>
                                    <textarea rows='5' cols='40' name='message' style='padding: 10px; font-size: 17px'>$message</textarea>
                                </td>";

                                echo "<td class='item_cell'><button onclick='deleteFeedback($id)' class='btn_delete'>Xóa</button></td>";
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

    function deleteFeedback(id){

        if(confirm("Bạn thật sự muốn xóa feedback có ID = "+id)){
            document.getElementById("hidden").value = "delete_feedback";
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

    function Search(){
        var txb_search = document.getElementById("search");
        var text = txb_search.value;

        document.getElementById("hidden").value = "search_user";
        document.getElementById("form").submit(); 
    }
</script>
</html>