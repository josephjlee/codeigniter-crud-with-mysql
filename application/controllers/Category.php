<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Category_model', 'categories');
        $this->load->model('Product_model', 'products');
    }

	public function index(){

        $data = [
            'title' => 'Categorias | CodeIgniter 3.1.11',
            'h1' => 'Categorias',
            'categories' => $this->categories->getAll()->result(),
        ];

        if(isset($_SESSION["redirect_data"]))
        {
            $data['msg_type'] = $_SESSION["redirect_data"]['msg_type'];
            $data['msg_label'] = $_SESSION["redirect_data"]['msg_label'];
            unset($_SESSION["redirect_data"]);
        }
        else 
        {
            $data['msg_type'] = false;
            $data['msg_label'] = false;
        }
        
        $this->load->view('header', $data);
        $this->load->view('list_category', $data);
        $this->load->view('footer');
    }

    public function delete()
    {
        $id = $this->uri->segment(3);

        $data = [];
        
        if(!!$this->products->getOne("WHERE id_category = '{$id}'")->result())
        {
            $data['msg_type'] = 'alert-danger';
            $data['msg_label'] = "Categoria tem produtos vinculados e não é permitida sua remoção.";
        }
        else
        {
            $rtn = $this->categories->delete($id);
    
            if($rtn){
                $data['msg_type'] = 'alert-success';
                $data['msg_label'] = "Categoria ID: {$id} excluído com sucesso!";
            }
            else{
                $data['msg_type'] = 'alert-danger';
                $data['msg_label'] = "Problemas ao excluir a categoria com ID: {$id}!";
            }
        }

        $_SESSION["redirect_data"] = $data;
        
        redirect('/category', 'refresh');
    }

    public function upsert()
    {
        $data = [
            'form_status' => false,
            'form_alert' => '',
            'form_msg' => '',
            'upt' => (object)['id_category' => '', 'name' => '', 'url' => ''],
        ];
        
        // Update
        $id = $this->uri->segment(3);
        if($id)
        {
            $data['title'] = 'Atualizar Categoria | CodeIgniter 3.1.11';
            $data['h1'] = 'Atualizar Categoria';
            $data['btn'] = 'Atualizar';

            $upt = $this->categories->getOne("WHERE id_category = '{$id}'")->result();

            if(!$upt)
            {
                $data['msg_type'] = 'alert-danger';
                $data['msg_label'] = "Não existe a categoria com ID: {$id}!";

                $_SESSION["redirect_data"] = $data;
            
                redirect('/category', 'refresh');
            }
            else
            {
                $data['upt'] = $upt[0];
            }
        }
        // Insert
        else
        {
            $data['title'] = 'Cadastrar Categoria | CodeIgniter 3.1.11';
            $data['h1'] = 'Cadastrar Categoria';
            $data['btn'] = 'Cadastrar';
        }
        
        $this->load->helper(['form','funcoes_helper']);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Nome Categoria', 'trim|required');

        $is_valid = $this->form_validation->run();

        if($is_valid)
        {
            $dados_form = $this->input->post();

            if(!!trim($dados_form['url'])):
                $dados_form['url'] = urlSlug($dados_form['url']);
            else:
                $dados_form['url'] = urlSlug($dados_form['name']);
            endif;

            if(!!$this->categories->getOne("WHERE url = '".$dados_form['url']."'" . ($id ? " AND id_category <> {$id}" : ""))->result())
            {
                $data['form_status'] = true;
                $data['form_alert'] = 'alert-danger';
                $data['form_msg'] = 'URL já encontra-se registrado na base de dados!';
            }
            else
            {
                if($id)
                {
                    $dados_form['id_category'] = $id;
                    
                    if($this->categories->update($dados_form))
                    {
                        $data['msg_type'] = 'alert-success';
                        $data['msg_label'] = "Categoria ID: {$id} atualizado com sucesso!";
        
                        $_SESSION["redirect_data"] = $data;
                    
                        redirect('/category', 'refresh');
                    }
                    else
                    {
                        $data['form_status'] = true;
                        $data['form_alert'] = 'alert-danger';
                        $data['form_msg'] = 'Falha ao cadastrar categoria, contate o administrador!';
                    }
                }
                else
                {
                    if($this->categories->insert($dados_form))
                    {
                        $data['form_status'] = true;
                        $data['form_alert'] = 'alert-success';
                        $data['form_msg'] = 'Categoria cadastrada com sucesso!';
                    }
                    else
                    {
                        $data['form_status'] = true;
                        $data['form_alert'] = 'alert-danger';
                        $data['form_msg'] = 'Falha ao cadastrar categoria, contate o administrador!';
                    }
                }
            }
        }
        
        $this->load->view('header', $data);
        $this->load->view('upsert_category', $data);
        $this->load->view('footer');
    }
}
