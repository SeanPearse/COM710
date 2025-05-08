<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['account_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$account_id = $_SESSION['account_id'];
$recipe_id = $_POST['recipe_id'] ?? null;

if (!$recipe_id) {
    echo json_encode(["success" => false, "message" => "No recipe ID provided"]);
    exit;
}

$filepath = '../Java Files/RecipeData.json';
$recipes = json_decode(file_get_contents($filepath), true);

$updated = false;
foreach ($recipes as &$recipe) {
    if ($recipe['id'] == $recipe_id) {
        if (!isset($recipe['likes']['users'])) {
            $recipe['likes']['users'] = [];
            $recipe['likes']['count'] = 0;
        }

        if (in_array($account_id, $recipe['likes']['users'])) {
            // Unlike
            $recipe['likes']['users'] = array_filter($recipe['likes']['users'], fn($id) => $id != $account_id);
            $recipe['likes']['count'] = max(0, $recipe['likes']['count'] - 1);
            $liked = false;
        } else {
            // Like
            $recipe['likes']['users'][] = $account_id;
            $recipe['likes']['count'] += 1;
            $liked = true;
        }

        $new_count = $recipe['likes']['count'];
        $updated = true;
        break;
    }
}

if ($updated) {
    file_put_contents($filepath, json_encode($recipes, JSON_PRETTY_PRINT));
    echo json_encode(["success" => true, "new_count" => $new_count, "liked" => $liked]);
} else {
    echo json_encode(["success" => false, "message" => "Recipe not found"]);
}
