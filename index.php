<?php
    include("start.php");

    $search = "";
    $genre = "";

    if(!empty($_POST["search"]) || !empty($_POST["genre"])){
        $search = $_POST["search"];
        $genre = $_POST["genre"];

        if(!empty($_POST["random"])) {
            $sql = "SELECT *
                FROM movie
                WHERE title LIKE '%$search%' && genres LIKE '%$genre%'
                ORDER BY RAND()
                LIMIT 40";
        }
        else{
            $sql = "SELECT *
                FROM movie
                WHERE title LIKE '%$search%' && genres LIKE '%$genre%'
                LIMIT 40";
        }
    }
    elseif(!empty($_POST["paging"])) {
        $paging = $_POST["paging"];
        $sql = "SELECT *
                FROM movie
                WHERE id > (($paging-1)*40) AND id <= ($paging*40)";
    }
    else{
        $sql = "SELECT *
            FROM movie
            ORDER BY RAND()
            LIMIT 40";
    }

    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $movies = $stmt->fetchAll();

    showTop("Kino | Home");
?>
        <div>
            <div class="container">
                <form method="post">
                    <label for="Random" class="text">Random</label>
                    <?php
                        if(!empty($_POST["random"])) {
                            ?>
                            <input type="checkbox" name="random" id="Random" checked>
                            <?php
                        }else {
                            ?>
                            <input type="checkbox" name="random" id="Random">
                            <?php
                        }
                    ?>

                    <input type="search" name="search" value="<?= $search ?>">
                    <select name="genre">
                        <option></option>
                        <option>Action</option>
                        <option>Adventure</option>
                        <option>Animation</option>
                        <option>Comedy</option>
                        <option>Crime</option>
                        <option>Drama</option>
                        <option>Family</option>
                        <option>Fantasy</option>
                        <option>History</option>
                        <option>Horror</option>
                        <option>Musical</option>
                        <option>Music</option>
                        <option>Mystery</option>
                        <option>Romance</option>
                        <option>Sci-Fi</option>
                        <option>Thriller</option>
                        <option>War</option>
                    </select>
                    <button>Search</button>
                </form>
            </div>
        <?php
            $j=0;
            for($i=0; $i<(ceil(count($movies)/5)) || $i<8; $i++) {
                echo '<div class="container">';
                for(;$j<(($i*5)+5);$j++) {
                    //echo '<img src="img/' . $movies[$j]['image'] . '">';

                    //ou ...
                    if(!empty($movies[$j])) {
                        ?>
                        <a href="detail.php?id=<?= $movies[$j]['id'] ?>">
                            <img src="img/<?= $movies[$j]['image'] ?>" class="img">
                        </a>
                        <?php
                    }
                }
                echo "</div>";
            }
        ?>
            <div class="container">
                <?php

                        for($i=0; $i<20;$i++) {
                            ?>
                            <form method="post" action="index.php">
                                <?php
                                    if(!empty($paging) && $paging == ($i+1)) {
                                        ?>
                                        <button class="paging" name="paging" id="actualPage"
                                                value="<?= $i + 1 ?>"><?= $i + 1 ?></button>
                                        <?php
                                    }
                                    else {
                                        ?>
                                        <button class="paging" name="paging"
                                                value="<?= $i + 1 ?>"><?= $i + 1 ?></button>
                                        <?php
                                    }
                                ?>
                            </form>
                            <?php
                        }
                ?>
            </div>
        </div>


<?php showBottom(); ?>