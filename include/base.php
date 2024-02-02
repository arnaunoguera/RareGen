<?php

function headerDBW($title) {
    return "<html lang=\"en\">
<head>
<meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<title>$title</title>
       <!-- Bootstrap styles -->
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">
  
    <!-- IE 8 Support-->
    <!--[if lt IE 9]>
      <script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>
      <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
    <![endif]--> 
        <link rel=\"stylesheet\" href=\"DataTable/jquery.dataTables.min.css\"/>
        <script type=\"text/javascript\" src=\"DataTable/jquery-2.2.0.min.js\"></script>
        <script type=\"text/javascript\" src=\"DataTable/jquery.dataTables.min.js\"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('https://source.unsplash.com/random') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        .header{
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .footer{
            color: white;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .header {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .footer {
            background-color: rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        .header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
        .searchbar {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .searchbar input {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .searchbar select {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RareGen</h1>
        <div>
            <?php if (isset($user)): ?>
                <img src="user_image.jpg" alt="User Image">
                <h3>User Name</h3>
            <?php else: ?>
                <a href="login.php">Log in</a>
            <?php endif; ?>
        </div>
    </d
";
}

function footerDBW() {
    return '
    <div class="footer">
    <p>2022 The RareGen Group</p>
    </div>
</body>
</html>';
}

function errorPage($title, $text) {
    return headerDBW($title) . $text . footerDBW();
}