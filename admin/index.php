<?php
    require_once("config/db.php");
    require_once("classes/Login.php");
    $login = new Login();
    if ($login->isUserLoggedIn()) {
        include("views/logged_in.php");
    } else {
        include("view/not_logged_in.php");
    }