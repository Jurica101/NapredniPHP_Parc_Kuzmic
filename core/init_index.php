<?php
// Autoloader za automatsko učitavanje svih klasa (4.ZAD)
session_start();

spl_autoload_register(function ($class) {
    $parts = explode("\\", $class); // razbija putanju do klase pomoću \\ kao separatora
    include_once "classes/". end($parts) . ".php"; // uzima zadnji dio iz gornjeg explode-a i ubacuje ga u putanju gdje se nalaze klase a to je u folderu classes
});