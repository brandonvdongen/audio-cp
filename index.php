<?php
require_once("php/session.php");
require_once("php/classes.php");
$auth = new auth();
$perms = $auth->get_permissions();
echo "<pre>";
print_r($perms);
echo "</pre>";
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <title>opgave x</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <script src="js/song_controls.js"></script>
    <script src="js/post.js"></script>
    <script src="js/functions.js"></script>
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