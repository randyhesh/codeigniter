<?php

class Customer_service extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function insert_customer($customer_model) {

        return $this->db->insert($customer_model, 'customer');
    }

    function update_customer($customer_model) {
        $data = array(
            'name' => $customer_model->get_name(),
            'age' => $customer_model->get_age()
        );

        $this->db->where('id', $customer_model->get_id());
        return $this->db->update('customer', $data);
    }

    function get_all_customers() {

        $this->db->select('customer.*');
        $this->db->from('customer');
        $query = $this->db->get();
        return $query->result();
    }

    function get_customer($id) {

        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function delete_customer($customer_model) {

        $this->db->where('id', $customer_model->get_id());
        return $this->db->delete('customer');
    }

}
