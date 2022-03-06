<?php

require_once "core/autoLoader.php";

use Config\ConfigHandler;
use DB\DbConnection;

// instanciranje konekcije ako već nije bila
$bazaSingleton = DbConnection::getInstance(ConfigHandler::get("dbconfig"));

// provjera je li korisnik prijavljen - ako nije neće dozvoliti otvaranje index.php stranice bez prijave
$bazaSingleton->checkLogin();

$userList = $bazaSingleton->getUsers($_SESSION["username"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Chatbox</title>
</head>
<body>
    <div class="topnav">
        <a class="active" href="logout.php">Odjava</a>
    </div>
    <p>
        Pozdrav <?php echo $_SESSION["username"] ?>
    </p>
    <br>
    <h1> Popričajte malo s ljudima ovdje! </h1>

    <form action="./handlers/messageHandler.php" method="POST" autocomplete="off">
        <label for="sendto">Pošalji korisniku: </label>
        <select name="sendto" id="sendto">
        <?php
           foreach ($userList as $user) {
            echo "<option value='" . $user["id"] . "'>" . $user["username"] . "</option>";
        } 
        ?>
        </select>
        <br>
        <label for="message">Upišite željenu poruku za slanje:</label>
        <br>
        <textarea id="message" name="message" rows="4" cols="50"></textarea>
        <button>Pošalji!</button>
    </form>

</body>
</html>