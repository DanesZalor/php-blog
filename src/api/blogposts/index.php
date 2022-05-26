<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/api/commons.php' ?>
<?php


if ($_SERVER['REQUEST_METHOD'] == "GET") {

    if ($body->fromAuthor != null) {
        respond( // get all posts fromAuthor
            db_query("SELECT * FROM blogpost WHERE poster='$body->fromAuthor'")->fetchAll(PDO::FETCH_ASSOC),
            200
        );
    } else {
        respond( // get all posts
            db_query("SELECT * FROM blogpost")->fetchAll(PDO::FETCH_ASSOC),
            200
        );
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($basicAuth['authorized'] == true) {

        if ($body->content != null) {
            $postTime = date('Y/m/d H:i:s');

            db_query(
                "INSERT INTO blogpost (posttime, poster, content)
                VALUES ('${postTime}','${basicAuth['user']}','$body->content')"
            );

            $currIdx = db_query("SELECT last_value FROM blogpost_id_seq")->fetchAll(PDO::FETCH_NUM)[0];
            respond([
                "msg" => "Successfully added blogpost",
                [
                    "content" => trim($body->content),
                    "author" => $basicAuth['user'],
                    "postTime" => $postTime,
                ]
            ], 201);
        } else
            respond(["msg" => "requires content body"], 400);
    } else
        respond(["msg" => "Unauthorized"], 401);
} else
    respond(["msg" => "${_SERVER['REQUEST_METHOD']} not allowed"], 405);
