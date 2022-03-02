<?php
// Kreiranje klase za konekciju na bazu podataka korištenjem PDO drivera - po singleton-e principu (3.ZAD)

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
}