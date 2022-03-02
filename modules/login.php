<?php
require_once "../core/init_modules.php";

$authentication = new AuthSystem($_POST["username"], $_POST["password"]);