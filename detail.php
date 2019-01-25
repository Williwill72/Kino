<?php
    include("start.php");

    $movieId = $_GET['id'];

    $sql = "SELECT *
            FROM movie
            WHERE id=$movieId";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $movie = $stmt->fetch();

    $sql = "SELECT *
            FROM review
            WHERE movie_id=$movieId";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $reviews = $stmt->fetchAll();

    showTop("Kino | " . $movie["title"]);
?>
    <div class="container">
        <div id="image">
            <img src="img/<?= $movie['image'] ?>">
            <p><a class="button" href="add-review.php?id=<?= $movie['id'] ?>">Add a review</a></p>
            <p><a class="button" href="add_watchlist.php?id=<?= $movie['id'] ?>">Add to my watchlist</a></p>
        </div>
        <div class="text" id="infos-film">
            <h1><?= $movie["title"] ?></h1>

            <p><h2>rating:</h2>
            <?= $movie["rating"] ?></p>

            <p><h2>parution year:</h2>
            <?= $movie["year"] ?></p>

            <p><h2>genres:</h2>
            <?= $movie["genres"] ?></p>

            <p><h2>actors:</h2>
            <?= $movie["actors"] ?></p>

            <p><h2>director:</h2>
            <?= $movie["directors"] ?></p>

            <p><h2>résumé:</h2>
            <?= $movie["plot"] ?></p>

            <p><h2>runtime:</h2>
            <?= $movie["runtime"] ?> min</p>
        </div>
    </div>
    <div class="container">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $movie["trailer_id"] ?>"
                frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
        </iframe>
    </div>
    <div class="container columnFlex">
    <?php
        foreach ($reviews as $review){
         ?>
            <h2 class="text"><?= $review["title"] ?></h2>
            <p class="text">post at <?= $review["date_created"] ?></p>
            <p class="text"><?= $review["content"] ?></p>
        <?php
        }
    ?>
    </div>

<?php showBottom(); ?>