<?php
require "config/dbconfig.php";
require "classes/ConfigHandler.php";
require "classes/DbConnection.php";

session_start();

// $bazaSingleton = DbConnection::getInstance(ConfigHandler::get("dbconfig")); // ovaj objekt sada sadrži konekciju na bazu, ako je već prije postojao, koristi se postojeći objekt za konekciju
$bazaSingleton = DbConnection::getInstance(ConfigHandler::get("dbconfig")); // ovaj objekt sada sadrži konekciju na bazu, ako je već prije postojao, koristi se postojeći objekt za konekciju
$connection = $bazaSingleton->getConnection();

$stmt = $connection->prepare("SELECT username FROM users WHERE username != :username");
$stmt->execute(['username' => $_SESSION["username"]]); 
$userList = $stmt->fetch();

echo "Dobrodošao: " . $_SESSION["username"];

echo "<form action='' method='POST' autocomplete='off'>";
echo "<label for='message'>Poruka</label>";
echo "<input type='text' name='message' placeholder='Upišite poruku' id='message'>";
echo "<label for='sendto'>Pošalji korisniku</label>";
echo '<select name="sendto" id="sendto">';
foreach ($userList as $user) {
    echo "<option value='$user'>$user</option>";
}
echo "</select>";
echo "<button>Pošalji!</button>";
echo "</form>";