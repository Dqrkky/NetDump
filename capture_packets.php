<?php

class TShark {
    private $config = array();

    public function __construct(string $path = null) {
        $this->config["path"] = ($path && is_string($path)) ? $path : null;
    }

    public function capture(string $networkInterface = null) {
        $tsharkPath = $this->config["path"];
        $command = "$tsharkPath -i $networkInterface -l -T fields -e frame.number -e frame.len -e frame.time -e ip.src -e ip.dst -e tcp.srcport -e tcp.dstport";
        $descriptorspec = [
            0 => ["pipe", "r"],
            1 => ["pipe", "w"],
            2 => ["pipe", "w"],
        ];
        $process = proc_open($command, $descriptorspec, $pipes);
        if (is_resource($process)) {
            stream_set_blocking($pipes[1], 0);
            while (!feof($pipes[1])) {
                $line = fgets($pipes[1]);
                if ($line) {
                    $fields = explode("\t", $line); // Split the line by tabs
                    $data = array(
                        'frame_number' => $fields[0],
                        'frame_len' => $fields[1],
                        'frame_time' => $fields[2],
                        'ip_src' => $fields[3],
                        'ip_dst' => $fields[4],
                        'tcp_srcport' => $fields[5],
                        'tcp_dstport' => $fields[6]
                    );
                    echo json_encode($data);
                    echo "\n";
                }
                flush();
            }
            
            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);
        } else {
            echo "Failed to open tshark process. Check if tshark is installed and the path is correct.";
        }
    }
}