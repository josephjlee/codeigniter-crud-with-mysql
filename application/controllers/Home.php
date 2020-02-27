<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct(){
        parent::__construct();
        //$this->load->helper('url');
    }

	public function index(){
        $data = [
            'title' => 'HomePage | CodeIgniter 3.1.11',
            'h1' => 'HomePage',
            'description' => 'Crud de Categorias e Produtos desenvolvido com o <strong><i>Framework CodeIgniter 3.1.11 e MySQL 5.6</i></strong>',
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/home', $data);
        $this->load->view('templates/footer');
    }
}
