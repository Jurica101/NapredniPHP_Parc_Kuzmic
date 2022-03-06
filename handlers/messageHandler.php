<?php
require_once "../core/autoLoader.php";

use Config\ConfigHandler;
use DB\DbConnection;

if(isset($_POST)){
    $bazaSingleton = DbConnection::getInstance(ConfigHandler::get("dbconfig"));

    $message = $_POST["message"];
    $userIdFrom = $_SESSION["userId"];
    $userIdTo = $_POST["sendto"];

    echo $message;
    echo $userIdFrom;
    echo $userIdTo;


    $bazaSingleton->createMessage($message, $userIdFrom, $userIdTo);
}