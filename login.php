<?php
    require "db_connect.php";
    session_start();
    $message="";
    if(count($_REQUEST)>0) {
        $query = "SELECT * FROM `login_users` WHERE `user` = '".$_REQUEST["username"]."' AND `password` = '".$_REQUEST["password"]."'";
        $result = mysqli_query($db_connect, $query);
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $_SESSION["ID"] = $row['ID'];
            $_SESSION["name"] = $row['user'];
            $_SESSION["isArtist"] = $row['is_artist'];
        }
        else {
            return header("Location:login.html");
        }
    }
    if(isset($_SESSION["ID"])) {
        return header("Location: index.php ");
    }