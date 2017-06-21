<?php
$stmt = $conn->prepare("SELECT permissions.edit_all, permissions.see_all FROM users INNER JOIN permissions ON users.id_users=permissions.id_permissions WHERE users.id_users=?");
$stmt->bind_param("s", $_SESSION["id_user"]);
$stmt->execute();
$stmt->bind_result($auth_edit_all,$auth_see_all);

$_SESSION["perm:edit_all"]=$auth_edit_all;
$_SESSION["perm:see_all"]=$auth_see_all;

$stmt->close();
