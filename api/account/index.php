<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php

$dbc = new PDO( // pgsql db connect
    "pgsql:host=${_SESSION['db_host']};port=5432;dbname=${_SESSION['db_name']};",
    $_SESSION['db_user'],
    $_SESSION['db_pass']
);

$param = array_filter(
    explode(
        "/",
        str_replace("/api/account/", "", $_SERVER['REQUEST_URI'])
    )
);

$body = json_decode(file_get_contents('php://input'));

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    switch (sizeof($param)) {
        case 0:
            $query_res = $dbc->query("SELECT * FROM account");
            $data = $query_res->fetchAll(PDO::FETCH_ASSOC);
            break;
        case 1:
            $query_res = $dbc->query("SELECT * FROM account WHERE username='${param[0]}'");

            if ($query_res->rowCount() == 1)
                $data = $query_res->fetchAll(PDO::FETCH_ASSOC)[0];
            else $data = ["msg" => "not found."];

            break;
        default:
            $data = ["msg" => "wrong use case"];
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if ($body->username != null && $body->password != null) {
        try {
            $query_res = $dbc->query(
                "INSERT INTO account (username, password) VALUES ('$body->username','$body->password')",
            );
            $data = ["msg" => "Successfully added.", "body" => $body];
        } catch (PDOException $e) {
            $data = ["msg" => "Error"];
        }
    } else
        $data = ["msg" => "required parameters: username:string, password:string"];
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {

    if (sizeof($param) == 1) {
        try {
            $query_res = $dbc->query("SELECT * FROM account WHERE username='${param[0]}'");
            if ($query_res->rowCount() > 0) {
                $query_res = $dbc->query("DELETE FROM account WHERE username='${param[0]}'");
                $data = ["msg" => "Successfully deleted ${param[0]}"];
            } else
                $data = ["msg" => "${param[0]} not found"];
        } catch (PDOException $e) {
            $data = ["msg" => "${param[0]} has existing blogposts"];
        }
    } else
        $data = ["msg" => "wrong use case"];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
