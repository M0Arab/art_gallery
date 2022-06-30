<?php
session_start();
?>
<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous" defer></script>
        <link rel="stylesheet" href="index_style.css">
        <link rel="stylesheet" href="navbar_style.css">
        <script src="https://kit.fontawesome.com/c6fbf64d53.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="navbar">
            <div class="pagesLinksContainer">
                <?php

                    if($_SESSION['isArtist']){
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
                else{
                    echo '<a href="/crud/login.html">inloggen</a>';
                    echo '<a href="/crud/register_form.html">Account aanmaken</a>';
                }
            ?>
        </div>
        <div class="productsContainer">
            <?php
                require "db_connect.php";
                $query = "SELECT kunstwerken.id, 
                                kunstwerken.naam, 
                                kunstwerken.omschrijving, 
                                kunstwerken.jaar, 
                                kunstwerken.categorie, 
                                kunstwerken.afbeelding,
                                kunstwerken.prijs,
                                AVG(ratings.rating) as rating FROM kunstwerken
                                LEFT JOIN ratings ON ratings.art_id = kunstwerken.id GROUP BY kunstwerken.id;";
                $result = mysqli_query($db_connect,$query);
                if(mysqli_num_rows($result) > 0){
                    while($row = $result -> fetch_assoc()){
                        $art_id = $row["id"];
                        $image = $row["afbeelding"];
                        $title = $row["naam"];
                        $desc = $row["omschrijving"];
                        $year = $row["jaar"];
                        $category = $row["categorie"];
                        $price = $row["prijs"];
                        $rating = intval($row["rating"]);
                        echo '<div class="productCard">';
                        echo    '<div class="productImage">';
                        echo        "<img src=/crud/{$image} width='100%' height='100%' loading='lazy' />";
                        echo    '</div>';
                        echo    '<div class="productTitleWrapper">';
                        echo        "<h2>{$title}</h2>";
                        echo        "<p>{$year}</p>";
                        echo    '</div>';
                        echo    '<div class="productCategoryWrapper">';
                        echo        "<h4>{$category}</h4>";
                        echo    '</div>';
                        echo    '<div class="productDescWrapper">';
                        echo        "<p>{$desc}</p>";
                        echo    '</div>';
                        echo    '<div class="productActionsWrapper">';
                        echo        '<div class="productRatingWrapper">';
                        echo            "<p>{$rating}/5</p>";
                        echo            '<i class="fa-solid fa-star"></i>';
                        if(!$_SESSION['isArtist'] && isset($_SESSION['ID'])){
                            echo  "<button class='rateButton' onclick='openRatingModal(this)' id={$art_id}>rate me</button>";
                        }
                        else if($_SESSION['isArtist']){
                            echo  "<button class='deleteButton' onclick='deleteArt(this)' id={$art_id}>verwijderen</button>";
                            echo  "<button class='rateButton' onclick='editArt(this)' id={$art_id}>bewerken</button>";
                        }
                        echo        '</div>';
                        echo        '<div class="productPriceWrapper">';
                        if($price){
                            echo            "<h3>$ {$price}</h3>";
                        }
                        echo        '</div>';
                        echo    '</div>';
                        echo '</div>';
                    ;
                    }
                }
            ?>
        </div>
        <div class="modalWrapperInvisible" id="modalWrapper">

            <div class="ratingModal">
                <h1>Rate this art</h1>
                <div id="stars" class="starsWrapper">
                </div>
                <button class="rateButton" onclick="submitRating()">Submit</button>
            </div>
        </div>
    <script>
        var art_id = -1
        var rating = -1
        document.addEventListener("onload", generateStars())
        function openRatingModal(el){
            art_id = el.id
            const modalWrapper = document.getElementById("modalWrapper")
            modalWrapper.setAttribute("class","modalWrapper")

        }
        function setRating(new_rating){
            rating = new_rating
            generateStars()
        }
        function generateStars(){
            const starsHolder = document.getElementById("stars")
            starsHolder.innerHTML = ""
            for(var i = 0; i < 5; i++){
                let star_rating = i + 1
                if(rating > i){
                    starsHolder.innerHTML += '<i class="fa-solid fa-star fa-2xl filledStar" onclick="setRating(\'' + star_rating + '\')"></i>'
                }
                else{

                    starsHolder.innerHTML += '<i class="fa-regular fa-star fa-2xl emptyStar" onclick="setRating(\'' + star_rating + '\')"></i>'
                }

            }
        }
        function closeModal(){
            const modalWrapper = document.getElementById("modalWrapper")
            modalWrapper.setAttribute("class","modalWrapperInvisible")
        }
        function submitRating(){
            $.ajax({
                type: "POST",
                url : "/crud/insert_rating.php",
                data: {art_id : art_id, rating : rating},
                success: (res) =>{
                    closeModal()
                    location.reload()
                },
            })
        }

        function deleteArt(el){
            let delete_art_id = el.id
            $.ajax({
                type: "POST",
                url : "/crud/delete.php",
                data: {art_id : delete_art_id},
                success: (res) =>{
                    location.reload()
                },
            })
        }

        function editArt(el){
            const id = el.id
            location.href = "https://86888.ict-lab.nl/crud/update_product.php?p_id="+id
        }
    </script>
    </body>
</html>