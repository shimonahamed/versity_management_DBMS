<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Students page loaded";

require_once "../config/database.php";
require_once "../includes/auth.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";