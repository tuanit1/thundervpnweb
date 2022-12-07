<?php
    class Entity_Country{
        public $id;
        public $name;
        public $isPremium;
        public $thumb;

        public function __construct($_id, $_name, $_isPremium, $_thumb) {
            $this->id = $_id;
            $this->name = $_name;
            $this->isPremium = $_isPremium;
            $this->thumb = $_thumb;
        }
    }

?>