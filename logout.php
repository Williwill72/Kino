<?php
    include("start.php");
    session_destroy();
    header("Location: index.php");