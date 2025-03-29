<?php
    require_once("database.php");
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodRecipe</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Playwrite+HU:wght@100..400&family=Sigmar&display=swap');
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #ffc9b9;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" style="font-family: 'Playwrite HU', cursive;" href="index.php">FoodRecipe</a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="DailyRecipe.php">Günün Tarifi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="MyRecipes.php">Tariflerim</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="AddRecipe.php">Tarif Ekle</a>
            </li>
            <?php if(!isset($_SESSION["UserID"])): ?>
            <li class="nav-item">
                <a class="nav-link" href="Login.php">Giriş Yap</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Register.php">Üye Ol</a>
            </li>
            <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="Logout.php">Çıkış Yap</a>
            </li>
            <?php endif; ?>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="Search.php" method="get">
            <input class="form-control mr-sm-2" type="search" placeholder="Tarif Ara" aria-label="Search" style="background-color: #fefee3;" name="search">
            <button class="btn my-2 my-sm-0" style="background-color: #fefee3;" type="submit">Ara</button>
            </form>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>