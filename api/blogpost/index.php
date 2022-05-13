<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/api/commons.php' ?>
<?php
$param = get_uri_params("/api/blogpost/");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
} else
    respond("${_SERVER['REQUEST_METHOD']} not allowed", 405);
