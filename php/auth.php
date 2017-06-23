<?php
$auth_config = parse_ini_file("auth.ini");
$auth_user = $auth_config["username"];
$auth_pass = $auth_config["password"];
$auth_database = $auth_config["database"];


$conn = new PDO("mysql:host=localhost;dbname=$auth_database", $auth_user, $auth_pass);
if (!$conn) {
    #error:1
    echo "error, if you see this please contact the site administrator with and include the error code : 1";
}

function get_permissions()
{
    global $conn;
    $stmt = $conn->prepare("SELECT permissions.edit_all,permissions.see_all FROM permissions INNER JOIN users ON users.id_users=permissions.id_permissions WHERE users.id_users=?");
    $stmt->bindValue(1, $_SESSION["id_users"]);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);

    return $result;
}
