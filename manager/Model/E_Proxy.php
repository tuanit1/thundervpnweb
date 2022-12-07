<?php
    class Entity_Proxy{
        public $id;
        public $host;
        public $port;
        public $username;
        public $password;
        public $country_id;

        public function __construct($_id, $_host, $_port, $_username, $_password, $_country_id){
            $this->id = $_id;
            $this->host = $_host;
            $this->port = $_port;
            $this->username = $_username;
            $this->password = $_password;
            $this->country_id = $_country_id;
        }
    }

?>