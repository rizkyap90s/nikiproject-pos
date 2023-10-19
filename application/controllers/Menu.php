<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        $this->data['CI'] =& get_instance();
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_Admin');
        $this->load->model('M_Datatables');
        $this->load->helper('tgl_default');
        $this->load->helper('alert');
        if ($this->session->userdata('masuk_sistem') != true) {
            $url=base_url('login');
            redirect($url);
        }
    }
     
    public function index()
    {
        if ($this->session->userdata('ses_level') != 'Admin') {
            redirect('menu/persediaan');
            exit;
        }
        $this->data = [
            'title_web'  => 'Daftar Menu',
        ];
        
        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/index', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function import()
    {
        $this->data = [
            'title_web'  => 'Daftar Menu',
        ];
        
        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/import', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function update_by_excel()
    {
        $this->data = [
            'title_web'  => 'Update',
        ];
        
        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/update_by_excel', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function proses_import()
    {
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if (isset($_FILES['berkas_excel']['name']) && in_array($_FILES['berkas_excel']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['berkas_excel']['name']);
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['berkas_excel']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            for ($i = 1;$i < count($sheetData);$i++) {
                if ($sheetData[$i]['2'] == null) {
                    $kategori = 1;
                } else {
                    $kategori = $sheetData[$i]['2'];
                }
                $cekid  =  cek_id('menu', 'kode_menu', $sheetData[$i]['1']);
                $data = [
                    'kode_menu' => $sheetData[$i]['1'],
                    'id_kategori' => $kategori,
                    'nama' => $sheetData[$i]['3'],
                    'harga_pokok' => $sheetData[$i]['4'],
                    'harga_jual' => $sheetData[$i]['5'],
                    'stok' => $sheetData[$i]['6'],
                    'stok_minim' => $sheetData[$i]['7'],
                    'gambar' => '-',
                    'created_at' => date('Y-m-d H:i:s'),
                    'id_cabang' => $sheetData[$i]['8'],
                    'id_kanal' => $sheetData[$i]['9'],
                 ];
                $this->db->insert("menu", $data);
            }

            $this->session->set_flashdata("success", " Berhasil Insert Data ! ");
            redirect(base_url("menu"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Insert Data !  Berkas harus berextensi excel");
            redirect(base_url("menu"));
        }
    }
    public function proses_import_update()
{
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    if (isset($_FILES['berkas_excel']['name']) && in_array($_FILES['berkas_excel']['type'], $file_mimes)) {
        $arr_file = explode('.', $_FILES['berkas_excel']['name']);
        $extension = end($arr_file);
        
        if ('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        
        $spreadsheet = $reader->load($_FILES['berkas_excel']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        
        for ($i = 1; $i < count($sheetData); $i++) {
            $id = $sheetData[$i]['0']; // Assuming 'id' is in the first column
            
            // Check if the 'id' already exists in the database
            $existingRecord = $this->db->get_where("menu", array('id' => $id))->row_array();
            
            if (!empty($existingRecord)) {
                // Update existing record
                $data = [
                    'id_kategori' => $sheetData[$i]['1'],
                    'nama' => $sheetData[$i]['2'],
                    'harga_pokok' => $sheetData[$i]['3'],
                    'harga_jual' => $sheetData[$i]['4'],
                    'stok' => $sheetData[$i]['5'],
                    'stok_minim' => $sheetData[$i]['6'],
                    'keterangan' => $sheetData[$i]['7'],
                    'id_cabang' => $sheetData[$i]['8'],
                    'id_kanal' => $sheetData[$i]['9'],
                ];
                
                $this->db->where('id', $id);
                $this->db->update("menu", $data);
            } else {
                // Insert new record
                $data = [
                    'id_kategori' => $sheetData[$i]['1'],
                    'nama' => $sheetData[$i]['2'],
                    'harga_pokok' => $sheetData[$i]['3'],
                    'harga_jual' => $sheetData[$i]['4'],
                    'stok' => $sheetData[$i]['5'],
                    'stok_minim' => $sheetData[$i]['6'],
                    'keterangan' => $sheetData[$i]['7'],
                    'id_cabang' => $sheetData[$i]['8'],
                    'id_kanal' => $sheetData[$i]['9'],
                ];
                
                $this->db->insert("menu", $data);
            }
        }

        $this->session->set_flashdata("success", "Data berhasil diimpor.");
        redirect(base_url("menu"));
    } else {
        $this->session->set_flashdata("failed", "Gagal mengimpor data. Berkas harus berextensi excel.");
        redirect(base_url("menu"));
    }
}

public function dtmenu()
{
    $pageNumber = htmlspecialchars($this->input->post('pageHome', true), ENT_QUOTES);
    $halperpage = 12;
    $page = isset($pageNumber) ? (int)$pageNumber : 1;
    $mulai = ($page > 1) ? ($page * $halperpage) - $halperpage : 0;
    $kanal = $this->input->get('kanal', true);
    $getCabang = $this->session->userdata('ses_cabang');
    $getCari = $this->input->get('cari');
    $kategoriFilter = $this->input->get('id_kategori'); // Get the kategori filter parameter

    $condition = [];
    $where = [];

    if (!empty($getCabang)) {
        $condition[] = "menu.id_cabang = $getCabang";
    }

    if (!empty($getCari)) {
        $searchTerm = $this->db->escape_like_str($this->input->get('cari', true));
        $condition[] = "(kode_menu LIKE '%$searchTerm%' OR nama LIKE '%$searchTerm%' OR kategori.kategori LIKE '%$searchTerm%')";
    }

    if (!empty($kanal)) {
        $condition[] = "kanal.id = $kanal";
    }

    if (!empty($kategoriFilter)) {
        $condition[] = "kategori.id = $kategoriFilter"; // Add the kategori filter condition
    }

    if (!empty($condition)) {
        $where[] = "WHERE " . implode(" AND ", $condition);
    }

    $query = "SELECT kategori.kategori, menu.*, kanal.kanal, cabang.cabang, kanal.kanal 
        FROM menu 
        JOIN kategori ON menu.id_kategori = kategori.id 
        JOIN kanal ON menu.id_kanal = kanal.id 
        JOIN cabang ON cabang.id = menu.id_cabang";

    if (!empty($where)) {
        $query .= " " . implode(" ", $where);
    }

    $query .= " ORDER BY nama ASC LIMIT $mulai, $halperpage";

    $hasil = $this->db->query($query)->result();

    $this->data['hasil'] = $hasil;
    $this->load->view('admin/kasir/menu', $this->data);
}

    public function data_menu()
    {
        if ($this->input->method(true)=='POST'):
            $query      = "SELECT kategori.kategori, menu.*, kanal.kanal, cabang.cabang FROM menu JOIN kategori ON menu.id_kategori = kategori.id JOIN kanal ON menu.id_kanal = kanal.id JOIN cabang ON cabang.id = menu.id_cabang";
            $search     = array('kode_menu','kategori.kategori','nama','harga_pokok','harga_jual','keterangan','gambar','kanal','cabang');
            if ((int)$this->input->get('id')) {
                $where  = array('id_kategori' => (int)$this->input->get('id'));
            } else {
                $where  = null;
            }
        if ($this->input->get('cek')) {
            $iswhere    = " stok <= stok_minim ";
        } else {
            $iswhere    = null;
        }

        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $iswhere);
        endif;
    }

    public function stok()
    {
        if ($this->input->get('id')) {
            $this->data = [
                'title_web'  => 'Entry Persediaan Menu',
                'tipe'       => 'edit',
                'edit'       => $this->db->query("SELECT * FROM menu WHERE menu.id = ?", array($this->input->get('id')) )->row(),
            ];
        } else {
            $this->data = [
                'title_web'  => 'Entry Persediaan Menu',
                'tipe'       => ''
            ];
        }
        
        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/stok', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function persediaan()
    {
        $this->data = [
            'title_web'  => 'Daftar Persediaan Menu',
        ];
        
        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/persediaan', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function get_menu()
    {
        $id =  (int)$this->input->post("id"); // parameter yang mau di update
        $cek = $this->db->query("SELECT * FROM menu WHERE menu.id=?", array($id)); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $data = $cek->row();
            $result[] = array(
                'id'            => $data->id,
                'nama'          => $data->nama,
                'stok'          => $data->stok,
                'stok_minim'    => $data->stok_minim,
                'kode_menu'    => $data->kode_menu,
            );
            echo json_encode($result);
        } else {
            echo '';
        }
    }

    public function pasok()
    {
        $id =  (int)$this->input->post("id");
        $kode_menu = $this->input->post("kode_menu"); 
            
        $this->form_validation->set_rules("id", "Id", "required");
        $this->form_validation->set_rules("stok", "Stok", "required");

        if ($this->form_validation->run() != false) {
            $data_r = [
                'menu_id'    => $id,
                'stok_awal'  => (int)$this->input->post("stok"),
                'stok_akhir' => (int)$this->input->post("stoka"),
                'date'       => date('Y-m-d'),
                'periode'    => date('Y-m'),
                'kode_menu'    => $kode_menu,
            ];
            
            $this->db->insert("menu_stok", $data_r);

            $data = [
                'stok'       => (int)$this->input->post("stok"),
                'stok_minim' => (int)$this->input->post("stok_minim"),
            ];
            
            $this->db->where("kode_menu", $kode_menu); // ubah id dan postnya
            $this->db->update("menu", $data);

            $this->session->set_flashdata("success", " Berhasil Update Data Stok  ".$this->input->post('kode_menu')." !");
            redirect(base_url("menu/stok"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Update Data Stok ! ".validation_errors());
            redirect(base_url("menu/stok"));
        }
    }

    public function transfer_stok()
    {
        if ($this->input->get('id')) {
            $this->data = [
                'title_web'  => 'Transfer Stok',
                'tipe'       => 'edit',
                'edit'       => $this->db->query("SELECT menu.*, cabang.cabang FROM menu JOIN cabang ON cabang.id = menu.id_cabang WHERE menu.id = ?", array($this->input->get('id')) )->row(),
            ];
        } else {
            $this->data = [
                'title_web'  => 'Transfer Stok',
                'tipe'       => ''
            ];
        }
        
        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/transfer_stok', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function transferStock()
    {
        $from_menu_id = (int)$this->input->post("from_menu_id");
        $to_menu_id = (int)$this->input->post("to_menu_id");
        $quantity = (int)$this->input->post("quantity");
    
        $this->form_validation->set_rules("from_menu_id", "From Menu ID", "required");
        $this->form_validation->set_rules("to_menu_id", "To Menu ID", "required");
        $this->form_validation->set_rules("quantity", "Quantity", "required|greater_than[0]");
    
        if ($this->form_validation->run() != false) {
            $from_menu = $this->db->get_where("menu", ["id" => $from_menu_id])->row();
            $to_menu = $this->db->get_where("menu", ["id" => $to_menu_id])->row();
    
            if (!$from_menu || !$to_menu) {
                $this->session->set_flashdata("failed", "Invalid Menu ID");
                redirect(base_url("menu/t"));
            }
    
            if ($from_menu->stok < $quantity) {
                $this->session->set_flashdata("failed", "Insufficient stock for transfer");
                redirect(base_url("menu/transfer_stok"));
            }
    
            $this->db->trans_start();
    
            $data_r = [
                'menu_id'    => $from_menu_id,
                'stok_awal'  => $from_menu->stok,
                'stok_akhir' => $from_menu->stok - $quantity,
                'date'       => date('Y-m-d'),
                'periode'    => date('Y-m')
            ];
            $this->db->insert("menu_stok", $data_r);
    
            $data_from = [
                'stok' => $from_menu->stok - $quantity,
            ];
            $this->db->where("id", $from_menu_id);
            $this->db->update("menu", $data_from);
    
            $data_to = [
                'stok' => $to_menu->stok + $quantity,
            ];
            $this->db->where("id", $to_menu_id);
            $this->db->update("menu", $data_to);
    
            $this->db->trans_complete();
    
            if ($this->db->trans_status() === false) {
                $this->session->set_flashdata("failed", "Failed to transfer stock");
            } else {
                $this->session->set_flashdata("success", "Successfully transferred stock!");
            }
    
            redirect(base_url("menu/transfer_stok"));
        } else {
            $this->session->set_flashdata("failed", "Failed to transfer stock. " . validation_errors());
            redirect(base_url("menu/transfer_stok"));
        }
    }

    

    public function tambah()
    {
        $kode = $this->db->query("SELECT * FROM menu ORDER BY id DESC LIMIT 1");
        
        if ($kode->num_rows() > 0) {
            $ps = $kode->row();
            $kode_cus = $ps->id + 1;
        } else {
            $kode_cus = 1;
        }
        
        $this->data = [
            'title_web' => 'Tambah Menu',
            'kode'  	=> 'P000'.$kode_cus,
            'kat'       => $this->db->get('kategori')->result(),
            'kanal'    => $this->db->get('kanal')->result(),
            'cabang'    => $this->db->get('cabang')->result()
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/tambah', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function store()
    {
        $this->form_validation->set_rules("id_kategori", "Id kategori", "required");
        $this->form_validation->set_rules("kode_menu", "Kode menu", "required");
        $this->form_validation->set_rules("nama", "Nama", "required");
        $this->form_validation->set_rules("harga_pokok", "Harga pokok", "required");
        $this->form_validation->set_rules("harga_jual", "Harga jual", "required");
        if ($this->form_validation->run() != false) {
            $data = [
                'id_kategori'   => htmlspecialchars($this->input->post("id_kategori", true), ENT_QUOTES),
                'id_kanal'     => htmlspecialchars($this->input->post("id_kanal", true), ENT_QUOTES),
                'id_cabang'     => htmlspecialchars($this->input->post("id_cabang", true), ENT_QUOTES),
                'kode_menu'     => htmlspecialchars($this->input->post("kode_menu", true), ENT_QUOTES),
                'nama'          => htmlspecialchars($this->input->post("nama", true), ENT_QUOTES),
                'harga_pokok'   => htmlspecialchars($this->input->post("harga_pokok", true), ENT_QUOTES),
                'harga_jual'    => htmlspecialchars($this->input->post("harga_jual", true), ENT_QUOTES),
                'keterangan'    => htmlspecialchars($this->input->post("keterangan", true), ENT_QUOTES),
                'stok'          => 0,
                'stok_minim'    => (int)$this->input->post("stok_minim"),
                'created_at'    => date('Y-m-d H:i:s'),
            ];

            $upload_foto = $_FILES['gambar']['name'];
            if ($upload_foto) {
                // setting konfigurasi upload
                $nmfile                  = "produk_".time();
                $config['upload_path']   = './assets/image/produk/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name']     = $nmfile;
                // load library upload
                $this->load->library('upload', $config);
                // upload gambar
                if ($this->upload->do_upload('gambar')) {
                    $result1 = $this->upload->data();
                    $result  = array('gambar' => $result1);
                    $data1   = array('upload_data' => $this->upload->data());
                    $this->db->set('gambar', $data1['upload_data']['file_name']);
                } else {
                    $this->session->set_flashdata("failed", " Gagal Insert Data ! ".$this->upload->display_errors());
                    redirect(base_url("menu"));
                }
            } else {
                $this->db->set('gambar', '-');
            }

            $this->db->insert("menu", $data);
            $this->session->set_flashdata("success", " Berhasil Insert Data ! ");
            redirect(base_url("menu"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Insert Data ! ".validation_errors());
            redirect(base_url("menu"));
        }
    }

    public function detail()
    {
        $id = (int)$this->uri->segment('3');
        $cek = $this->db->get_where("menu", ["id" => $id]); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $edit = $cek->row();
        } else {
            $this->session->set_flashdata("failed", " Tidak ditemukan data ID dari Menu ! ");
            redirect(base_url('menu'));
        }
                
        $this->data = [
            'title_web' => 'Detail Menu',
            'edit'		=> $edit,
            'kat'       => $this->db->get('kategori')->result(),
            'cabang'    => $this->db->get('cabang')->result()

        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/detail', $this->data);
        $this->load->view('layout/footer', $this->data);
    }
    
    public function edit()
    {
        $id = (int)$this->uri->segment('3');
        $cek = $this->db->get_where("menu", ["id" => $id]); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $edit = $cek->row();
        } else {
            $this->session->set_flashdata("failed", " Tidak ditemukan data ID dari Menu ! ");
            redirect(base_url('menu'));
        }
                
        $this->data = [
            'title_web' => 'Edit Menu',
            'edit'		=> $edit,
            'kat'       => $this->db->get('kategori')->result(),
            'cabang'    => $this->db->get('cabang')->result()
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/edit', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function update()
    {
        $id =  (int)$this->input->post("id"); // parameter yang mau di update
            
        $this->form_validation->set_rules("id", "Id", "required");
        $this->form_validation->set_rules("id_kategori", "Id kategori", "required");
        $this->form_validation->set_rules("kode_menu", "Kode menu", "required");
        $this->form_validation->set_rules("nama", "Nama", "required");
        $this->form_validation->set_rules("harga_pokok", "Harga pokok", "required");
        $this->form_validation->set_rules("harga_jual", "Harga jual", "required");
        $this->form_validation->set_rules("id_cabang", "Id cabang", "required");


        if ($this->form_validation->run() != false) {
            $data = [
                'id_kategori'   => htmlspecialchars($this->input->post("id_kategori", true), ENT_QUOTES),
                'kode_menu'     => htmlspecialchars($this->input->post("kode_menu", true), ENT_QUOTES),
                'nama'          => htmlspecialchars($this->input->post("nama", true), ENT_QUOTES),
                'harga_pokok'   => htmlspecialchars($this->input->post("harga_pokok", true), ENT_QUOTES),
                'harga_jual'    => htmlspecialchars($this->input->post("harga_jual", true), ENT_QUOTES),
                'id_cabang'     => htmlspecialchars($this->input->post("id_cabang", true), ENT_QUOTES),
                'keterangan'    => htmlspecialchars($this->input->post("keterangan", true), ENT_QUOTES),
                'stok_minim'    => (int)$this->input->post("stok_minim"),
            ];
            
            $upload_foto = $_FILES['gambar']['name'];
            if ($upload_foto) {
                // setting konfigurasi upload
                $nmfile                     = "produk_".time();
                $config['upload_path']      = './assets/image/produk/';
                $config['allowed_types']    = 'gif|jpg|jpeg|png';
                $config['file_name']        = $nmfile;
                // load library upload
                $this->load->library('upload', $config);
                // upload gambar
                if ($this->upload->do_upload('gambar')) {
                    $result1    = $this->upload->data();
                    $result     = array('gambar' => $result1);
                    $data1      = array('upload_data' => $this->upload->data());
                    $this->db->set('gambar', $data1['upload_data']['file_name']);

                    // if ($this->input->get('gambar_edit') !== '-') {
                    //     if (file_exists(FCPATH.'assets/image/produk/'.$this->input->get('gambar_edit'))) {
                    //         unlink(FCPATH.'assets/image/produk/'.$this->input->get('gambar_edit'));
                    //     }
                    // }
                } else {
                    $this->session->set_flashdata("failed", " Gagal Insert Data ! ".$this->upload->display_errors());
                    redirect(base_url("menu/edit/".$id));
                }
            }

            $this->db->where("id", $id); // ubah id dan postnya
            $this->db->update("menu", $data);
            $this->session->set_flashdata("success", " Berhasil Update Data ! ");
            redirect(base_url("menu/edit/".$id));
        } else {
            $this->session->set_flashdata("failed", " Gagal Update Data ! ".validation_errors());
            redirect(base_url("menu/edit/".$id));
        }
    }

    public function delete()
    {
        $id = (int)$this->input->get("id");
        $cek = $this->db->get_where("menu", ["id" => $id]); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $hasil = $cek->row();

            // if ($hasil->gambar !== '-') {
            //     if (file_exists(FCPATH.'assets/image/produk/'.$hasil->gambar)) {
            //         unlink(FCPATH.'assets/image/produk/'.$hasil->gambar);
            //     }
            // }

            $this->db->where("id", $id); // tulis id yang dituju
            $this->db->delete("menu");
            
            $this->session->set_flashdata("success", " Berhasil Delete Data ! ");
            redirect(base_url("menu"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Delete Data ! ".validation_errors());
            redirect(base_url("menu"));
        }
    }

    public function deleteAllMenu()
    {
    
        $this->db->empty_table("menu");
            
        $this->session->set_flashdata("success", " Berhasil Delete Data ! ");
        redirect(base_url("menu"));
    }

    // In your model file (e.g., Menu_model.php)
 // In your model file (e.g., Menu_model.php)
    public function getMenus() {
        $query = "SELECT id, id_kategori, nama, harga_pokok, harga_jual, stok, stok_minim, keterangan, id_cabang, id_kanal FROM menu";

        return $this->db->query($query)->result_array();
    }


  // In your controller (e.g., DownloadController.php)
  public function downloadMenuData() {
    // Create a PhpSpreadsheet object
    $spreadsheet = new Spreadsheet();

    // Your database query to retrieve menu data
    $query = "SELECT id, id_kategori, nama, harga_pokok, harga_jual, stok, stok_minim, keterangan, id_cabang, id_kanal FROM menu";
    $result = $this->db->query($query)->result_array();

    // Create a worksheet and set headers
    $worksheet = $spreadsheet->getActiveSheet();
    $worksheet->fromArray(['ID menu', 'ID Kategori', 'Nama Menu', 'Harga Pokok', 'Harga Jual', 'Stok', 'Stok Minim', 'Keterangan', 'ID Cabang', 'ID Kanal'], NULL, 'A1');

    // Add data rows to the XLSX
    $row = 2;
    foreach ($result as $menu) {
        $col = 'A';
        foreach ($menu as $value) {
            $worksheet->setCellValue($col . $row, $value);
            $col++;
        }
        $row++;
    }

    // Set the filename and content type for XLSX download
    $filename = 'menu_data.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Output the XLSX file
    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
}





}