<?php

require "db_connect.php";
session_start();
$art_id = $_REQUEST['p_id'];
$name = $_REQUEST['name'];
$desc = $_REQUEST['desc'];
$year = $_REQUEST['year'];
$category = $_REQUEST['category'];
$price = $_REQUEST['price'];
$target_dir = "/img/";
$imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
$target_file = $target_dir . basename(time() . "." . $imageFileType);

$image = $_FILES['image']['name'];
if (!$_SESSION['isArtist']) {
    return header("Loction:index.php");
}
if ($name && $desc && $year && $category) {
    if($image != ""){
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            return header("Location:index.php");
        }
        if (move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . $target_file)) {
            $query = "UPDATE kunstwerken SET naam='{$name}',omschrijving='{$desc}',jaar='{$year}',categorie='{$category}',afbeelding='{$target_file}',prijs='{$price}' WHERE id={$art_id}";
            if (mysqli_query($db_connect, $query)) {
                return header("Location:index.php");
            } else {
                echo "Het aanmaken van kunstwerk is niet gelukt \n u wordt automatisch doorgestuurd naar de hoofdpagina";
                return header("Refresh:3, url=index.php");
            }
        } else {
            echo "failed to upload";
        }
    }
    else{
        $query = "UPDATE kunstwerken SET naam='{$name}',omschrijving='{$desc}',jaar='{$year}',categorie='{$category}',prijs='{$price}' WHERE id={$art_id}";
        if (mysqli_query($db_connect, $query)) {
            return header("Location:index.php");
        } else {
            echo "Het aanmaken van kunstwerk is niet gelukt \n u wordt automatisch doorgestuurd naar de hoofdpagina";
            return header("Refresh:3, url=index.php");
        }
    }
}
else {
    echo "missing values";
    return header("Refresh:3, url=index.php");
}