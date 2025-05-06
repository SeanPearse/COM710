<?php

session_start();

if (!isset($_SESSION['account_loggedin'])) {
    header('Location: LoginPage.php');
    exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$stmt = $con->prepare('SELECT email, registered FROM accounts WHERE id = ?');

$stmt->bind_param('i', $_SESSION['account_id']);
$stmt->execute();
$stmt->bind_result($email, $registered);
$stmt->fetch();
$stmt->close();


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>
        <link rel="stylesheet"href="../Style Sheets\MainStyleSheet.css">
        <script src="../Java Files/MainJavaFile.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div id="Banner-Box">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search...">
                <button class="search-button" type="button"> <i class="fas fa-search"></i>  <!-- FontAwesome search icon -->
                </button>
            </div>    
            <div id="LogoImage">
                <td><a href="MainPage.html"><img class="MainImageScale" src="../Asset Folder/Main Logo Website.png" height="200px"></a></td>
            </div>
            <div id="ProfileImage">
                <button id="ProfileButton"><a href="LoginPage.php"><img class="ProfileImageScale" src="../Asset Folder/blank-profile-picture-973460_1280.png" height="50px" width="50px"></a> </button>
             </div>
            <div id="DarkMode">
                <button id="DarkModeButton" onclick="darkMode()"><div id ="Moon"><img src="../Asset Folder/5c6536e03ce41c0ef9f4bccc.png" height="40px" width="40px"></div></button>
            </div>
            <label>
                <input type="checkbox">
                <div class="toggle">
                    <span class="top_line common"></span>
                    <span class="middle_line common"></span>
                    <span class="bottom_line common"></span>
                </div>
        
                <div class="slide">
                   <h1>Menu</h1>
                   <ul>
                   <li><a href="#"><a href="./MainPage.html"><i class="fas fa-tv"></i>Home</a></a></li>
                        <li><a href="#"><i class="fas fa-heart"></i>Favourites</a></li>
                        <li><a href="#"><i class="fas fa-search"></i>Recipes</a></li>
                        <li><a href="#"><i class="fas fa-comments"></i>Comments</a></li>
                   </ul>
                </div>
            </label>
        </div>

        <div class="content">


<div class="page-title">
                <div class="wrap">
                    <h2>Profile</h2>
                    <p>View your profile details below.</p>
                </div>
            </div>

            <div class="block">

                <div class="profile-detail">
                    <strong>Username</strong>
                    <?=htmlspecialchars($_SESSION['account_name'])?>
                </div>

                <div class="profile-detail">
                    <strong>Email</strong>
                    <?=htmlspecialchars($email)?>
                </div>

                <div class="profile-detail">
                    <strong>Registered</strong>
                    <?=htmlspecialchars($registered)?>
                </div>

            </div>

                            

    
</div>


<div class="Logout"><a href="Logout.php"><h2>Log out</h2></a>
</div>





        </body>
<Footer>
        <div id="Footer">
            <p>
            <div id="LogoImageFooter">
                <td><a href="MainPage.html"><img class="MainImageScale" src="../Asset Folder/Main Logo Website.png" height="200px"></a></td>
            </div>
                <div id="Footer-Text">
                Created by Sean Pearse
                </div>
            </p>
        </div>
</Footer>
</html>