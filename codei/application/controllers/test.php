<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author Heshani
 */
class Test extends CI_Controller {

    function __construct() {
        parent::__construct();

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    }

    public function index() {

        return $this->load->view("test/main");
    }

    function get_view_from_temp() {

        $data['page_title'] = "page_title";

        $partials = array('content' => 'test/all_results');
        $this->template->load('test/main', $partials, $data);
    }

    function check_ajax() {
        
        return $this->load->view("test/new_view");
    }

}
