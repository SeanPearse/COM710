<?php
session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';

// Clear specific session messages after displaying them
unset($_SESSION['login_error'], $_SESSION['register_error'], $_SESSION['active_form']);


function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
// Check if the user is already logged in
if (isset($_SESSION['account_loggedin']) && $_SESSION['account_loggedin'] === TRUE) {
    // Redirect to profile or another page if user is logged in
    header('Location: Profile.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login & Register</title>
    <link rel="stylesheet" href="../Style Sheets/MainStyleSheet.css" />
    <script src="../Java Files/MainJavaFile.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>
     <!-- Banner -->
  <header id="Banner-Box">
    <div class="search-container">
      <input type="search" id="search" class="search-input" data-search placeholder="Search..." />
      <button class="search-button" type="button"><i class="fas fa-search"></i></button>
    </div>

    <div id="LogoImage">
      <a href="MainPage.php"><img class="MainImageScale" src="../Asset Folder/Main Logo Website.png" alt="Site Logo" height="200px" /></a>
    </div>

    <div id="ProfileImage">
      <a href="LoginPage.php"><img class="ProfileImageScale" src="../Asset Folder/blank-profile-picture-973460_1280.png" alt="Profile" height="50px" width="50px" /></a>
    </div>

    <div id="DarkMode">
      <button id="DarkModeButton" onclick="darkMode()">
        <div id="Moon">
          <img src="../Asset Folder/5c6536e03ce41c0ef9f4bccc.png" alt="Toggle Dark Mode" height="40px" width="40px" />
        </div>
      </button>
    </div>

    <!-- Sidebar menu -->
    <label>
      <input type="checkbox" />
      <div class="toggle">
        <span class="top_line common"></span>
        <span class="middle_line common"></span>
        <span class="bottom_line common"></span>
      </div>

      <nav class="slide">
        <h1>Menu</h1>
        <ul>
          <li><a href="./MainPage.php"><i class="fas fa-tv"></i> Home</a></li>
          <li><a href="#"><i class="fas fa-heart"></i> Favourites</a></li>
          <li><a href="#"><i class="fas fa-search"></i> Recipes</a></li>
          <li><a href="#"><i class="fas fa-comments"></i> Comments</a></li>
        </ul>
      </nav>
    </label>
  </header>

    <div id="login-container">
        <!-- Login Form -->
        <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
            <h2>Login</h2>
            <?= showError($errors['login']); ?>
            <form action="LoginProcess.php" method="post">
                <img src="../Asset Folder/blank-profile-picture-973460_1280.png" height="300px" class="login-img" />
                
                <!-- Username Input -->
                <label for="login-username"><h3>Username</h3></label>
                <input class="form-input" type="text" name="username" placeholder="Username" id="login-username" required />

                <!-- Password Input -->
                <label for="login-password"><h3>Password</h3></label>
                <input class="form-input" type="password" name="password" placeholder="Password" id="login-password" required />

                <!-- Login Button -->
                <button type="submit" name="login">Login</button>
                <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
            </form>
        </div>

        <!-- Register Form -->
        <div class="form-box <?= isActiveForm('register', $activeForm); ?>" id="register-form">
            <h2>Register</h2>
            <?= showError($errors['register']); ?>
            <form action="RegisterProcess.php" method="post">
                <img src="../Asset Folder/blank-profile-picture-973460_1280.png" height="300px" class="login-img" />
                
                <!-- Username Input -->
                <label for="register-username"><h3>Username</h3></label>
                <input class="form-input" type="text" name="username" placeholder="Username" id="register-username" required />

                <!-- Email Input -->
                <label for="register-email"><h3>Email</h3></label>
                <input class="form-input" type="email" name="email" placeholder="Email" id="register-email" required />

                <!-- Password Input -->
                <label for="register-password"><h3>Password</h3></label>
                <input class="form-input" type="password" name="password" placeholder="Password" id="register-password" autocomplete="new-password" required />

                <!-- Register Button -->
                <button type="submit" name="register">Register</button>
                <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a></p>
            </form>
        </div>
    </div>

    <footer>
        <div id="Footer">
            <p>
                <div id="LogoImageFooter">
                    <a href="MainPage.php"><img class="MainImageScale" src="../Asset Folder/Main Logo Website.png" height="200px" alt="Main Logo" /></a>
                </div>
                <div id="Footer-Text">
                    Created by Sean Pearse
                </div>
            </p>
        </div>
    </footer>
</body>
</html>
