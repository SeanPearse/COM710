<?php
session_start();
if (!isset($_SESSION['account_loggedin']) || !isset($_POST['recipe_id'])) {
    header('Location: MainPage.php');
    exit;
}

$recipe_id = intval($_POST['recipe_id']);
$user_id = $_SESSION['account_id'];

$recipesFile = '../Java Files/RecipeData.json';
$recipes = json_decode(file_get_contents($recipesFile), true);

$newRecipes = [];
$found = false;

foreach ($recipes as $recipe) {
    if ($recipe['id'] == $recipe_id) {
        if ($recipe['user_id'] != $user_id) {
            die('You are not authorized to delete this recipe.');
        }
        $found = true;
        continue; // skip this recipe (deleting it)
    }
    $newRecipes[] = $recipe;
}

if ($found) {
    file_put_contents($recipesFile, json_encode($newRecipes, JSON_PRETTY_PRINT));
}

header('Location: Profile.php'); // or wherever you want
exit;
?>
