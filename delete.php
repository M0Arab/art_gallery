<?php
require "db_connect.php";
session_start();
$art_id = $_REQUEST["art_id"];
if($art_id && $_SESSION['isArtist']){
    $get_art_query = "SELECT * FROM kunstwerken WHERE ID={$art_id}";
    $match_res = mysqli_query($db_connect,$get_art_query);
    $match = $match_res -> fetch_assoc();
    unlink(__DIR__.$match["afbeelding"]);
    $query = "DELETE FROM kunstwerken WHERE ID={$art_id}";
    $ratings_query = "DELETE FROM ratings WHERE art_id={$art_id}";
    $ratings_res = mysqli_query($db_connect,$ratings_query);
    $query_res = mysqli_query($db_connect,$query);
    if($ratings_res && $query_res){
        echo "true";
    }
    else{
        echo "false";
    }
}
else{
    echo "false";
}