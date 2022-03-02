<?php
require_once "../core/init.php";

class AuthSystem {
    private $user;
    private $pass;
    private $connection;

    function __construct($user, $pass)
    {
    // Instanciranje konekcije na bazu pomoću singleton principa iz DbConnection.php-a i klase getInstance (za punjenje konekcijskim parametrima koristi se klasa get) 
    $bazaSingleton = DbConnection::getInstance(ConfigHandler::get("dbconfig")); // ovaj objekt sada sadrži konekciju na bazu, ako je već prije postojao, koristi se postojeći objekt za konekciju
    $connection = $bazaSingleton->getConnection();
    
    if (empty($_POST["username"]) || empty($_POST["password"])) {
          $errMessage = "<label>Potrebno je popuniti sva polja!</label>";
      } else {
        $query = "SELECT * FROM users WHERE username = :username AND pass = :password";  
        $statement = $connection->prepare($query);
        $statement->bindParam("username", $user, PDO::PARAM_STR);
        $statement->bindParam("password", $pass, PDO::PARAM_STR); 
        $statement->execute();
        $count = $statement->rowCount();  
        if($count > 0)  
        {  
             $_SESSION["username"] = $_POST["username"];  
             header("location:../index.php");  
        }  
        else  
        {  
             $errMessage = "<label>Korisnik ili lozinka ne postoje</label>";  
        }   
      }
        
    }
}

