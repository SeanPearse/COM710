<?php
session_start();
header('Content-Type: application/json');

$commentsFile = '../Java Files/comments.json';
$comments = file_exists($commentsFile) ? json_decode(file_get_contents($commentsFile), true) : [];

// ✅ Check login (your session keys are: account_id and account_name)
if (!isset($_SESSION['account_id']) || !isset($_SESSION['account_name'])) {
    echo json_encode([
        'success' => false,
        'message' => 'You must be logged in to comment.',
        'session' => $_SESSION
    ]);
    exit;
}

// ✅ Check form fields
if (!isset($_POST['comment_text']) || !isset($_POST['recipe_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing POST fields.',
        'post_data' => $_POST
    ]);
    exit;
}

$commentText = trim($_POST['comment_text']);
$recipeId = intval($_POST['recipe_id']);

// ✅ Build comment structure
$newComment = [
    'id' => uniqid(),
    'recipe_id' => $recipeId,
    'user_id' => $_SESSION['account_id'],
    'username' => $_SESSION['account_name'],
    'comment_text' => htmlspecialchars($commentText),
    'timestamp' => date('Y-m-d H:i:s')
];

// ✅ Add to array and save
$comments[] = $newComment;

if (file_put_contents($commentsFile, json_encode($comments, JSON_PRETTY_PRINT))) {
    echo json_encode([
        'success' => true,
        'comment' => [
            'id' => $newComment['id'],
            'username' => $newComment['username'],
            'comment_text' => $newComment['comment_text'],
            'user_id' => $newComment['user_id']
        ]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to save comment.',
        'filepath' => realpath($commentsFile),
        'is_writable' => is_writable($commentsFile)
    ]);
}
