<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Category_model', 'categories');
        $this->load->model('Product_model', 'products');
        //$this->output->cache(1);
        //$this->output->enable_profiler(TRUE);
    }

	public function index(){

        $data = [
            'title' => 'Categorias | CodeIgniter 3.1.11',
            'h1' => 'Categorias',
            'categories' => $this->categories->get(),
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
        
        $this->load->view('templates/header', $data);
        $this->load->view('categories/list_category', $data);
        $this->load->view('templates/footer');
    }

    public function delete()
    {
        $id = $this->uri->segment(3);

        $data = [];
        
        if(!!$this->products->get(['p.id_category' => $id]))
        {
            $data['msg_type'] = 'alert-danger';
            $data['msg_label'] = "Categoria tem produtos vinculados e não é permitida sua remoção.";
        }
        else
        {
            $rtn = $this->categories->delete(['id_category' => $id]);
    
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

            $upt = $this->categories->get(['id_category' => $id]);

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
        $this->form_validation->set_rules('url', 'URL', "callback_unique_url[$id]");
        $this->form_validation->set_rules('name', 'Nome Categoria', 'trim|required');

        $is_valid = $this->form_validation->run();

        if($is_valid)
        {
            $dados_form = $this->input->post();

            if(!!trim($dados_form['url'])):
                $dados_form['url'] = url_slug($dados_form['url']);
            else:
                $dados_form['url'] = url_slug($dados_form['name']);
            endif;
            
            if($id)
            {
                if($this->categories->update($id, $dados_form))
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
        
        $this->load->view('templates/header', $data);
        $this->load->view('categories/upsert_category', $data);
        $this->load->view('templates/footer');
    }

    function unique_url($url, $id)
    {    
        if($id): 
            $url_where = ['url' => $url, 'id_category !=' => $id];
        else:
            $url_where = ['url' => $url];
        endif;

        if(!!$this->categories->get($url_where))
        {
            $this->form_validation->set_message('unique_url', "{field} '{$url}' já encontra-se registrada. Informe outra {field}.");
            return FALSE;
        }

        return TRUE;
    }
}
