<?php
require "db_connect.php";
session_start();
$question_id = $_REQUEST["q_id"];
$reply = $_REQUEST['reply'];

if($question_id && $reply && $_SESSION['isArtist']){
    $query = "UPDATE questions SET reply='$reply' WHERE ID=$question_id";
    if(mysqli_query($db_connect,$query)){
        return header("Location:questions.php");
    }
    else{
        echo "Het beantwoorden van deze vraag is niet gelukt, probeer op een later moment";
        return header("Refresh: 3, url=questions.php");
    }
}
else{
    echo "Het beantwoorden van deze vraag is niet gelukt, probeer op een later moment";
    return header("Refresh: 3, url=questions.php");
}