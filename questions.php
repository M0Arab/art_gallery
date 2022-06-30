<?php
session_start();
?>
<html>
    <head>
        <link rel="stylesheet" href="navbar_style.css">
        <link rel="stylesheet" href="questions_style.css">
        <script src="https://kit.fontawesome.com/c6fbf64d53.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="questionButtonWrapper" onclick="openQuestionModel()">
            <i class="fa-solid fa-circle-plus fa-2xl" style="color: #3fd5fa"></i>
        </div>
        <div class="modalWrapperInvisible" id="question_modal">
            <div class="closeModalButton" onclick="closeQuestionModal()">
                <i class="fa-solid fa-xmark fa-2xl" style="color: white"></i>
            </div>
            <div class="questionFormModal">
                <form action="insert_question.php" method="post">

                    <h1>Vraag stellen</h1>
                    <div>
                        <h3>Vraag</h3>
                        <textarea maxlength="200" cols="50" rows="9" name="question" placeholder="uw vraag..."></textarea>
                    </div>
                    <button class="answerButton">Bevestig</button>
                </form>
            </div>
        </div>


        <div class="modalWrapperInvisible" id="answer_modal">
            <div class="closeModalButton" onclick="closeQuestionModal()">
                <i class="fa-solid fa-xmark fa-2xl" style="color: white"></i>
            </div>
            <div class="answerFormModal">
                <form action="answer_question.php" method="post">
                    <input type="hidden" name="q_id" id="q_id" value="">
                    <h1>Vraag beantwoorden</h1>
                    <div>
                        <h3>Het antwoord</h3>
                        <textarea maxlength="200" cols="50" rows="9" name="reply" placeholder="uw vraag..."></textarea>
                    </div>
                    <button class="answerButton">Bevestig</button>
                </form>
            </div>

        </div>
        <div class="navbar">
            <div class="pagesLinksContainer">
                <?php
                if ($_SESSION['isArtist']){
                    echo '<a href="/crud/create_product.php">Create product</a>';
                }
                ?>
                <a href="">FAQ</a>
                <a href="/crud/index.php">Home</a>
            </div>

            <h1 class="username"><?php echo $_SESSION['name'];?></h1>
            <?php
            if(isset($_SESSION["ID"])){
                echo '<a href="/crud/logout.php">uitloggen</a>';
            }
            ?>
        </div>
        <div class="questionsContainer">
            <?php
            require "db_connect.php";
            $query = "SELECT * FROM questions ORDER BY created_at DESC";
            $results = mysqli_query($db_connect,$query);
            if(mysqli_num_rows($results) > 0){
                while($row = $results -> fetch_assoc()){
                    $q_id = $row['ID'];
                    $q = $row["question"];
                    $a = $row["reply"];
                    echo '<div class="itemWrapper">';
                    echo        '<div class="questionWrapper">';
                    echo        "<p>{$q}</p>";
                    if($_SESSION['isArtist']){
                        echo        '<button class="answerButton" onclick="openAnswerModal(' .$q_id. ')">Answer</button>';
                    }
                    echo     '</div>';
                    echo    '<div class="answerWrapper">';
                    if($a == ""){
                        echo "<p>Er is nog geen antwoord op deze vraag</p>";
                    }
                    else{
                        echo "<p>{$a}</p>";
                    }
                    echo    '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <script>
            var coll = document.getElementsByClassName("questionWrapper");
            var i;

            for (i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function() {
                    var content = this.nextElementSibling;
                    if (content.style.display === "block") {
                        content.style.display = "none";
                    } else {
                        content.style.display = "block";
                    }
                });
            }

            function openQuestionModel(){
                const modal = document.getElementById("question_modal")
                modal.setAttribute("class","modalWrapper")
            }

            function closeQuestionModal(){
                const modal = document.getElementById("question_modal")
                modal.setAttribute("class","modalWrapperInvisible")
            }

            function closeAnswerModal(){
                const modal = document.getElementById("answer_modal")
                modal.setAttribute("class","modalWrapperInvisible")
            }

            function openAnswerModal(question_id){
                const modal = document.getElementById("answer_modal")
                const q_id_input = document.getElementById("q_id")
                q_id_input.value = question_id
                modal.setAttribute("class","modalWrapper")
            }
        </script>
    </body>
</html>