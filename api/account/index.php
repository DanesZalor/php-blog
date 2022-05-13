<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/api/commons.php' ?>
<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    if ($body->username != null) {
        $query_res = db_query("SELECT * FROM account WHERE username='$body->username'");

        if ($query_res->rowCount() > 0)
            respond($query_res->fetchAll(PDO::FETCH_NUM)[0], 200);
        else
            respond(["msg" => "$body->username not found"], 404);
    } else
        respond(["msg" => "specify username"], 403);
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {

    if ($basicAuth['authorized']) {
        try {
            if (
                db_query("SELECT * FROM account WHERE username='${basicAuth['user']}'")->rowCount() > 0
            ) {
                db_query("DELETE FROM account WHERE username='${basicAuth['user']}'");
                respond(["msg" => "Successfully deleted ${basicAuth['user']}"], 202);
            } else
                respond(["msg" => $basicAuth['user'] . " not found"], 404);
        } catch (PDOException $e) {
            respond(["msg" => "${param[0]} has existing blogposts"], 403);
        }
    } else
        respond(["msg" => "requires authentication"], 401);
} else
    respond(["msg" => "${_SERVER['REQUEST_METHOD']} not allowed"], 405);
