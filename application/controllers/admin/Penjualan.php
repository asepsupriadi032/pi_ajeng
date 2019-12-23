<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Super.php');

class Penjualan extends Super
{
    
    function __construct()
    {
        parent::__construct();
        $this->language       = 'Indonesian'; /** Indonesian / english **/
        $this->tema           = "flexigrid"; /** datatables / flexigrid **/
        $this->tabel          = "penjualan";
        $this->active_id_menu = "penjualan";
        $this->nama_view      = "Penjualan";
        $this->status         = true; 
        $this->field_tambah   = array(); 
        $this->field_edit     = array(); 
        $this->field_tampil   = array('id_penerima','kode_penjualan','total_harga','waktu'); 
        $this->folder_upload  = 'assets/uploads/files';
        $this->add            = true;
        $this->edit           = false;
        $this->delete         = false;
        $this->crud;
    }

    function index(){
            $data = [];
            /** Bagian GROCERY CRUD USER**/
            if($this->crud->getState()=="add")
                redirect(base_url('admin/Penjualan/addPenjualan'));

            /** Relasi Antar Tabel 
            * @parameter (nama_field_ditabel_ini, tabel_relasi, field_dari_tabel_relasinya)
            **/
            $this->crud->set_relation('id_penerima','toko','nama_toko');

            /** Upload **/
            // $this->crud->set_field_upload('nama_field_upload',$this->folder_upload);  
            
            /** Ubah Nama yang akan ditampilkan**/
            // $this->crud->display_as('nama','Nama Setelah di Edit')
            //     ->display_as('email','Email Setelah di Edit'); 
            
            /** Akhir Bagian GROCERY CRUD Edit Oleh User**/
            $this->crud->where('penjualan.id_toko','0');
            $data = array_merge($data,$this->generateBreadcumbs());
            $data = array_merge($data,$this->generateData());
            $this->generate();
            $data['output'] = $this->crud->render();
            $this->load->view('admin/'.$this->session->userdata('theme').'/v_index',$data);
    }

    private function generateBreadcumbs(){
        $data['breadcumbs'] = array(
                array(
                    'nama'=>'Dashboard',
                    'icon'=>'fa fa-dashboard',
                    'url'=>'admin/dashboard'
                ),
                array(
                    'nama'=>'Admin',
                    'icon'=>'fa fa-users',
                    'url'=>'admin/useradmin'
                ),
            );
        return $data;
    }

    public function addPenjualan(){
        $data = [];
        $data = array_merge($data,$this->generateBreadcumbs());
        $data = array_merge($data,$this->generateData());
        $this->generate();

        $data['toko'] = $this->db->get('toko');
        $data['brg'] = $this->db->get('barang');

        $data['page'] = "add-penjualan";
        $data['output'] = $this->crud->render();
        $this->load->view('admin/'.$this->session->userdata('theme').'/v_index',$data);
    }

    public function addToko(){
        $id_toko = $this->input->post('id_toko');
        $row = $this->db->get_where('toko', array('id_toko'=>$id_toko))->row();
        $nama_toko = $row->nama_toko;

        $this->session->set_userdata('id_toko',$id_toko);
        $this->session->set_userdata('nama_toko',$nama_toko);
        redirect(base_url('admin/Penjualan/addPenjualan'));
    }

    public function cartToko(){
        $nama_toko = $this->input->post('nama_toko');
        $id_barang = $this->input->post('id_barang');
        $qty = $this->input->post('qty');

        $row=$this->db->get_where("barang",array('id_barang'=>$id_barang))->row();
        $harga=$row->harga;
        $data=array(
            'id'=>$row->id_barang,
            'qty'=>$qty,
            'price'=>$harga,
            'name'=>$row->nama_barang,
            'options'=>array('nama'=>$nama_toko)
        );
        $this->cart->insert($data);
        redirect(base_url('admin/Penjualan/addPenjualan'));
    }

    public function hapusSession(){
        $this->session->unset_userdata('nama_toko');
        $this->session->unset_userdata('id_toko');
        $this->cart->destroy();

        redirect(base_url('admin/Penjualan/addPenjualan'));
    }

    public function hapus_cart_penjualan(){
        $id=$this->input->post('id',true);
        $data=array(
                    'rowid'=>$id,
                    'qty'=>0
                );
        $this->cart->update($data);
        redirect(base_url('admin/Penjualan/addPenjualan'));
    }

    public function proses_penjualan(){
        if (!$this->input->post())
            redirect('admin/penjualan/addPenjualan');

        $code=time();
        // var_dump($_POST); die();
        // echo $code;die();
        $data=array('id_toko'=> '0',
                    'kode_penjualan'=>$code,
                    'id_penerima'=>$this->input->post('id_penerima'),
                    'total_harga'=>$this->cart->total()
                );

        $this->db->insert('penjualan',$data);
        $id_penjualan=$this->db->insert_id();

        foreach ($this->cart->contents() as $items){
            // print_r($items);die();

            $this->db->insert('penjualan_detail',array(
                'id_penjualan'=>$id_penjualan,
                'id_barang'=>$items['id'],
                'qty'=>$items['qty'],
                'harga'=>$items['price'],
                'sub_total'=>$items['subtotal']
            ));


            $barang=$this->db->get_where('barang_toko',array('id_toko'=>$this->input->post('id_penerima'), 'id_barang'=>$items['id']));

            $jumlahBarangToko = $barang->num_rows();

            if($jumlahBarangToko < 1){
                $this->db->set('id_barang',$items['id']);
                $this->db->set('id_toko',$this->input->post('id_penerima'));
                $this->db->set('stok',$items['qty']);
                $this->db->set('harga',$items['price']);
                $this->db->insert('barang_toko');
            }else{
                foreach ($barang->result() as $key ) {
                    if ($key->id_barang == $items['id']) {
                        $stok_baru= $key->stok + $items['qty'];

                        $this->db->where('id_toko',$this->input->post('id_penerima'));
                        $this->db->where('id_barang',$key->id_barang);
                        $this->db->set('stok',$stok_baru);
                        $this->db->set('harga',$items['price']);
                        $this->db->update('barang_toko');
                    }
                }
            }

            $barangToko = $this->db->get_where('barang', array('id_barang'=>$items['id']))->row();

            $sisaStok = $barangToko->stok - $items['qty'];

            $this->db->set('stok',$sisaStok);
            $this->db->where('id_barang',$items['id']);
            $this->db->update('barang');

                
        }
        $this->session->unset_userdata('nama_toko');
        $this->session->unset_userdata('id_toko');
        $this->cart->destroy();
        redirect(base_url('admin/Penjualan'));
    }
}