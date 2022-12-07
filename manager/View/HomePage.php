<?php
    session_start();
    if(!isset($_SESSION['is_login']) || $_SESSION['is_login'] == 'false'){
        include('../Constants.php');
        header("Location: $server_root");
    }

    include_once('../Constants.php');
    $control_dir = $server_root ."/Controller/Controller.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThunderVPN Manager</title>
    <link rel = "icon" href = 
        "../ic_app.png"
        type = "image/x-icon">
</head>
<frameset rows="100,*" border="0">
    <frame name="top" src="top.html" scrolling="auto">
    <frame name="right" src="ProxyManage.php?selected_country=0" scrolling="auto">
</frameset>

</html>