<?php
// Kreiranje klase za konekciju na bazu podataka i manipulaciju s podacima (čitanje, pisanje) korištenjem PDO drivera - po singleton-e principu (3.ZAD)

namespace DB;
use PDO;
use PDOException;

class DbConnection {
    private static $instance = null; // svojstvo za obilježavanje je li klasa već instancirana ili nije (potrebna provjera kako bi se držali singleton principa)
    private $conn; // svojstvo koje će se sadržavati objekt za konekciju instanciran iz same klase u kojem se nalazi (po singleton principu postoji samo jedan objekt)

    // priprema svojstava koja će se koristiti kao kasniji parametri za konstruktor
    private $driver;
    private $host;
    private $dbname;
    private $user;
    private $pass;

    // Konstruktor za čiji ulaz će pri instanciranju klase služiti konekcijski parametri definirani unutar dbconfig.php datoteke odnosno ta datoteka
    private function __construct($connectionParameters) {
        // slijedi mapiranje elemenata ulaznog argumenta $connectionParameters koji će sadržavati array s konf.parametrima iz dbconfig.php sa odgovarajućim svojstvima ovdje
        $this->driver = $connectionParameters["driver"];
        $this->host = $connectionParameters["host"];
        $this->dbname = $connectionParameters["dbname"];
        $this->user = $connectionParameters["user"];
        $this->pass = $connectionParameters["pass"];
        
        // sada slijedi kreiranje (instanciranje) konekcije pomoću PDO drivera (PDO klase u PHP-u) i njegove sintakse koja se mapira na privatni objekt $conn (znači da se objekt može koristiti samo unutar ove klase)
        $this->conn = new PDO ("$this->driver:host=$this->host;dbname=$this->dbname", $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); // ovaj poslijednji array sadrži naredbu za egzekuciju pri svakoj konekciji - definirano je SQL jezikom da se character set u bazi postavi na utf8 koji sadrži i naše dijakritičke znakove
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setAttribute postavlja interni PDO atribut naziva ATTR_ERRMODE koji sadrži postavku za to kako će se izvoditi error reporting - postavlja tu postavku na ERRMODE_EXCEPTION što znači da će se prikazivati svi exception-i na koje se naiđe pri izvršavanju koda
    }

    // Sada slijedi logika ključna za dobivanje singleton paradigme u ovoj klasi
    public static function getInstance($loadedConnParam) {
        if(!self::$instance) {
          self::$instance = new DbConnection($loadedConnParam);
        } return self::$instance;       
    }
    // Funkcija za dohvaćanje kreirane konekcije
    public function getConnection()
    {
      return $this->conn;
    }

    // Funkcija za dohvaćanje poruka trenutno ulogiranog korisnika
    public function getUserMessages($usernameID)
      {
        try {
          $stmt = $this->conn->prepare("SELECT chat.id, message, user_id_from, username, user_id_to FROM chat INNER JOIN users ON chat.user_id_from = users.id WHERE users.username = :username");
          $stmt->bindParam(':username', $usernameID);
          
          $stmt->execute();


          // postaviti da je rezultirajući niz asocijativan
          $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
          return $stmt->fetchAll();
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
          die();
        }
      }

      public function getUserNameTo ($messageId)
      {
        try {
          $stmt = $this->conn->prepare("SELECT username FROM users INNER JOIN chat ON chat.user_id_to = users.id WHERE chat.id = :messageid");
          $stmt->bindParam(':messageid', $messageId);
          
          $stmt->execute();


          // postaviti da je rezultirajući niz asocijativan
          $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
          return $stmt->fetchAll();
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
          die();
        }
      }

    
      // Funkcija za dohvaćanje svih korisnika iz baze
    public function getAllUsers() {
        try {
          $stmt = $this->conn->prepare("SELECT * FROM users");
          $stmt->execute();
    
          // postaviti da je rezultirajući niz asocijativan
          $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
          echo $result;
          return $stmt->fetchAll();
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
          die();
        }
      }

    // Funkcija za dohvaćanje korisnika kojima je moguće poslati poruku
    public function getUsers($loggedInUser) {
        try {
          $stmt = $this->conn->prepare("SELECT username, id FROM users WHERE username != :loggedInUser");
          $stmt->bindParam(':loggedInUser', $loggedInUser);
          $stmt->execute();

          // postaviti da je rezultirajući niz asocijativan
          //$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
          //echo $result;
          return $stmt->fetchAll();
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
          die();
        }
      }
    
    // Funkcija za kreiranje poruke i slanje drugom korisniku prema njegovom $userIdFrom-u
    public function createMessage($message, $userIdFrom, $userIdTo)
      {
        try {
          $stmt = $this->conn->prepare("INSERT INTO chat (message, user_id_from, user_id_to) VALUES (:message, :userIdFrom, :userIdTo)");
          $stmt->bindParam(':message', $message);
          $stmt->bindParam(':userIdFrom', $userIdFrom);
          $stmt->bindParam(':userIdTo', $userIdTo);
          $stmt->execute();
          return header("location: ../chatroom.php");
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
      }
    
    // Funkcija za upravljanje autentifikacijom pri prijavi korisnika
    public function login($username, $password) {
          $users = $this->getAllUsers();
          foreach($users as $user){
            if($user["username"] == $username && $user["pass"] == $password){
              session_start();
              $_SESSION["loggedin"] = true;
              $_SESSION["username"] = $username;
              $_SESSION["userId"] = $user["id"];
              return header("location: ../index.php");
            }
            else {
              return header("location: ../index.php?message=wrong_credentials");
            }
          }
      }
    
    // Funkcija za provjeru je li korisnik prijavljen ili nije 
    public function checkLogin() {
      if($_SESSION["loggedin"] == true){
          return true;
        }
        else {
          header("location: login.php");
        }
      }
}