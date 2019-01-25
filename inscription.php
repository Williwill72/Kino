<?php
    include("start.php");

  //Contient les données du formulaire
  $username = "";
  $email = "";
  $password = "";

  //Contient les éventuels messages d'erreur
  $errors = [];

    //Est-ce que le formaulaire est soumis
    if(!empty($_POST)){
        //récupére les données dans nos variables
        $username   = strip_tags($_POST["username"]);
        $email      = strip_tags($_POST["email"]);
        $password   = $_POST["password"];

        //valider les données

        //Longueur du pseudo
        if(empty($username)){
            $errors['username'][] = "Please provide a username!";
        }
        elseif(strlen($username) < 2){
            $errors['username'][] = "Your username is too short! 2 characters minimum";
        }
        elseif(strlen($username) > 30){
            $errors['username'][] = "Your username is too long! 30 characters minimum";
        }

        $sql = "SELECT COUNT(*)
                FROM users
                WHERE username = :username";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([ ":username" => $username]);

        $result = $stmt->fetchColumn();
        if($result > 0){
            $errors['username'][] = 'Username is already taken!';
        }

        //Validité de l'email
        if(empty($email)){
            $errors['email'][] = "Please provide an email!";
        }
        //email valide?
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'][] = "Your email is not valid!";
        }

        $sql = "SELECT COUNT(*)
                FROM users
                WHERE email = :email";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([ ":email" => $email]);

        $result = $stmt->fetchColumn();
        if($result > 0){
            $errors['email'][] = 'You are already registered with this email!';
        }

        if(empty($password)){
            $errors["password"][] = "Please choose a password";
        }
        elseif (strlen($password) < 8){
            $errors["password"][] = "Minimum 8 characters please!";
        }

        //si tout est valide, on insére dans la base de données
        if(empty($errors)){
            $hash = password_hash($password, PASSWORD_ARGON2I);

            //on insére en bdd
            $sql = "INSERT INTO users(username, email, password, creation_date ) 
                    VALUES 
                    (:username, :email, :password, NOW());";
            //envoie la requête MySQL sans l'éxécuter
            $stmt = $dbh->prepare($sql);
            $stmt->execute([
                    ":username" => $username,
                    ":email" => $email,
                    ":password" => $hash
            ]);

            $_SESSION['flash'] = "Welcome at Kino $username!";

            //Redirige vers la liste des utilisateurs
            header("Location: index.php");

            die();
        }
    }

    showTop("Kino | Home");
?>

    <div class="container columnFlex alignItems">
    <h1 class="text">Formulaire d'inscription</h1>

    <form method="post">

        <div class="formulaire">
            <label for="username" class="text">Username</label>
            <input  type="text" name="username" id="username"
                   maxlength="30" placeholder="Willi" value="<?= $username ?>">
            <div class="error">
                <?php
                    if(!empty($errors['username'])) {
                        foreach ($errors['username'] as $message) {
                            echo "<p>$message</p>";
                        }
                    }
                ?>
            </div>
        </div>
        <div class="formulaire">
            <label for="email" class="text">Email</label>
            <input type="email" name="email" id="email"
                   maxlength="254" placeholder="test@gmail.com" value="<?= $email ?>">
            <div class="error">
                <?php
                    if(!empty($errors['email'])) {
                        foreach ($errors['email'] as $message) {
                            echo "<p>$message</p>";
                        }
                    }
                ?>
            </div>
        </div>
        <div class="formulaire">
            <label for="password" class="text">Password</label>
            <input type="password" name="password" id="password"
                   maxlength="10000">
            <p class="help">Minimum 8 caractères !</p>
            <div class="error">
                <?php
                    if(!empty($errors['password'])) {
                        foreach ($errors['password'] as $message) {
                            echo "<p>$message</p>";
                        }
                    }
                ?>
            </div>
        </div>

        <button>Send</button>
    </form>
    </div>

<?php showBottom(); ?>