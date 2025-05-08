<?php
session_start();
if (!isset($_SESSION['account_loggedin'])) {
    header('Location: LoginPage.php');
    exit;
}

$recipesFile = '../Java Files/RecipeData.json';
$uploadDir = '../Html Files/uploads/';

// Ensure upload folder exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Validate inputs
$name = trim($_POST['name']);
$tags = trim($_POST['tags']);
$description = trim($_POST['description']);
$ingredients = trim($_POST['ingredients']);
$tools = trim($_POST['tools']);
$instructions = trim($_POST['instructions']);
$preptime = trim($_POST['preptime']);
$cooktime = trim($_POST['cooktime']);
$servings = trim($_POST['servings']);
$image = $_FILES['image'];

if (
    !$name || !$tags || !$description || !$ingredients || !$tools ||
    !$instructions || !$preptime || !$cooktime || !$servings || !isset($image)
) {
    die('All fields are required.');
}

// Validate image
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($image['type'], $allowedTypes)) {
    die('Only JPG, PNG, and GIF files are allowed.');
}
if ($image['error'] !== UPLOAD_ERR_OK) {
    die('Image upload failed.');
}

$filename = basename($image['name']);
$targetPath = $uploadDir . time() . '_' . $filename;

if (!move_uploaded_file($image['tmp_name'], $targetPath)) {
    die('Failed to save the uploaded image.');
}

$relativePath = $targetPath;

// Load existing recipes
$recipes = file_exists($recipesFile)
    ? json_decode(file_get_contents($recipesFile), true)
    : [];

$nextId = count($recipes) + 1;

// 🔐 Add user ID to the new recipe
$user_id = $_SESSION['account_id'];

$newRecipe = [
    'id' => $nextId,
    'name' => $name,
    'tags' => $tags,
    'img' => $relativePath,
    'description' => $description,
    'ingredients' => explode("\n", $ingredients),
    'tools' => explode("\n", $tools),
    'instructions' => explode("\n", $instructions),
    'preptime' => $preptime,
    'cooktime' => $cooktime,
    'servings' => $servings,
    'link' => "../HTML Files/Recipe.php",
    'user_id' => $user_id // ✅ This line was likely missing or open
];

$recipes[] = $newRecipe;
file_put_contents($recipesFile, json_encode($recipes, JSON_PRETTY_PRINT));

header('Location: MainPage.php');
exit;
?>
