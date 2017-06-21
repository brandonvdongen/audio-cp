<?php
$auth_config = parse_ini_file("auth.ini");
$auth_user = $auth_config["username"];
$auth_pass = $auth_config["password"];
$auth_database = $auth_config["database"];


$conn = new mysqli("localhost", $auth_user, $auth_pass, $auth_database);
if (!$conn) {
    #error:1
    echo "error, if you see this please contact the site administrator with and include the error code : 1";
} else {
    $stmt = $conn->prepare("SELECT permissions.edit_all, permissions.see_all FROM users INNER JOIN permissions ON users.id_users=permissions.id_permissions WHERE users.id_users=?");
    $stmt->bind_param("s", $_SESSION["id_user"]);
    $stmt->execute();
    $stmt->bind_result($auth_edit_all, $auth_see_all);

    $stmt->close();
}