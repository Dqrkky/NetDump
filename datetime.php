<?php

header_remove("X-Powered-By");
header("Cache-Control: no-cache");
header('Access-Control-Allow-Origin: *');
header("Content-Type: text/event-stream");
date_default_timezone_set("Europe/Athens");

set_time_limit(0);

ini_set('output_buffering', 0);

while (true) {
    $dateTime = date('Y-m-d H:i:s');
    list($date, $time) = explode(' ', $dateTime);
    list($year, $month, $day) = explode('-', $date);
    list($hour, $minutes, $seconds) = explode(':', $time);
    $data = array(
        'headers' => array(
            'Content-Type' => 'aplication/json'
        ),
        'data' => array(
            'date' => array(
                'year' => $year,
                'month' => $month,
                'day' => $day,
            ),
            'time' => array(
                'hour' => $hour,
                'minutes' => $minutes,
                'seconds' => $seconds,
            )
        )
    );
    if (isset($_GET['format'])) {
        if (strtolower($_GET['format']) == 'json') {
            echo json_encode($data);
            echo "\n";
        } else {
            echo json_encode(
                array(
                    'headers' => array(
                        'Content-Type' => 'aplication/json'
                    ),
                    'data' => array(
                        'error' => "Format {$_GET['format']} does not exist"
                    )
                )
            );
            echo "\n";
            break;
        }
    } else {
        echo json_encode(
            array(
                'headers' => array(
                    'Content-Type' => 'aplication/json'
                ),
                'data' => array(
                    'error' => "Parameter 'format' does not exist"
                )
            )
        );
        echo "\n";
        break;
    }
    if (ob_get_level() > 0) ob_end_flush();
    flush();
    if (connection_aborted()) break;
    usleep(1000000);
}