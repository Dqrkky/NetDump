<?php

header_remove("X-Powered-By");
header('Access-Control-Allow-Origin: *');
header('Content-Tyep: application/json');

$request = array(
    'method' => $_SERVER['REQUEST_METHOD'],
    'path' => parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH),
    'params' => $_GET
);

switch ($request["method"]) {
    case "GET":
        switch ($request["path"]) {
            case "/api/user":
                echo json_encode(["message" => "GET request to /api/user", "params" => $parameters], JSON_PRETTY_PRINT);
                break;
            default:
                http_response_code(404);
                echo json_encode(["error" => "Endpoint not found"], JSON_PRETTY_PRINT);
        }
    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"], JSON_PRETTY_PRINT);
}

?>