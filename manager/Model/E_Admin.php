<?php

    class Entity_Admin{

        public $id;

        public $username;

        public $password;

        public $default_proxy;

        public $inters_ads_count;



        public function __construct($_id, $_username, $_password, $_default_proxy, $_inter_ads_count) {

            $this->id = $_id;

            $this->username = $_username;

            $this->password = $_password;

            $this->default_proxy = $_default_proxy;

            $this->inters_ads_count = $_inter_ads_count;

        }

    }



?>