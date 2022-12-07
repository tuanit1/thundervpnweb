<?php
    class Entity_User{
        public $uid;
        public $email;
        public $name;
        public $expired_date;

        public function __construct($_uid, $_email, $_name, $_expired_date){
            $this->uid = $_uid;
            $this->email = $_email;
            $this->name = $_name;
            $this->expired_date = $_expired_date;
        }
    }

?>