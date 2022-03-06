<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Prijava</title>
</head>
<body>
    <div class="topnav">
        <a class="active" href="">Prijava</a>
    </div>
    <form action="handlers/loginHandler.php" method="POST" autocomplete="off">
        <h1>Prijava</h1>

        <label for="username">Korisničko ime</label>
        <input type="text" name="username" placeholder="Korisničko ime" id="username">

        <label for="password">Lozinka</label>
        <input type="password" name="password" placeholder="Lozinka" id="password">

        <button>Prijava</button>
    </form>
    <?php
        if(isset($_GET["message"])) {
            echo $_GET["message"];
        }
    ?>
</body>
</html>