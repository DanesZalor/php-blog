<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php
$param = array_filter(
    explode(
        "/",
        str_replace("/api/blogposts/", "", $_SERVER['REQUEST_URI'])
    )
);

$body = json_decode(file_get_contents('php://input'));

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    switch (sizeof($param)) {
        case 0:
            $query_res = $dbc->query("SELECT * FROM blogpost");
            $data = $query_res->fetchAll(PDO::FETCH_ASSOC);
            break;
        case 1:
            $query_res = $dbc->query("SELECT * FROM blogpost WHERE poster='${param[0]}'");
            $data = $query_res->fetchAll(PDO::FETCH_ASSOC);
            break;
        default:
            $data = ["msg" => "wrong use case"];
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        "msg" => "POSTING",
        "body" => $body
    ];
}

$data["auth"] = [
    "user" => $_SERVER['PHP_AUTH_USER'],
    "pass" => $_SERVER['PHP_AUTH_PW'],
];
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
