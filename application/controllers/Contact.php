<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function __construct(){
        parent::__construct();
        //$this->output->cache(2);
    }

	public function index(){
        
        $data = [
            'title' => 'Contact | CodeIgniter 3.1.11',
            'h1' => 'Contate-nos',
            'form_status' => false,
            'email_alert' => '',
            'email_msg' => '',
        ];

        $this->load->helper('form');
        $this->load->library(['form_validation', 'email']);
        $this->form_validation->set_rules('name', 'Nome', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('subject', 'Assunto', 'required');

        $is_valid = $this->form_validation->run();

        if($is_valid){
             
            $dados_form = $this->input->post();
            
            $this->email->from($dados_form['email'], $dados_form['name']);
            $this->email->to('mfabiodias@gmail.com');
            $this->email->subject($dados_form['subject']);
            $this->email->message($dados_form['message']);
            
            if($this->email->send()): 
                $data['form_status'] = true;
                $data['email_alert'] = 'alert-success';
                $data['email_msg'] = 'Email enviado com sucesso!';
            else:
                $data['email_alert'] = 'alert-danger';
                $data['email_msg'] = 'Falha no envio do email!';
            endif;
            // echo "<br><br><br><br><br>";
            // print_r($dados_form);
        }

        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/contact', $data);
        $this->load->view('templates/footer');
	}
}
