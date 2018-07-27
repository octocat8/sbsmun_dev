<?php

require_once("config/db.php");
require_once("classes/Register.php");
    $registration = new Registration();
    include("views/register.php");
