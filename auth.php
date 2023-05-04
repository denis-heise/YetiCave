<?php
session_start();
$is_auth = !empty($_SESSION["name"]);
if ($is_auth) {
    $user_name = $_SESSION["name"];
    $user_id = $_SESSION["id"];
}
