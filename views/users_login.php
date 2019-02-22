<?php
session_start();
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
?>

<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://puteborgne.sexy/_css/normalize.css"/>
    <link rel="stylesheet" href="https://puteborgne.sexy/_css/skeleton.css"/>
    <style>
        fieldset {
            border: 0.25rem solid rgba(225, 225, 225, 0.5);
            border-radius: 4px;
            padding: 1rem 2rem;
        }

        .errors {
            color: #ff5555;
        }
    </style>
</head>

<body>
<?php require_once('../components/nav.php') ?>
<div class="container">

    <div class="row">

        <ul class="errors">
            <?php
            foreach ($errors as $error) {
                echo("<li>" . $error . "</li>");
            }
            ?>
        </ul>

        <form method="post" action="../controllers/users_controller.php?action=login" id="userLoginForm">
            <fieldset>
                <legend>LOGIN</legend>
                <label for="userLogin">login</label>
                <input type="text" id="userLogin" name="login" value="">
                <label for="userPassword">password</label>
                <input type="password" id="userLogin" name="password" value="">
            </fieldset>
            <input type="submit" value="Envoyer" class="button-primary">
        </form>
    </div>

    <div class="row">
        <div class="column">
            $_SESSION
            <pre><?php print_r($_SESSION) ?></pre>
        </div>

    </div>

    <div class="row">
        <div class="one-half column">
            $_GET
            <pre><?php print_r($_GET) ?></pre>
        </div>
        <div class="one-half column">
            $_POST :
            <pre><?php print_r($_POST) ?></pre>
        </div>
    </div>

</div>
</body>
</html>