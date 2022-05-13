<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/api/commons.php' ?>
<?php
$param = get_uri_params("/api/blogpost/");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (sizeof($param) == 1) {
        $query_res = db_query("SELECT * FROM blogpost WHERE id='${param[0]}'");
        if ($query_res->rowCount() == 1) {
            respond(
                $query_res->fetchAll(PDO::FETCH_NUM)[0],
                200
            );
        } else respond(["msg" => "post " . $param[0] . " not found"], 404);
    } else
        respond(["msg" => "wrong usage"], 406);
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {

    if (sizeof($param) != 1)
        respond(["msg" => "requires 1 param"], 400);

    else if (
        $basicAuth['authorized'] &&
        db_query(
            "SELECT * FROM blogpost WHERE id='${param[0]}' 
            AND poster='${basicAuth['user']}'"
        )->rowCount() > 0
    ) {
        $query_res = db_query("SELECT * FROM blogpost WHERE id='${param[0]}'");
        if ($query_res->rowCount() > 0) {
            db_query("DELETE FROM blogpost WHERE id='${param[0]}'");
            respond(["msg" => "blogpost " . $param[0] . " deleted successfuly."], 200);
        } else
            respond(["msg" => "blogpost " . $param[0] . " not found"], 404);
    } else
        respond(["msg" => "requires Authenticated Owner"], 401);
} else
    respond(["msg" => "${_SERVER['REQUEST_METHOD']} not allowed"], 405);
