<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cabang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_Admin');
        $this->load->helper('tgl_default');
        $this->load->helper('alert');
        if ($this->session->userdata('masuk_sistem') != true) {
            $url = base_url('login');
            redirect($url);
        }
    }

    public function index()
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $url = base_url('cabang/update');
            $edit = $this->db->get_where('cabang', ['id' => (int)$this->input->get('id')])->row();
        } else {
            $url = base_url('cabang/store');
            $edit = '';
        }
        $this->data = [
            'title_web' => 'cabang',
            'url'       => $url,
            'edit'      => $edit,
            'kat'       => $this->db->get('cabang')->result()
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/cabang/index', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function store()
    {
        $this->form_validation->set_rules("cabang", "cabang", "required");
        if ($this->form_validation->run() != false) {
            $data = [
                'cabang' => htmlspecialchars($this->input->post("cabang", true), ENT_QUOTES),
            ];
            $this->db->insert("cabang", $data);
            $this->session->set_flashdata("success", " Berhasil Insert Data ! ");
            redirect(base_url("cabang"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Insert Data ! " . validation_errors());
            redirect(base_url("cabang"));
        }
    }

    public function update()
    {
        $id =  (int)$this->input->post("id"); // parameter yang mau di update
        $this->form_validation->set_rules("id", "Id", "required");
        $this->form_validation->set_rules("cabang", "cabang", "required");
        if ($this->form_validation->run() != false) {
            $data = [
                'cabang' => htmlspecialchars($this->input->post("cabang", true), ENT_QUOTES),
            ];

            $this->db->where("id", $id); // ubah id dan postnya
            $this->db->update("cabang", $data);
            $this->session->set_flashdata("success", " Berhasil Update Data ! ");
            redirect(base_url("cabang?id=" . $id));
        } else {
            $this->session->set_flashdata("failed", " Gagal Update Data ! " . validation_errors());
            redirect(base_url("cabang?id=" . $id));
        }
    }

    public function delete()
    {
        $id = (int)$this->input->get("id");
        $cek = $this->db->get_where("cabang", ["id" => $id]); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $this->db->where("id", $id); // tulis id yang dituju
            $this->db->delete("cabang");
            $this->session->set_flashdata("success", " Berhasil Delete Data ! ");
            redirect(base_url("cabang"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Delete Data ! " . validation_errors());
            redirect(base_url("cabang"));
        }
    }
}