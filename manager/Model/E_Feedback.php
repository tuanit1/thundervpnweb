<?php
    class Entity_Feedback{
        public $id;
        public $message;
        public $date;
        public $user_id;

        public function __construct($_id, $_message, $_date, $_user_id) {
            $this->id = $_id;
            $this->message = $_message;
            $this->date = $_date;
            $this->user_id = $_user_id;
        }
    }

?>