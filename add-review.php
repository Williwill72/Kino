<?php
    include("start.php");

    $titre = "";
    $content = "";

    if(!empty($_POST)) {

        $title = strip_tags($_POST["title"]);
        $review = strip_tags($_POST["review"]);

        //on insére en bdd
        $sql = "INSERT INTO review(movie_id, title, content, date_created) 
                VALUES 
                (:movie_id, :title, :review, NOW());";
        //envoie la requête MySQL sans l'éxécuter
        $stmt = $dbh->prepare($sql);
        $stmt->execute([
            ":movie_id" => $_GET["id"],
            ":title" => $title,
            ":review" => $review
        ]);

        //Redirige vers la liste des utilisateurs
        header("Location: detail.php?id=" . $_GET["id"]);
    }

    showTop("Kino | Review");

?>


            <form method="post">
                <div class="container columnFlex">
                    <label for="title" class="text">Titre</label>
                    <input type="text" name="title" id="title" maxlength="30">
                    <label for="review" class="text">Review</label>
                    <textarea name="review" id="review" cols="10"></textarea>
                </div>

                <button>Send</button>
            </form>

<?php showBottom(); ?>
