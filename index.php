<?php

include("capture_packets.php");

header_remove("X-Powered-By");

$method = $_SERVER['REQUEST_METHOD'];
$url = $_SERVER['REQUEST_URI'];
$params = $_GET;

$body = file_get_contents("php://input");

$headers = getallheaders();

header("Content-Type: application/json");

// Initialize class
$ts = new TShark(
    "D:\\Programs\\Other\\WiresharkPortable64\\App\\Wireshark\\tshark.exe"
);

// Check server HTTP method
if ($method === "GET" && $url == "/api/capture") {
    print_r($ts->capture("WiFi"));
} else {
    http_response_code(405);
    echo json_encode(
        array(
            "method" => $method,
            "url" => $url,
            "params" => $params,
            "body" => $body,
            "headers" => $headers
        )
    );
}

?>
