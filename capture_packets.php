<?php

class TShark {
    private $config = array();

    public function __construct(string $path = null) {
        $this->config["path"] = ($path && is_string($path)) ? $path : null;
    }

    public function capture(string $networkInterface = null) {
        $tsharkPath = $this->config["path"];
        $command = "$tsharkPath -i $networkInterface -l -T fields -e frame.number -e frame.len -e frame.time -e ip.src -e ip.dst -e tcp.srcport -e tcp.dstport";
        exec($command, $output, $code);
        return $output;
    }
}


        // if (!empty($line)) {
        //     $data = explode("\t", trim($line));
        //     $packet = [
        //         "number" => $data[0],
        //         "length" => $data[1],
        //         "sniff_time" => $data[2],
        //         "source_address" => $data[3],
        //         "destination_address" => $data[4],
        //         "source_port" => $data[5],
        //         "destination_port" => $data[6],
        //     ];
        //     yield $packet;
        // }
?>