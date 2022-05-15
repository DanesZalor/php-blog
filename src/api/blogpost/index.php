<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/api/commons.php' ?>
<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ($body->id != null) {
        $query_res = db_query("SELECT * FROM blogpost WHERE id='$body->id'");
        if ($query_res->rowCount() == 1) {
            respond(
                $query_res->fetchAll(PDO::FETCH_ASSOC)[0],
                200
            );
        } else respond(["msg" => "post $body->id not found"], 404);
    } else
        respond(["msg" => "specify id"], 406);
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {

    if ($body->id == null)
        respond(["msg" => "specify id"], 400);
    else {
        $query_res = db_query("SELECT * FROM blogpost WHERE id='$body->id'");
        if ($query_res->rowCount() == 1) {
            $retrievedBlogpost = $query_res->fetchAll(PDO::FETCH_ASSOC)[0];
            if (
                $basicAuth['authorized'] &&
                $retrievedBlogpost['poster'] == $basicAuth['user']
            ) {
                db_query("DELETE FROM blogpost WHERE poster='${basicAuth['user']}' AND id=$body->id");
                respond(["msg" => "Deleted blogpost:$body->id successfuly."], 200);
            } else respond([
                "msg" => "unauthorized to delete post",
                "request_user" => $basicAuth['user'],
                "authorized_user" => $retrievedBlogpost['poster']
            ], 403);
        } else respond(["msg" => "postid $body->id not found"], 404);
    }
} else
    respond(["msg" => "${_SERVER['REQUEST_METHOD']} not allowed"], 405);
