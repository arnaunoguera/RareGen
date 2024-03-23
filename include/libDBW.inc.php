<?php

function headerDBW() {
    return '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RareGen</title>
<link rel="icon" type="image/x-icon" href="images/DNA.png" />
<link rel="stylesheet" href="css/styles.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Roboto+Flex:wght@100;200;300;400;500;600;700;800;900;1000&family=Roboto+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="DataTable/jquery.dataTables.min.css"/>
<script type="text/javascript" src="DataTable/jquery-2.2.0.min.js"></script>
<script type="text/javascript" src="DataTable/jquery.dataTables.min.js"></script>
</head>
<body>
<!-- BACKGROUND -->
<div class="background"></div>
<!-- HEADER -->
<header>
  <a href="index.php">
    <h1 class="logo">RareGen</h1>
  </a>
  <div class="site-management">
    <button class="user-entrance" id="signup" onmousedown="changeBackgroundColor(this, \'#666666\')" 
    onmouseup="revertBackgroundColor(this)" onmouseenter="changeBackgroundColor(this, \'#BBBBBB\')" 
    onmouseleave="revertBackgroundColor(this)" onclick="javascript:window.location.href=\'sign_up.php\';">Sign Up</button>
    <button class="user-entrance" id="login" onmousedown="changeBackgroundColor(this, \'#666666\')"
    onmouseup="revertBackgroundColor(this)" onmouseenter="changeBackgroundColor(this, \'#BBBBBB\')"
    onmouseleave="revertBackgroundColor(this)" onclick="openLoginModal()">Login</button>
  </div>
</header>
</body>
</html>';
}


function footerDBW() {
  return '
  <div class="container_end">
  </div>

  <footer>
  <h4> © The RareGen GROUP 2024
    <br> Edgar Chacón, Narine Fischer, Arnau Noguera, Aina Vaquer
    <br> Contact us via: notarealemailaddress@gmail.com
  </h4>
</footer>
<script src="js/index.js" defer></script>
</body>
<div id="loginModal" class="modal">
<div class="modal-content">
  <span class="close" onclick="closeLoginModal()">&times;</span>
  <h2>Login</h2>
  <form name="LoginForm" id="loginForm" action="login.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" placeholder="Introduce your username" name="username">
    <label for="password">Password:</label>
    <div class="password-container">
      <input type="password" id="password1" placeholder="Introduce your password" name="password1" autocomplete="new-password">
      <button type="button" class="show-password-button" onclick="togglePasswordVisibility(&quot;password1&quot;)">Show</button>
    </div>
    <button style="margin-left: 25px" type="submit" class="submit-button">Login</button>
  </form>
</div>
</div>
</html>';
}

function errorPage($title, $text) {
  return headerDBW() . '<div class="content-search">
  <div class="container">
        <h2 class="title">'.$title.'</h2>
        <p>'.$text.'</p>
  </div>'. footerDBW();
}

