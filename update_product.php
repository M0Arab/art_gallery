<?php
require "db_connect.php";
session_start();
$art_id = $_GET["p_id"];
if(!$art_id && !$_SESSION["isArtist"]){
    return header("Location:index.php");
}
$row = "";
$query = "SELECT * FROM kunstwerken WHERE id={$art_id}";
$result = mysqli_query($db_connect,$query);
if(mysqli_num_rows($result) > 0){
     $row = $result ->fetch_assoc();
}
?>
<html>
<head>
    <link rel="stylesheet" href="navbar_style.css">
    <link rel="stylesheet" href="create_product_style.css">
</head>
<body>
<div class="navbar">
    <div class="pagesLinksContainer">
        <?php
        if(!$_SESSION['isArtist']){
            return header("Location:index.php");
        }
        else{
            echo '<a href="/crud/create_product.html">Create product</a>';
        }
        ?>
        <a href="">FAQ</a>
        <a href="/crud/index.php">Home</a>
    </div>

    <h1 class="username"><?php echo $_SESSION['name'];?></h1>
</div>
<div class="pageWrapper">
    <div class="artFormCard">

        <form class="artForm" method="post" action="update.php" enctype="multipart/form-data">
            <input type="hidden" name="p_id" value="<?php echo $art_id?>">
            <h1>Kunstwerk aanmaken</h1>
            <div>
                <p>Naam</p>
                <input type="text" name="name" id="name" placeholder="kunst naam" value="<?php echo $row['naam']?>">
            </div>
            <div>
                <p>Omschrijving</p>
                <textarea name="desc" id="desc" placeholder="kunst omschrijving" cols="50" rows="7" maxlength="200"><?php echo $row['omschrijving']?></textarea>
            </div>
            <div>
                <p>Jaar</p>
                <input type="number" name="year" id="year" placeholder="Jaar" value="<?php echo $row['jaar']?>">
            </div>
            <div>
                <p>Categorie</p>
                <input type="text" name="category" id="category" placeholder="Kunst categorie" value="<?php echo $row['categorie']?>">
            </div>
            <div>
                <p>Prijs</p>
                <input type="number" name="price" id="price" placeholder="Kunst prijs" value="<?php echo $row['prijs']?>">
            </div>
            <div>
                <p>Afbeelding</p>
                <input type="file" name="image" id="image">
            </div>

            <button class="submitButton" type="submit">Bevestig</button>
        </form>
    </div>
</div>
</body>
</html>