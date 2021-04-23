<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{

	public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Produk');
    }

	public function index()
	{
	$this->form_validation->set_rules('nama_produk', 'nama_produk', 'required|trim');
	$this->form_validation->set_rules('harga_produk', 'harga_produk', 'required|trim');

		if($this->form_validation->run() == false) {
		$data['kategori'] = $this->M_Produk->getDataKategori()->result();
		$data['title'] = "Halaman Tambah Produk";
		$this->load->view('Templates/header',$data);
		$this->load->view('Templates/sidebar');
		$this->load->view('Templates/topbar');
		$this->load->view('Templates/breadcumb');
		$this->load->view('Templates/footer');
		$this->load->view('Produk/tambah');
	} else {
	  $config['upload_path']   = FCPATH. './assets/gambar/';
	  $config['allowed_types'] = 'jpg|png|gif';
	  $config['max_size']      = '5090';
	//   $config['max_width']     = '1024';
	//   $config['max_height']    = '768';
	  $config['file_name']     = url_title($this->input->post('gambar'));
	  // $filename = $this->upload->file_name;
	  $this->upload->initialize($config); 
  
	  $this->upload->do_upload('gambar');
	  $data = $this->upload->data();
  
	  $data = array(
		
							'nama' =>$this->input->post('nama_produk'),
							'produk_code' =>$this->input->post('produk_code'),
							'catid' => $this->input->post('catid') ,
							'deskripsi' => $this->input->post('deskripsi') ,
							'harga' => $this->input->post('harga_produk') ,
							'diskon' => $this->input->post('harga_diskon') ,
							'jumlah' => $this->input->post('jumlah') ,
							'gambar' => $data['file_name'] 
	  );
	  $this->db->insert('tbl_produk', $data);
	  redirect('produk/view_tabel');
	}
	}
	public function view_tabel()
	{
		$data['list'] = $this->M_Produk->getDataProduk()->result();
		$data['title'] = "Halaman Tabel Produk";
		$this->load->view('Templates/header',$data);
		$this->load->view('Templates/sidebar');
		$this->load->view('Templates/topbar');
		$this->load->view('Templates/breadcumb');
		$this->load->view('Templates/footer');
		$this->load->view('Produk/view_tabel',$data);
	}
	public function category()
    {
		$data['kategori'] = $this->M_Produk->getDataKategori()->result();
        $data['title'] = "Halaman Kategori Produk";
		$this->load->view('Templates/header',$data);
		$this->load->view('Templates/sidebar');
		$this->load->view('Templates/topbar');
		$this->load->view('Templates/breadcumb');
		$this->load->view('Templates/footer');
		$this->load->view('Produk/kategori',$data);
    }
	public function tambah_kategori()
    {
        $nama =$this->input->post('nama');
        $input = $this->M_Produk->tambah_kategori($nama);
        redirect(base_url('produk/category'));
    }
    public function hapus_pelabuhan($id)
    {
        $delete = $this->M_Produk->delete_kategori($id);
        redirect(base_url('produk/category'));
    }
}

