<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$recipeId = isset($_GET['recipe_id']) ? intval($_GET['recipe_id']) : 0;
$commentsFile = '../Java Files/comments.json';

if (!file_exists($commentsFile)) {
    echo json_encode([]);
    exit;
}

$allComments = json_decode(file_get_contents($commentsFile), true);
$filtered = array_filter($allComments, fn($c) => $c['recipe_id'] == $recipeId);
echo json_encode(array_values($filtered));
exit;
