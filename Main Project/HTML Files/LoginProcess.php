<?php
session_start();
require_once 'Config.php';

if (!isset($_POST['username'], $_POST['password'])) {
    exit('Please fill both the username and password fields!');
}

$input = trim($_POST['username']); 
$password = $_POST['password'];

if ($stmt = $conn->prepare('SELECT id, username, password FROM accounts WHERE username = ? OR email = ?')) {
    $stmt->bind_param('ss', $input, $input);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            session_regenerate_id();
            $_SESSION['account_loggedin'] = true;
            $_SESSION['account_name'] = $username;
            $_SESSION['account_id'] = $id;
            header('Location: Profile.php');
            exit;
        } else {
            $_SESSION['login_error'] = 'Incorrect username and/or password!';
        }
    } else {
        $_SESSION['login_error'] = 'Incorrect username and/or password!';
    }

    $stmt->close();
} else {
    $_SESSION['login_error'] = 'Database error. Please try again later.';
}

header('Location: LoginPage.php');
exit;
?>
