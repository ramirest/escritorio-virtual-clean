<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelecommerce_crud extends grocery_CRUD_model {

    private  $query_str = '';
    function __construct() {
        parent::__construct();
    }

    function get_primary_key()
    {
        return "product_id";
    }

}