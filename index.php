<?php
require_once("php/session.php");
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <title>opgave x</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/home.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
if ($_SESSION["loggedin"] == false) {
    echo '<a href="php/login.php">login</a>';
} else {
    echo 'logged in as: ' . $_SESSION["nickname"];
    echo '<br>';
    echo '<a href="php/logout.php">logout</a>';
    echo '<br>';
    echo "Permissions:";
    echo '<br>';
    echo 'see_all:'.$_SESSION["perm:see_all"];
    echo '<br>';
    echo 'edit_all:'.$_SESSION["perm:edit_all"];

}
?>
</body>

</html>