<?php
header_remove("X-Powered-By");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(
        array(
            'message' => 'Hello, this is a simple API!',
            'timestamp' => time(),
            'ipaddress' => $_SERVER['REMOTE_ADDR']
        )
    );
} else {
    http_response_code(405);
    echo json_encode(array('error' => 'Method Not Allowed'));
}
?>
