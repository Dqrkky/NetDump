<?php
// Inclute filles
include("capture_packets.php");

// Remove the header php info
header_remove("X-Powered-By");

// Get the HTTP method
$method = $_SERVER['REQUEST_METHOD'];

// Get the URL
$url = $_SERVER['REQUEST_URI'];

// Get the parameters
$params = $_GET;

// Get the request body
$body = file_get_contents("php://input");

// Get the headers
$headers = getallheaders();

// Set header for json
header("Content-Type: application/json");

// Initialize class
$ts = new TShark(
    "D:\\Programs\\Other\\WiresharkPortable64\\App\\Wireshark\\tshark.exe"
);

// Check server HTTP method
if ($method === "GET" && $url == "/api/a") {
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
