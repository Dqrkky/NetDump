<?php
class Cache {
    public function __construct(string $cache = null) {
        $this->config = array();
        $this["config"]["cache"] = $cache;
    }
    public function is_valid() {
        return false;
    }
}

?>