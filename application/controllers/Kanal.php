<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kanal extends CI_Controller
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
            $url = base_url('kanal/update');
            $edit = $this->db->get_where('kanal', ['id' => (int)$this->input->get('id')])->row();
        } else {
            $url = base_url('kanal/store');
            $edit = '';
        }
        $this->data = [
            'title_web' => 'kanal',
            'url'       => $url,
            'edit'      => $edit,
            'kat'       => $this->db->get('kanal')->result()
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/kanal/index', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function store()
    {
        $this->form_validation->set_rules("kanal", "kanal", "required");
        if ($this->form_validation->run() != false) {
            $data = [
                'kanal' => htmlspecialchars($this->input->post("kanal", true), ENT_QUOTES),
            ];
            $this->db->insert("kanal", $data);
            $this->session->set_flashdata("success", " Berhasil Insert Data ! ");
            redirect(base_url("kanal"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Insert Data ! " . validation_errors());
            redirect(base_url("kanal"));
        }
    }

    public function update()
    {
        $id =  (int)$this->input->post("id"); // parameter yang mau di update
        $this->form_validation->set_rules("id", "Id", "required");
        $this->form_validation->set_rules("kanal", "kanal", "required");
        if ($this->form_validation->run() != false) {
            $data = [
                'kanal' => htmlspecialchars($this->input->post("kanal", true), ENT_QUOTES),
            ];

            $this->db->where("id", $id); // ubah id dan postnya
            $this->db->update("kanal", $data);
            $this->session->set_flashdata("success", " Berhasil Update Data ! ");
            redirect(base_url("kanal?id=" . $id));
        } else {
            $this->session->set_flashdata("failed", " Gagal Update Data ! " . validation_errors());
            redirect(base_url("kanal?id=" . $id));
        }
    }

    public function delete()
    {
        $id = (int)$this->input->get("id");
        $cek = $this->db->get_where("kanal", ["id" => $id]); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $this->db->where("id", $id); // tulis id yang dituju
            $this->db->delete("kanal");
            $this->session->set_flashdata("success", " Berhasil Delete Data ! ");
            redirect(base_url("kanal"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Delete Data ! " . validation_errors());
            redirect(base_url("kanal"));
        }
    }
}