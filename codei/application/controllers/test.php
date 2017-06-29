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

    public function index() {

        return $this->load->view("test/main");
    }

    function get_view_from_temp() {

        $data['page_title'] = "page_title";

        $partials = array('content' => 'test/all_results');
        $this->template->load('test/main', $partials, $data);
    }

    function check_ajax() {
        return "aaa";
        //return $this->load->view("test/new_view");
    }

}
