<?php
session_start();
if (!isset($_SESSION['account_loggedin'])) {
    header('Location: LoginPage.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Recipe</title>
    <link rel="stylesheet" href="../Style Sheets/MainStyleSheet.css">
</head>
<body>
<h1>Create a New Recipe</h1>
<form action="AddRecipe.php" method="post" enctype="multipart/form-data">
  <label for="name">Recipe Name:</label>
  <input type="text" id="name" name="name" required>

  <label for="tags">Tags (comma-separated):</label>
  <input type="text" id="tags" name="tags" placeholder="e.g., breakfast, vegan" required>

  <label for="description">Short Description:</label>
  <textarea id="description" name="description" rows="3" required></textarea>

  <label for="ingredients">Ingredients (one per line):</label>
  <textarea id="ingredients" name="ingredients" rows="5" required></textarea>

  <label for="tools">Tools (one per line):</label>
  <textarea id="tools" name="tools" rows="3" required></textarea>

  <label for="instructions">Instructions (one per line):</label>
  <textarea id="instructions" name="instructions" rows="6" required></textarea>

  <label for="preptime">Prep Time (e.g., 20 min):</label>
  <input type="text" id="preptime" name="preptime" required>

  <label for="cooktime">Cook Time (e.g., 30 min):</label>
  <input type="text" id="cooktime" name="cooktime" required>

  <label for="servings">Servings (e.g., 4):</label>
  <input type="text" id="servings" name="servings" required>

  <label for="image">Upload Image:</label>
  <input type="file" id="image" name="image" accept="image/*" required>

  <button type="submit">Submit Recipe</button>
</form>


</body>
</html>
