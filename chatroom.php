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
    <title>Chatroom</title>
</head>
<body>
    <div class="topnav">
        <a class="active" href="logout.php">Odjava</a>
    </div>
    <h1> <?php echo $_SESSION["username"] ?> ovdje se nalaze svi vaši razgovori:</h1>
    <br>

        <?php

        $messages = $bazaSingleton->getUserMessages($_SESSION["username"]);
        $counter = 0;
        foreach($messages as $message){
            $counter++;
            echo "<p>[" . $counter . "] -> " . "Poruku poslao: " . $message["username"] . " " . "<br>Poruku primio: " 
            . " " .  $message["user_id_to"] . "<br>Sadržaj poruke: " . " " . $message["message"] . "</p><br>"; 
        }

        ?>

</body>
</html>