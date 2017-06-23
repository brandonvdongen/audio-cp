<?php
require_once("php/session.php");
if ($_SESSION["loggedin"] == false) {
    header("Location: pages/login.php");
}
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
echo 'logged in as: ' . $_SESSION["nickname"];
echo '<br>';
echo '<a href="php/logout.php">logout</a>';
echo '<hr>';
?>
<table id="songlist">
    <tr>
        <th>
            name
        </th>
        <th>
            author
        </th>
        <th>owner</th>
    </tr>
    <?php
    require_once("php/songlist.php");
    ?>
</table>
</body>

</html>