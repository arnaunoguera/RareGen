<?php

function headerDBW() {
    return '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RareGen</title>
<link rel="stylesheet" href="css/styles.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Roboto+Flex:wght@100;200;300;400;500;600;700;800;900;1000&family=Roboto+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet" />
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
      onmouseleave="revertBackgroundColor(this)" onclick="goToSignup()">Sign Up</button>
    <button class="user-entrance" id="login" onmousedown="changeBackgroundColor(this, \'#666666\')"
      onmouseup="revertBackgroundColor(this)" onmouseenter="changeBackgroundColor(this, \'#BBBBBB\')"
      onmouseleave="revertBackgroundColor(this)" onclick="goToLogin()">Login</button>
  </div>
</header>
</body>
</html>';
}


function footerDBW() {
    return '
    <footer>
    <h4> © The RareGen GROUP 2024
      <br> Edgar Chacón, Narine Fischer, Arnau Noguera, Aina Vaquer
      <br> Contact us via: notarealemailaddress@gmail.com
    </h4>
  </footer>
  <script src="js/index.js"></script>
  </body>

</html>';
}

function errorPage($title, $text) {
  return headerDBW() . '<div class="content-search">
  <div class="container">
        <h2 class="title">'.$title.'</h2>
        <p>'.$text.'</p>
  </div>'. footerDBW();
}