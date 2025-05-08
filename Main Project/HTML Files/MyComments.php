<?php
session_start();
if (!isset($_SESSION['account_loggedin']) || !isset($_SESSION['account_id'])) {
    header('Location: LoginPage.php');
    exit;
}

$userId = $_SESSION['account_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home Page</title>
  <link rel="stylesheet" href="../Style Sheets/MainStyleSheet.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="../Java Files/MainJavaFile.js" defer></script>
</head>
<body data-user-id="<?= $userId ?>">


  <!-- Banner -->
  <header id="Banner-Box">
    <div class="search-container">
      <input type="search" id="search" class="search-input" data-search placeholder="Search..." />
      <button class="search-button" type="button"><i class="fas fa-search"></i></button>
    </div>

    <div id="LogoImage">
      <a href="MainPage.php"><img class="MainImageScale" src="../Asset Folder/Main Logo Website.png" alt="Site Logo" height="200px" /></a>
    </div>

    <div id="ProfileImage">
      <a href="LoginPage.php"><img class="ProfileImageScale" src="../Asset Folder/blank-profile-picture-973460_1280.png" alt="Profile" height="50px" width="50px" /></a>
    </div>

    <div id="DarkMode">
      <button id="DarkModeButton" onclick="darkMode()">
        <div id="Moon">
          <img src="../Asset Folder/5c6536e03ce41c0ef9f4bccc.png" alt="Toggle Dark Mode" height="40px" width="40px" />
        </div>
      </button>
    </div>

    <!-- Sidebar menu -->
    <label>
      <input type="checkbox" />
      <div class="toggle">
        <span class="top_line common"></span>
        <span class="middle_line common"></span>
        <span class="bottom_line common"></span>
      </div>

      <nav class="slide">
        <h1>Menu</h1>
        <ul>
        <li><a href="./MainPage.php"><i class="fas fa-tv"></i> Home</a></li>
          <li><a href="LikedRecipes.php"><i class="fas fa-heart"></i> Favourites</a></li>
          <li><a href="MyRecipes.php"><i class="fas fa-utensils"></i> My Recipes</a></li>
          <li><a href="MyComments.php"><i class="fas fa-comments"></i> Comments</a></li>
        </ul>
      </nav>
    </label>
  </header>

<!-- Title -->
<h2 style="text-align: center; margin-top: 40px;">Your Comments</h2>

<!-- Comments Container -->
<section class="comments-container">
  <div id="user-comments"></div>
</section>

<!-- Footer -->
<footer id="Footer">
  <div id="LogoImageFooter">
    <a href="MainPage.php"><img class="MainImageScale" src="../Asset Folder/Main Logo Website.png" height="200px" alt="Main Logo"></a>
  </div>
  <div id="Footer-Text">Created by Sean Pearse</div>
</footer>

</body>
</html>
