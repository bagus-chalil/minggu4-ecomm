<?php 
defined('BASEPATH') OR exit('No direct access allowed');

class M_Produk extends CI_Model 
{
    public function getDataProduk()
    {
        return $this->db->get('tbl_produk');
    }
    public function getDataKategori()
    {
        return $this->db->get('toko_categories');
    }   
    public function tambah_kategori($nama)
    {
        $data = array('category' => $nama);
        return $this->db->insert('toko_categories', $data);
    }
    public function delete_kategori($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('toko_categories');
    }
}