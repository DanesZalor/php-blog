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
        str_replace("/api/accounts/", "", $_SERVER['REQUEST_URI'])
    )
);

$body = json_decode(file_get_contents('php://input'));

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    if (sizeof($param) == 0) {
        $query_res = $dbc->query("SELECT * FROM account");
        $data = $query_res->fetchAll(PDO::FETCH_ASSOC);
    } else
        $data = ["msg" => "wrong use case"];
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
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
