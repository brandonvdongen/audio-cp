<?php
require_once("../php/session.php");
require_once("../php/post.php");
require_once ("../classes/database.class.php");
require_once ("../classes/auth.class.php");
$database = new Database();
$auth = new Auth($database);

$control_config = parse_ini_file("version.ini");
$control_version = $control_config["version"];

$output = [];
function reply($text)
{
    global $output;
    $output[] = $text;
}

if (stristr($_SERVER["HTTP_USER_AGENT"], "second life")) {
    if ($_POST["version"] != $control_version) {
        echo "INCOMPATIBLE_VERSION";
        exit();
    }

    if ($_POST["status"] == "LINK_REQUEST") {
        $result = $database->prepared_query("SELECT * FROM users WHERE users.uuid=?", [$_SERVER["HTTP_X_SECONDLIFE_OWNER_KEY"]]);
        if (!$result) {
            $password = substr(md5(rand()), 0, 7);
            $control_db_password = password_hash($password, PASSWORD_DEFAULT);
            $result = $database->prepared_query("INSERT INTO users(username, nickname, password, uuid) VALUES (?,?,?,?);",
                [
                    $_SERVER["HTTP_X_SECONDLIFE_OWNER_NAME"],
                    $_SERVER["HTTP_X_SECONDLIFE_OWNER_NAME"],
                    $control_db_password,
                    $_SERVER["HTTP_X_SECONDLIFE_OWNER_KEY"]
                ]);
            $result = $database->prepared_query("INSERT INTO permissions(id_users) VALUES (LAST_INSERT_ID());", []);
            if ($result) {
                reply("ACCOUNT_CREATED");
                reply("TEMP_PASSWORD");
                reply($password);
                print_r($result);
            } else {
                reply("ACCOUNT_CREATION_FAILED");
            }

        } else {
            $url = $_POST["url"];
            $database->prepared_query("UPDATE users SET link = ? WHERE users.uuid = ?", [$url, $result->uuid]);
            reply("ACCOUNT_FOUND");
            reply($result->uuid);
            reply("UPDATE users SET link = '$url' WHERE users.uuid = $result->uuid");
        }
    }
} else {
    print_r($_POST);
    if (isset($_POST["load_id"])) {
        $load_id = $_POST["load_id"];
        $url = $database->prepared_query("SELECT link FROM users WHERE id_user=?", [$auth->get_id()]);
        $song = $database->prepared_query("SELECT users.uuid AS owner, song_name, song_author, song_data FROM songs INNER JOIN users ON songs.id_owner=users.id_user WHERE id_song=?", [$load_id]);
        httpPost($url->link, "LOAD_SONG|uploader|" . $song->owner . "|song_name|" . $song->song_name . "|song_author|" . $song->song_author . "|" . str_replace(array("\n", "\r"), array("|"), $song->song_data));
    }
}

echo implode("|", $output);