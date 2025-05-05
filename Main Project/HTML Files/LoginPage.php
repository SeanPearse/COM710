<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
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
                <button id="ProfileButton"><a href="LoginPage.html"><img class="ProfileImageScale" src="../Asset Folder/blank-profile-picture-973460_1280.png" height="50px" width="50px"></a> </button>
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
                        <li><a href="#"><i class="fas fa-tv"></i>Home</a></li>
                        <li><a href="#"><i class="fas fa-heart"></i>Favourites</a></li>
                        <li><a href="#"><i class="fas fa-search"></i>Recipes</a></li>
                        <li><a href="#"><i class="fas fa-comments"></i>Comments</a></li>
                   </ul>
                </div>
            </label>
        </div>
<div id="login-container">
    <div class="form-box active" id="login-form">
        <form action="">
        <div id="Login-Img">
      <img src="../Asset Folder/blank-profile-picture-973460_1280.png" height="300px"
      img class="login-img">
      <h2>Login</h2>
      </div> 
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Login</button>
      <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
    </form>
    </div>

    <div class="form-box" id="register-form">
        <form action="">
        <div id="Login-Img">
      <img src="../Asset Folder/blank-profile-picture-973460_1280.png" height="300px"
      img class="login-img">
      <h2>Register</h2>
      </div> 
      <input type="text" name="name" placeholder="Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Register</button>
      <p>Already have an account? <a href="#" onclick="showForm('login-form')>Login</a></p>
     </form>
    </div>
 </div>


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
    </body>
</html>