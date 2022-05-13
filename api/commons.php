<?php

$body = json_decode(file_get_contents('php://input'));

function respond($data, int $responseCode)
{
    header('Content-Type: application/json; charset=utf-8', true, $responseCode);
    echo json_encode($data);
}

function get_uri_params(string $basePath)
{
    return array_filter(
        explode(
            "/",
            str_replace($basePath, "", $_SERVER['REQUEST_URI'])
        )
    );
}
