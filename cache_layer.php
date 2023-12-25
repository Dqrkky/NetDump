<?php
class Cache {
    public function __construct(string $cache = null) {
        $this->config = array();
        $this["config"]["cache"] = $cache;
    } 
}

?>