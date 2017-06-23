<?php
require_once("../php/session.php");
require_once("../php/classes.php");

$control_config = parse_ini_file("version.ini");
$control_version = $control_config["version"];

$output = [];
function reply($text)
{
    global $output;
    $output[] = $text;
}

if (stristr($_SERVER["HTTP_USER_AGENT"],"second life")) {
    if ($_POST["version"] != $control_version) {
        echo "INCOMPATIBLE_VERSION";
        exit();
    }

    if ($_POST["status"] == "LINK_REQUEST") {
        $stmt = $conn->prepare("SELECT * FROM users WHERE users.uuid=?");
        $stmt->bindValue(1, $_SERVER["HTTP_X_SECONDLIFE_OWNER_KEY"]);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        if (!$result) {
            $password = substr(md5(rand()), 0, 7);
            $control_db_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users(username, nickname, password, uuid) VALUES (?,?,?,?);");
            $stmt->bindValue(1, $_SERVER["HTTP_X_SECONDLIFE_OWNER_NAME"]);
            $stmt->bindValue(2, $_SERVER["HTTP_X_SECONDLIFE_OWNER_NAME"]);
            $stmt->bindValue(3, $control_db_password);
            $stmt->bindValue(4, $_SERVER["HTTP_X_SECONDLIFE_OWNER_KEY"]);
            $exec1 = $stmt->execute();
            $stmt = $conn->prepare("INSERT INTO permissions(id_users) VALUES (LAST_INSERT_ID());");
            $exec2 = $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);

            if ($exec1 && $exec2) {
                reply("ACCOUNT_CREATED");
                reply("TEMP_PASSWORD");
                reply($password);
                print_r($result);
            } else {
                reply("ACCOUNT_CREATION_FAILED");
            }

        } else {
            reply("ACCOUNT_FOUND");
            reply($result->uuid);
        }
    }
}else{
    echo "nothing to see here";
}

echo implode("|", $output);