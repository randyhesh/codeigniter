<?php

class Customer_model extends CI_Model {

    var $id;
    var $name;
    var $age;

    function get_id() {
        return $this->id;
    }

    function get_name() {
        return $this->name;
    }

    function get_age() {
        return $this->age;
    }

    function set_id($id) {
        $this->id = $id;
    }

    function set_name($name) {
        $this->name = $name;
    }

    function set_age($age) {
        $this->age = $age;
    }

}
