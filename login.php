<?php
    include("start.php");

    $usernameOrEmail = "";
    $password = "";

    if(!empty($_POST)) {
        $usernameOrEmail = $_POST["usernameoremail"];
        $password = $_POST["password"];

        $sql = "SELECT *
                FROM users
                WHERE username = '$usernameOrEmail'
                OR email = '$usernameOrEmail'";

        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $user = $stmt->fetch();

        if (!empty($user)) {
            $testPassword = password_verify($password, $user["password"]);

            if ($testPassword) {
                $_SESSION["user"] = $user;
                $_SESSION["flash"] = "Welcome back " . $user["username"] . "!";
                header("Location: index.php");
                die();
            }
        }
        else {
            $error = "Login or password are not correct!";
        }
    }

    showTop("Kino | Login");
?>

    <div class="container columnFlex alignItems">

        <h1 class="text">Login</h1>
        <form method="post">
            <?php
                if(!empty($error)){
                    ?>
                    <div class="error">
                        <p><?= $error ?></p>
                    </div>
                    <?php
                }
            ?>
            <div class="formulaire">
                <label for="usernameoremail" class="text">Username or email</label>
                <input maxlength="30" type="text" name="usernameoremail" id="usernameoremail"
                    value="<?= $usernameOrEmail ?>">
            </div>
            <div class="formulaire">
                <label for="password" class="text">Enter your password</label>
                <input maxlength="30" type="password" name="password" id="password">
            <div>
            <div class="formulaire">
            <button>Login</button>
            </div>
        </form>
    </div>

<?php showBottom(); ?>
