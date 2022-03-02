<?php
// Datoteka s klasom za upravljanje konfiguracijskim datotekama koje se po konvenciji nalaze u direktoriju config (2.ZAD)

class ConfigHandler {
    private function __construct()
    {
        
    }

    public static function get($configFile = "") {
        if ($configFile) {
            // u ovaj kondicional se ulazi samo ako se upiše argument za $configFile kod pozivanja metode (naziv željene konfig datoteke)
            $loadedConnParam = require "../config/" . $configFile . ".php"; // potraži traženi config file unutar datoteke config i pripremi za učitavanje
            return $loadedConnParam; // vrati gornju naredbu za učitavanje kako bi se ono izvršilo
        } return false; // ukoliko je kao ulazni argument poslan prazni string - to je FALSY vrijednost pa će se uči u ovaj else segment kondicionala gdje je definirano da se vrati samo false vrijednost
    }
}