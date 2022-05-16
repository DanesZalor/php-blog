<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/api/commons.php' ?>
<?php


if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $query_res = db_query("SELECT username FROM account");
    respond($query_res->fetchAll(PDO::FETCH_ASSOC), 200);
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if ($body->username != null && $body->password != null && $body->confirmPass != null) {
        try {
            if ($body->password == $body->confirmPass) {
                $query_res = db_query(
                    "INSERT INTO account (username, password) VALUES ('$body->username','$body->password')"
                );
                respond(["msg" => "Successfully added"], 201);
            } else
                respond(["msg" => "password and confirmPass doesn't match"], 406);
        } catch (PDOException $e) {
            respond(["msg" => $body->username . " already exists."], 403);
        }
    } else
        respond(["msg" => "required username:string, password:string confirmPass:string"], 400);
} else
    respond(["msg" => "${_SERVER['REQUEST_METHOD']} not allowed"], 405);
