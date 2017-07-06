<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_controller
 *
 * @author Heshani
 */
class Home_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        return $this->load->view("home/template");
    }

    function add_view() {
        return $this->load->view("home/add_view");
    }

    function get_edit_content() {

        $data['name'] = $this->input->post('name', TRUE);
        return $this->load->view("home/edit_content", $data);
    }
    
    function add_data(){
        
        echo '1';
    }

}
