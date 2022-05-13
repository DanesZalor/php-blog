<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/api/commons.php' ?>
<?php

$param = get_uri_params("/api/account/");

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    if (sizeof($param) == 1) {
        $query_res = db_query("SELECT * FROM account WHERE username='${param[0]}'");

        if ($query_res->rowCount() == 1)
            respond($query_res->fetchAll(PDO::FETCH_ASSOC)[0], 202);
        else
            respond(["msg" => $param[0] . " not found"], 404);
    } else
        respond(["msg" => " wrong use case"], 403);
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {

    if (sizeof($param) == 1) {
        try {
            if (
                db_query("SELECT * FROM account WHERE username='${param[0]}'")->rowCount() > 0
            ) {
                db_query("DELETE FROM account WHERE username='${param[0]}'");
                respond(["msg" => "Successfully deleted ${param[0]}"], 202);
            } else
                respond(["msg" => $param[0] . " not found"], 404);
        } catch (PDOException $e) {
            respond(["msg" => "${param[0]} has existing blogposts"], 403);
        }
    } else
        respond(["msg" => "wrong use case"], 400);
} else
    respond(["msg" => "HTTP method not allowed"], 501);
