<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['account_id']) || !isset($_POST['comment_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized or missing data."]);
    exit;
}

$commentId = $_POST['comment_id'];
$userId = $_SESSION['account_id'];

$commentsFile = '../Java Files/comments.json';

$comments = file_exists($commentsFile) ? json_decode(file_get_contents($commentsFile), true) : [];

$found = false;
$filteredComments = array_filter($comments, function($comment) use ($commentId, $userId, &$found) {
    if ($comment['id'] === $commentId && $comment['user_id'] === $userId) {
        $found = true;
        return false;
    }
    return true;
});

if ($found) {
    file_put_contents($commentsFile, json_encode(array_values($filteredComments), JSON_PRETTY_PRINT));
}

echo json_encode(["success" => $found]);
