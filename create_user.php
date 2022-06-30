<?php
require "db_connect.php";
if(count($_REQUEST)>0) {
    $username = $_REQUEST["username"];
    $email = $_REQUEST["email"];
    $password = $_REQUEST["password"];
    $isArtist = 0;
    $userQuery = "SELECT * FROM login_users WHERE user='{$username}'";
    $res = mysqli_query($db_connect,$userQuery);
    if(mysqli_num_rows($res) > 0){
        echo "gebruikersnaam bestaat al, probeer een andere gebruikersnaam";
        return header("Refresh: 3, url=register_form.html");
    }
    $query = "INSERT INTO login_users (user,password,is_artist,email) VALUES ('{$username}','{$password}','{$isArtist}','{$email}')";

    if(mysqli_query($db_connect,$query)){
        echo "Uw account is aangemaakt";
        return header("Refresh: 3, url=index.php");
    }
    else{
        echo "Account aanmaken is niet gelukt";
        return header("Refresh: 3, url=index.php");
    }
}
else{
    echo "Account aanmaken is niet gelukt";
    return header("Refresh: 3, url=index.php");
}