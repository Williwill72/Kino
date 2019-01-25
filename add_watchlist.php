<?php
    include("start.php");
    $movie_id = $_GET['id'];
    $user_id = $_SESSION['user']['id'];

    $sql = "INSERT INTO watchlist VALUES ($movie_id, $user_id, NOW())";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    header("Location: detail.php?id=$movie_id");
