<?php
    include("start.php");

    $sql = "SELECT movie.* 
            FROM movie INNER JOIN watchlist ON movie.id = watchlist.movie_id
            WHERE user_id = " . $_SESSION['user']['id'];

    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $movies = $stmt->fetchAll();

    showTop("Kino | My watchList");
?>
            <div class="container">
            <?php
            foreach($movies as $movie) {
                ?>
                    <img src="img/<?= $movie['image'] ?>">
                <?php
            }
            ?>
            </div>


<?php showBottom(); ?>
