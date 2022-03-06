<?php
session_start();
 
// Ukloni sve vrijednosti iz superglobalne varijable za trenutnu sesiju
$_SESSION = array();
 
// Uništi trenutnu sesiju
session_destroy();
 
// Preusmjeri nazad na login stranicu
header("location: login.php");
exit;