<?php
session_start();
include("Config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    // Sanitize and trim input data
    $username = trim(htmlspecialchars($_POST["username"]));
    $email = trim(htmlspecialchars($_POST["email"]));
    $password = trim($_POST["password"]);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["register_error"] = "Invalid email format.";
        $_SESSION["active_form"] = "register";
        header("Location: LoginPage.php");
        exit();
    }

    // Password length check
    if (strlen($password) < 8) {
        $_SESSION["register_error"] = "Password must be at least 8 characters long.";
        $_SESSION["active_form"] = "register";
        header("Location: LoginPage.php");
        exit();
    }

    // Hash the password for secure storage
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if username or email already exists
    $check_query = "SELECT * FROM accounts WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        $_SESSION["register_error"] = "Username or Email already exists.";
        $_SESSION["active_form"] = "register";
        header("Location: LoginPage.php");
        exit();
    }

    // Insert the new user into the database
    $registered = date("Y-m-d H:i:s");
    $insert_query = "INSERT INTO accounts (username, email, password, registered) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $registered);

    if ($stmt->execute()) {
        $_SESSION["username"] = $username;
        header("Location: Profile.php");
        exit();
    } else {
        // Log the error for debugging
        error_log("Error: " . $stmt->error); 
        
        $_SESSION["register_error"] = "An error occurred during registration. Please try again later.";
        $_SESSION["active_form"] = "register";
        header("Location: LoginPage.php");
        exit();
    }
}
?>
