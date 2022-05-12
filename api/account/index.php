<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php

$dbc = new PDO( // pgsql db connect
    "pgsql:host=${_SESSION['db_host']};port=5432;dbname=${_SESSION['db_name']};",
    $_SESSION['db_user'],
    $_SESSION['db_pass']
);

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $param = array_filter(
        explode(
            "/",
            str_replace("/api/account/", "", $_SERVER['REQUEST_URI'])
        )
    );

    switch (sizeof($param)) {
        case 0:
            $query_res = $dbc->query("SELECT * FROM account");
            $data = $query_res->fetchAll(PDO::FETCH_ASSOC);
            break;
        case 1:
            //$data = ["msg" => "GET account WITH ID=" . $param[0]];
            $query_res = $dbc->query("SELECT * FROM account WHERE username='${param[0]}'");

            if ($query_res->rowCount() == 1)
                $data = $query_res->fetchAll(PDO::FETCH_ASSOC)[0];
            else $data = ["msg" => "not found."];

            break;
        default:
            $data = ["msg" => "wrong use case"];
    }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
