<?php
require_once("../php/session.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once("../classes/database.class.php");
    require_once ("../classes/auth.class.php");
    $database = new Database();
    $auth = new Auth($database);
    if ($auth->login($_POST["username"], $_POST["password"])) {
        header("Location: ../index.php");
    } else {
        $error = "Username/Password do not match";
    }
}

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <title>Audio-CP</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link href="../css/login.css" rel="stylesheet" type="text/css">
</head>

<body>
<form method="post" action="" id="login_form">
    <div class="before"><p>CONTROL PANEL LOGIN</p></div>
    <?php
    if (isset($error)) {
        echo "<p id=\"error\">$error</p>";
    }
    ?>
    <input name="username" id="username" type="text" placeholder="username">
    <input name="password" id="password" type="password" placeholder="password">
    <input id="submit" type="submit" value="Login">
    <div class="after"></div>
</form>

</body>

</html>