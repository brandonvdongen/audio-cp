<?php
require_once("../php/session.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once("../php/classes.php");
    $login = new auth($_POST["name"],$_POST["password"]);



    $stmt->bindparam(1, $username, PDO::PARAM_STR);

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $login_id = $result["id_users"];
    $login_user = $result["username"];
    $login_nick = $result["nickname"];
    $login_password = $result["password"];

    if (password_verify($password, $login_password)) {
        $_SESSION["loggedin"] = true;
        $_SESSION["id_users"] = $login_id;
        $_SESSION["username"] = $login_user;
        $_SESSION["nickname"] = $login_nick;
        header("Location: ../index.php");
    } else {
        $error = "Username/Password do not match";
    }

    $stmt->closeCursor();

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
    <input name="name" id="name" type="text" placeholder="username">
    <input name="password" id="pass" type="password" placeholder="password">
    <input id="submit" type="submit" value="Login">
    <div class="after"></div>
</form>

</body>

</html>