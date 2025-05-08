<?php
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['account_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['recipe_id'], $_POST['comment_text'])) {
    echo json_encode(["success" => false, "message" => "Missing data."]);
    exit;
}

$recipeId = $_POST['recipe_id'];
$commentText = trim($_POST['comment_text']);
$userId = $_SESSION['account_id'];
$username = $_SESSION['username'] ?? 'Anonymous';  // assuming you store username in session

if ($commentText === '') {
    echo json_encode(["success" => false, "message" => "Comment cannot be empty."]);
    exit;
}

$commentsFile = 'comments.json';
$comments = file_exists($commentsFile) ? json_decode(file_get_contents($commentsFile), true) : [];

$comments[] = [
    'id' => uniqid(),
    'recipe_id' => $recipeId,
    'user_id' => $userId,
    'username' => htmlspecialchars($username),
    'comment_text' => htmlspecialchars($commentText),
    'timestamp' => date("Y-m-d H:i:s")
];

file_put_contents($commentsFile, json_encode($comments, JSON_PRETTY_PRINT));

echo json_encode(["success" => true]);
