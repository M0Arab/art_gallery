<?php
session_start();
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
                    echo '<a href="/crud/create_product.php">Create product</a>';
                }
            ?>
            <a href="/crud/questions.php">FAQ</a>
            <a href="/crud/index.php">Home</a>
        </div>

        <h1 class="username"><?php echo $_SESSION['name'];?></h1>
        <?php
            if(isset($_SESSION["ID"])){
                echo '<a href="/crud/logout.php">uitloggen</a>';
            }
        ?>
    </div>
    <div class="pageWrapper">
        <div class="artFormCard">

            <form class="artForm" method="post" action="create.php" enctype="multipart/form-data">
                <h1>Kunstwerk aanmaken</h1>
                <div>
                    <p>Naam</p>
                    <input type="text" name="name" id="name" placeholder="kunst naam">
                </div>
                <div>
                    <p>Omschrijving</p>
                    <textarea name="desc" id="desc" placeholder="kunst omschrijving" cols="50" rows="7" maxlength="200"></textarea>
                </div>
                <div>
                    <p>Jaar</p>
                    <input type="number" name="year" id="year" placeholder="Jaar">
                </div>
                <div>
                   <p>Categorie</p>
                    <input type="text" name="category" id="category" placeholder="Kunst categorie">
                </div>
                <div>
                    <p>Prijs</p>
                    <input type="number" name="price" id="price" placeholder="Kunst prijs">
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