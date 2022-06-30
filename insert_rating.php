<?php
require "db_connect.php";
session_start();
$art_id = $_POST['art_id'];
$rating = $_POST['rating'];
$user_rating = "SELECT * FROM ratings WHERE user_id={$_SESSION['ID']} AND art_id={$art_id}";
$result = mysqli_query($db_connect,$user_rating);
if(mysqli_num_rows($result) == 0 && !$_SESSION['isArtist']){
    $query = "INSERT INTO ratings (user_id,art_id,rating) VALUES ({$_SESSION['ID']},{$art_id},{$rating})";
    $is_inserted = mysqli_query($db_connect,$query);
    if($is_inserted){
        echo "true";
    }
    else{
        echo "false";
    }
}
else{
    echo "cannot rate picture";
}


