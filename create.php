<?php
require "db_connect.php";
session_start();
$name = $_REQUEST['name'];
$desc = $_REQUEST['desc'];
$year = $_REQUEST['year'];
$category = $_REQUEST['category'];
$price = $_REQUEST['price'];
$target_dir = "/img/";
$imageFileType = strtolower(pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));
$target_file = $target_dir . basename(time(). "." . $imageFileType);

$image = $_FILES['image']['name'];
if(!$_SESSION['isArtist']){
    return header("Loction:index.php");
}
if($name && $desc && $year && $category && $image) {
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        return header("Location:create_product.php");
    }
    if(move_uploaded_file($_FILES['image']['tmp_name'],__DIR__.$target_file)){
        $query = "INSERT INTO kunstwerken (naam,omschrijving,jaar,categorie,afbeelding,prijs) VALUES 
                                           ('{$name}','{$desc}','{$year}','{$category}','{$target_file}','{$price}')";
        if(mysqli_query($db_connect,$query)){
            return header("Location:index.php");
        }
        else{
            echo "Het aanmaken van kunstwerk is niet gelukt \n u wordt automatisch doorgestuurd naar de vorige pagina";
            return header("Refresh:3, url=create_product.php");
        }
    }
    else{
        echo "failed to upload";
    }

}
else{
    echo "we are here";
}