<?php

require_once "../core/autoLoader.php";

use Config\ConfigHandler;
use DB\DbConnection;

if(isset($_POST)){
    $bazaSingleton = DbConnection::getInstance(ConfigHandler::get("dbconfig"));

    $username = $_POST["username"];
    $password = $_POST["password"];

    $bazaSingleton->login($username,$password);
}