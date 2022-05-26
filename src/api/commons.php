<?php

$body = json_decode(file_get_contents('php://input'));


$basicAuth = [
    "user" => array_key_exists('PHP_AUTH_USER', $_SERVER) ? $_SERVER['PHP_AUTH_USER'] : '',
    "pass" => array_key_exists('PHP_AUTH_PW', $_SERVER) ? $_SERVER['PHP_AUTH_PW'] : '',
    "authorized" => false,
];

if (
    $basicAuth['user'] != '' &&
    $basicAuth['pass'] != '' &&
    db_query(
        "SELECT * FROM account WHERE 
    username='${basicAuth['user']}' AND 
    password='${basicAuth['pass']}'"
    )->rowCount() > 0
) $basicAuth['authorized'] = true;


/**
 * send json http_response
 * 
 * @param array $data the data to be shown in the response code. It is encoded in json.
 * @param int $responseCode http response code
 */
function respond($data, int $responseCode)
{
    header('Content-Type: application/json', true, $responseCode);
    echo json_encode($data);
}
