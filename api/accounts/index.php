<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/api/commons.php' ?>
<?php

$param = get_uri_params("/api/accounts/");

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    if (sizeof($param) == 0) {
        $query_res = db_query("SELECT username FROM account");
        respond($query_res->fetchAll(PDO::FETCH_ASSOC), 200);
    } else
        respond(["msg" => "wrong use case"], 403);
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if ($body->username != null && $body->password != null && $body->confirmPass != null) {
        try {
            if ($body->password == $body->confirmPass) {
                $query_res = db_query(
                    "INSERT INTO account (username, password) VALUES ('$body->username','$body->password')"
                );
                respond(["msg" => "Successfully added.", "body" => $body], 201);
            } else
                respond(["msg" => "password and confirmPass doesn't match"], 406);
        } catch (PDOException $e) {
            respond(["msg" => $body->username . " already exists."], 403);
        }
    } else
        respond(["msg" => "required parameters: username:string, password:string confirmPass:string"], 400);
} else
    respond("${_SERVER['REQUEST_METHOD']} not allowed", 405);
