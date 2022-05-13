<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/api/commons.php' ?>
<?php

$param = get_uri_params("/api/blogposts/");

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    switch (sizeof($param)) {
        case 0:
            respond(
                db_query("SELECT * FROM blogpost")->fetchAll(PDO::FETCH_ASSOC),
                200
            );
            break;
        case 1:
            respond(
                db_query("SELECT * FROM blogpost WHERE poster='${param[0]}'")->fetchAll(PDO::FETCH_ASSOC),
                200
            );
            break;
        default:
            respond(["msg" => "wrong use case"], 406);
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        "msg" => "POSTING",
        "body" => $body
    ];
    respond($data, 200);
}
