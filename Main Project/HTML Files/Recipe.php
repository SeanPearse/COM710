<?php
session_start();

$recipe_id = $_GET['id'] ?? null;
if (!$recipe_id) {
    die('No recipe specified.');
}

$recipes = json_decode(file_get_contents('../Java Files/RecipeData.json'), true);
$recipe = null;

foreach ($recipes as $r) {
    if ($r['id'] == $recipe_id) {
        $recipe = $r;
        break;
    }
}

if (!$recipe) {
    die('Recipe not found.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Recipe</title>
  <link rel="stylesheet" href="../Style Sheets/MainStyleSheet.css" />
  <script src="../Java Files/MainJavaFile.js" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <div id="Banner-Box">
    <div class="search-container">
      <input type="text" class="search-input" placeholder="Search..." />
      <button class="search-button" type="button"><i class="fas fa-search"></i></button>
    </div>
    <div id="LogoImage">
      <a href="MainPage.php"><img class="MainImageScale" src="../Asset Folder/Main Logo Website.png" height="200px" /></a>
    </div>
    <div id="ProfileImage">
      <button id="ProfileButton">
        <a href="LoginPage.php"><img class="ProfileImageScale" src="../Asset Folder/blank-profile-picture-973460_1280.png" height="50px" width="50px" /></a>
      </button>
    </div>
    <div id="DarkMode">
      <button id="DarkModeButton" onclick="darkMode()">
        <div id="Moon"><img src="../Asset Folder/5c6536e03ce41c0ef9f4bccc.png" height="40px" width="40px" /></div>
      </button>
    </div>
    <label>
      <input type="checkbox" />
      <div class="toggle">
        <span class="top_line common"></span>
        <span class="middle_line common"></span>
        <span class="bottom_line common"></span>
      </div>
      <div class="slide">
        <h1>Menu</h1>
        <ul>
          <li><a href="./MainPage.php"><i class="fas fa-tv"></i> Home</a></li>
          <li><a href="#"><i class="fas fa-heart"></i> Favourites</a></li>
          <li><a href="#"><i class="fas fa-search"></i> Recipes</a></li>
          <li><a href="#"><i class="fas fa-comments"></i> Comments</a></li>
        </ul>
      </div>
    </label>
  </div>

  <div class="recipe-page">
    <section class="recipe-hero">
      <h2><?= htmlspecialchars($recipe['name']) ?></h2>
      <img src="<?= htmlspecialchars($recipe['img']) ?>" class="img recipe-hero-img" alt="food image" />
      <article>
        <p class="recipe-description"><?= htmlspecialchars($recipe['description']) ?></p>
        <div class="recipe-icons">
          <article>
            <i class="fas fa-clock"></i>
            <h5>Prep Time</h5>
            <p><?= htmlspecialchars($recipe['preptime']) ?></p>
          </article>
          <article>
            <i class="far fa-clock"></i>
            <h5>Cook Time</h5>
            <p><?= htmlspecialchars($recipe['cooktime']) ?></p>
          </article>
          <article>
            <i class="fas fa-user-friends"></i>
            <h5>Servings</h5>
            <p><?= htmlspecialchars($recipe['servings']) ?></p>
          </article>
        </div>
        <div class="recipe-tags">
  Tags: 
  <?php
    $tags = explode(",", $recipe['tags']);
    foreach ($tags as $tag) {
        $tag = trim($tag);
        echo "<a href='MainPage.php?tag=" . urlencode($tag) . "' class='tag-link'>" . htmlspecialchars($tag) . "</a> ";
    }
  ?>
</div>

        <?php if (isset($_SESSION['account_id']) && $recipe['user_id'] == $_SESSION['account_id']): ?>
          <form action="DeleteRecipe.php" method="post" onsubmit="return confirm('Are you sure?');">
            <input type="hidden" name="recipe_id" value="<?= htmlspecialchars($recipe['id']) ?>">
            <button type="submit">Delete Recipe</button>
          </form>
        <?php endif; ?>
      </article>
    </section>

    <section class="recipe-content">
      <article class="instructions-column">
        <h4>Instructions</h4>
        <?php if (isset($recipe['instructions']) && is_array($recipe['instructions'])): ?>
          <ul>
            <?php foreach ($recipe['instructions'] as $instruction): ?>
              <li><?= htmlspecialchars($instruction) ?></li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p>No instructions listed.</p>
        <?php endif; ?>
      </article>

      <article class="ingredients-column">
        <div class="ingredients-list">
          <h4>Ingredients</h4>
          <?php if (isset($recipe['ingredients']) && is_array($recipe['ingredients'])): ?>
            <ul>
              <?php foreach ($recipe['ingredients'] as $ingredient): ?>
                <li><?= htmlspecialchars($ingredient) ?></li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p>No ingredients listed.</p>
          <?php endif; ?>
        </div>
        <div class="tools-list">
          <h4>Tools</h4>
          <?php if (isset($recipe['tools']) && is_array($recipe['tools'])): ?>
            <ul>
              <?php foreach ($recipe['tools'] as $tool): ?>
                <li><?= htmlspecialchars($tool) ?></li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p>No tools listed.</p>
          <?php endif; ?>
        </div>
      </article>
    </section>
  </div>

  <footer>
    <div id="Footer">
      <div id="LogoImageFooter">
        <a href="MainPage.php"><img class="MainImageScale" src="../Asset Folder/Main Logo Website.png" height="200px" /></a>
      </div>
      <div id="Footer-Text">Created by Sean Pearse</div>
    </div>
  </footer>
</body>
</html>
