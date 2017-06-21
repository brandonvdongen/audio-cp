<?php
require_once(__DIR__ . "/../init.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once("auth.php");

    $stmt = $conn->prepare("
SELECT users.id_users, users.username, users.nickname, users.password, permissions.edit_all, permissions.see_all 
FROM users 
INNER JOIN permissions 
ON users.id_users=permissions.id_permissions 
WHERE username = ?");

    $stmt->bind_param("s", $username);

    $username = $_POST["name"];
    $password = $_POST["password"];

    $stmt->execute();
    $stmt->bind_result($login_id, $login_user, $login_nick, $login_password, $login_edit_all, $login_see_all);
    $stmt->fetch();

    if (password_verify($password, $login_password)) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $login_user;
        $_SESSION["nickname"] = $login_nick;
        $_SESSION["id_user"] = $login_id;
        $_SESSION["perm:edit_all"] = $login_edit_all;
        $_SESSION["perm:see_all"] = $login_see_all;
        header("Location: ../index.php");
    } else {
        echo "user not found!";
    }

    $stmt->close();

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
<form method="post" action="">
    <input name="name" id="name" type="text" placeholder="name">
    <input name="password" id="pass" type="password" placeholder="password">
    <input id="submit" type="submit">
</form>

</body>

</html>
