<?php
session_start();
if (!isset($_SESSION['account_id'])) {
    header("Location: LoginPage.php");
    exit;
}

$account_id = $_SESSION['account_id'];
$recipes = json_decode(file_get_contents('../Java Files/RecipeData.json'), true);

// Filter recipes created by the current user and add 'link' to each recipe
$userRecipes = array_values(array_filter($recipes, fn($r) => isset($r['user_id']) && $r['user_id'] == $account_id));
foreach ($userRecipes as &$recipe) {
    $recipe['link'] = "Recipe.php"; // ✅

}
unset($recipe);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Recipes</title>
  <link rel="stylesheet" href="../Style Sheets/MainStyleSheet.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" />

  <!-- Pass user's recipes to JS -->
  <script>
    const myRecipesData = <?php echo json_encode($userRecipes); ?>;
  </script>
  <script src="../Java Files/MainJavaFile.js" defer></script>
</head>

<body>
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
        </ul>
      </nav>
    </label>
  </header>

  <div id="LikedTitle"><h2>Your Created Recipes</h2></div>

  <section class="recipes-container">
    <div class="tag-filter">
      <h4>Filter by Tag</h4>
      <div class="tags-list" id="tag-filter"></div>
    </div>

    <div class="user-cards" data-user-cards-container></div>
  </section>

  <!-- Template for recipe card -->
  <template data-user-template>
  <a href="#" class="card-link" data-link>
    <div class="card">
      <h2 data-header></h2>
      <p data-body></p>
      <img data-img src="" alt="food" class="img recipe-img" />
    </div>
  </a>
</template>


  <footer id="Footer">
    <div id="LogoImageFooter">
      <a href="MainPage.php"><img class="MainImageScale" src="../Asset Folder/Main Logo Website.png" alt="Footer Logo" height="200px" /></a>
    </div>
    <div id="Footer-Text">Created by Sean Pearse</div>
  </footer>
</body>
</html>
