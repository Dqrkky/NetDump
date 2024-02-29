<?php

header_remove("X-Powered-By");
header('Access-Control-Allow-Origin: *');

$request = array(
    'method' => $_SERVER['REQUEST_METHOD'],
    'path' => parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH),
    'params' => $_GET
);

switch ($request['method']) {
    case 'GET':
        if (preg_match('/\/api\/uptimerobot\/status\/([\w@]+)\/([\w@]+)/', $request['path'], $matches)) {
            $url = "http://stats.uptimerobot.com/api/getMonitor/{$matches[1]}?m={$matches[2]}";
            $command = "curl -s -L {$url}";
            $response = shell_exec($command);
            if ($response != null) {
                $new_response = json_decode($response, true);
                if ($new_response && isset($new_response['status']) && $new_response['status'] == 'ok') {
                    http_response_code(200);
                    header('Content-Type: application/json');
                    echo json_encode($new_response);
                } else {
                    http_response_code(400);
                    header('Content-Type: application/json');
                    echo json_encode(['error' => 'Status error']);
                };
            } else {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Invalid request']);
            };
        } else if (preg_match('/\/api\/uptimerobot\/status\/([\w@]+)/', $request['path'], $matches)) {
            $url = "http://stats.uptimerobot.com/api/getMonitorList/{$matches[1]}";
            $command = "curl -s -L {$url}";
            $response = shell_exec($command);
            if ($response != null) {
                $new_response = json_decode($response, true);
                if ($new_response && isset($new_response['status']) && $new_response['status'] == 'ok') {
                    http_response_code(200);
                    header('Content-Type: application/json');
                    echo json_encode($new_response);
                } else {
                    http_response_code(400);
                    header('Content-Type: application/json');
                    echo json_encode(['error' => 'Status error']);
                };
            } else {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Invalid request']);
            };
        } else if ($request['path'] == "/api/wireshark/capture") {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'wip']);
        } else {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Invalid request']);
        };
        break;
    default:
        http_response_code(405);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Method not allowed']);
        break;
}