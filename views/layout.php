<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<!--    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">-->
    <link rel="stylesheet" type="text/css" href="/assets/styles/styles.css" media="screen">

    <title>Register-Login-System</title>
</head>
<body>
<?php


// Vérification si nous sommes sur la page d'authentification en utilisant l'URL d'accès
$isAuthPage = $_SERVER['REQUEST_URI'] == '/auth' || $_SERVER['REQUEST_URI'] == '/auth/';

// Vérifie si l'utilisateur est connecté
$isUserLoggedIn = isset($_SESSION['user']);

//Si l'utilisateur est connecté et que nous ne sommes pas sur la page d'authentification, inclure le header
if ($isUserLoggedIn && !$isAuthPage):
    ?>
    <header>
        <?php
        // Vérifie le rôle de l'utilisateur et inclure le header approprié
        if ($_SESSION['user']['role'] == 2) {
            require __DIR__ . '/templates/header/header-admin.phtml';
        } elseif ($_SESSION['user']['role'] == 1) {
            require __DIR__ . '/templates/header/header.phtml';
        }
        ?>
    </header>
    <?php endif; ?>
    <main>
        <?php
        extract($this->data);
        require "views/templates/$this->template";

        ?>
    </main>

    <?php
    if ($isUserLoggedIn && !$isAuthPage):
        ?>
    <footer>
        <?php
        if ($_SESSION['user']['role'] == 2) {
            require __DIR__ . '/templates/footer/footer-admin.phtml';
        } elseif ($_SESSION['user']['role'] == 1) {
            require __DIR__ . '/templates/footer/footer.phtml';
        }
        ?>
    </footer>
<?php endif; ?>

<script src="/assets/js/burger.js"></script>


</body>
</html>
