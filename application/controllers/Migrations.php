<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrations extends CI_Controller {


	public function index()
	{
        $this->load->library('migration');

        if(!$this->migration->version(1)){
            echo "error";
        }else{
            echo "success";
        }
	}
}
