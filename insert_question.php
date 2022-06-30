<?php
require "db_connect.php";
session_start();
$question = $_REQUEST["question"];
$reply = "";
if($question && !$_SESSION["isArtist"]){
    $query = "INSERT INTO questions (user_id,question,reply) VALUES ('{$_SESSION['ID']}','{$question}','{$reply}')";
    if(mysqli_query($db_connect, $query)){
        echo "Uw vraag is aangemaakt, u wordt naar de FAQ pagina doorgestuurd";
        return header("Refresh: 3, url=questions.php");
    }
    else{
        echo "Er ging iets fout, probeer op een later moment. u wordt naar de FAQ pagina doorgestuurd";
        return header("Refresh: 4, url=questions.php");
    }
}
else{
    echo "U bent niet toegestaan om een vraag aan te maken";
    return header("Refresh:3, url=questions.php");
}