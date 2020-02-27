<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Category_model', 'categories');
        $this->load->model('Product_model', 'products');
    }

	public function index(){

        $data = [
            'title' => 'Produtos | CodeIgniter 3.1.11',
            'h1' => 'Produtos',
            'products' => $this->products->get(),
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
        $this->load->view('products/list_product', $data);
        $this->load->view('templates/footer');
    }

    public function delete()
    {
        $id = $this->uri->segment(3);
        $rtn = $this->products->delete(['id_products' => $id]);

        $data = [];

        if($rtn){
            $data['msg_type'] = 'alert-success';
            $data['msg_label'] = "Produto ID: {$id} excluído com sucesso!";
        }
        else{
            $data['msg_type'] = 'alert-danger';
            $data['msg_label'] = "Problemas ao excluir o produto com ID: {$id}!";
        }

        $_SESSION["redirect_data"] = $data;
        
        redirect('/product', 'refresh');
    }

    public function upsert()
    {
        $data = [
            'form_status' => false,
            'form_alert' => '',
            'form_msg' => '',
            'categories' => $this->categories->get(),
            'upt' => (object)['id_product' => '', 'id_category' => '', 'name' => '', 'url' => '', 'price' => '', 'description' => ''],
        ];
        
        // Update
        $id = $this->uri->segment(3);
        if($id)
        {
            $data['title'] = 'Atualizar Produto | CodeIgniter 3.1.11';
            $data['h1'] = 'Atualizar Produto';
            $data['btn'] = 'Atualizar';

            $upt = $this->products->get(['p.id_product' => $id]);

            if(!$upt)
            {
                $data['msg_type'] = 'alert-danger';
                $data['msg_label'] = "Não existe o produto com ID: {$id}!";

                $_SESSION["redirect_data"] = $data;
            
                redirect('/product', 'refresh');
            }
            else
            {
                $data['upt'] = $upt[0];
            }
        }
        // Insert
        else
        {
            $data['title'] = 'Cadastrar Produto | CodeIgniter 3.1.11';
            $data['h1'] = 'Cadastrar Produto';
            $data['btn'] = 'Cadastrar';
        }
        
        $this->load->helper(['form','funcoes_helper']);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('url', 'URL', "callback_unique_url[$id]");
        $this->form_validation->set_rules('id_category', 'ID Categoria', 'trim|required');
        $this->form_validation->set_rules('name', 'Nome Produto', 'trim|required');
        $this->form_validation->set_rules('price', 'Preço', 'trim|required');

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
                if($this->products->update($id, $dados_form))
                {
                    $data['msg_type'] = 'alert-success';
                    $data['msg_label'] = "Produto ID: {$id} atualizado com sucesso!";
    
                    $_SESSION["redirect_data"] = $data;
                
                    redirect('/product', 'refresh');
                }
                else
                {
                    $data['form_status'] = true;
                    $data['form_alert'] = 'alert-danger';
                    $data['form_msg'] = 'Falha ao cadastrar produto, contate o administrador!';
                }
            }
            else
            {
                if($this->products->insert($dados_form))
                {
                    $data['form_status'] = true;
                    $data['form_alert'] = 'alert-success';
                    $data['form_msg'] = 'Produto cadastrado com sucesso!';
                }
                else
                {
                    $data['form_status'] = true;
                    $data['form_alert'] = 'alert-danger';
                    $data['form_msg'] = 'Falha ao cadastrar produto, contate o administrador!';
                }
            }
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('products/upsert_product', $data);
        $this->load->view('templates/footer');
    }

    function unique_url($url, $id)
    {    
        if($id): 
            $url_where = ['p.url' => $url, 'p.id_product !=' => $id];
        else:
            $url_where = ['p.url' => $url];
        endif;

        if(!!$this->products->get($url_where))
        {
            $this->form_validation->set_message('unique_url', "{field} '{$url}' já encontra-se registrada. Informe outra {field}.");
            return FALSE;
        }

        return TRUE;
    }
}
