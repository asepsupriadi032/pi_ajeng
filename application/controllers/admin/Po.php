<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Super.php');

class Po extends Super
{
    
    function __construct()
    {
        parent::__construct();
        $this->language       = 'Indonesian'; /** Indonesian / english **/
        $this->tema           = "flexigrid"; /** datatables / flexigrid **/
        $this->tabel          = "po";
        $this->active_id_menu = "Po";
        $this->nama_view      = "Pre Order";
        $this->status         = true; 
        $this->field_tambah   = array(); 
        $this->field_edit     = array(); 
        $this->field_tampil   = array(); 
        $this->folder_upload  = 'assets/uploads/files';
        $this->add            = false;
        $this->edit           = true;
        $this->delete         = false;
        $this->crud;
    }

    function index(){
            $data = [];
            /** Bagian GROCERY CRUD USER**/
            if($this->crud->getState()=="edit"){
                $id = $this->uri->segment(5);
                redirect(base_url('admin/Po/editPo/'.$id));
            }


            /** Relasi Antar Tabel 
            * @parameter (nama_field_ditabel_ini, tabel_relasi, field_dari_tabel_relasinya)
            **/
            $this->crud->set_relation('id_toko','toko','nama_toko');

            /** Upload **/
            // $this->crud->set_field_upload('nama_field_upload',$this->folder_upload);  
            
            /** Ubah Nama yang akan ditampilkan**/
            // $this->crud->display_as('nama','Nama Setelah di Edit')
            //     ->display_as('email','Email Setelah di Edit'); 
            
            /** Akhir Bagian GROCERY CRUD Edit Oleh User**/
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

    public function editPO($id = NULL){
        $data = [];
        $data = array_merge($data,$this->generateBreadcumbs());
        $data = array_merge($data,$this->generateData());
        $this->generate();

        $this->db->where('po.id_po',$id);
        $this->db->join('toko','toko.id_toko=po.id_toko');
        $data['toko'] = $this->db->get('po')->row();

        $this->db->where('id_po',$id);
        $this->db->join('barang','barang.id_barang=po_detail.id_barang');
        $data['detail'] = $this->db->get('po_detail')->result();

        $data['page'] = "edit-po";
        $data['output'] = $this->crud->render();
        $this->load->view('admin/'.$this->session->userdata('theme').'/v_index',$data);
    }

    public function updatePo(){

        $id_toko = $this->input->post('id_toko');
        $id_po = $this->input->post('id_po');
        $sts = $this->input->post('sts');

        $poDetail = $this->db->get_where('po_detail', array('id_po'=>$id_po))->result();

        foreach ($poDetail as $key) {
           $id_barang = $key->id_barang;
           $qty = $key->qty;
           //update stok di tabel barang
           $this->db->where('id_barang',$id_barang);
           $getStokBarang = $this->db->get('barang')->row();
           $stokBarangBaru = $getStokBarang->stok - $qty;
           $harga = $getStokBarang->harga;
           $nama_barang = $getStokBarang->nama_barang;

           $this->db->where('id_barang',$id_barang);
           $this->db->set('stok',$stokBarangBaru);
           $this->db->update('barang');

           //update stok barang di toko
           $this->db->where('id_toko',$id_toko);
           $this->db->where('id_barang',$id_barang);
           $barangToko = $this->db->get('barang_toko')->row();
           $stokBarangTokoBaru = $barangToko->stok + $qty;

           $this->db->where('id_toko',$id_toko);
           $this->db->where('id_barang',$id_barang);
           $this->db->set('stok',$stokBarangTokoBaru);
           $this->db->update('barang_toko');

           $data=array(
            'id'=>$id_barang,
            'qty'=>$qty,
            'price'=>$harga,
            'name'=>$nama_barang
            );
            $this->cart->insert($data);
        }

        $code=time();
        // var_dump($id_toko); die();
        // echo $code;die();
        $data=array('id_toko'=> '0',
                    'kode_penjualan'=>$code,
                    'id_penerima'=>$id_toko,
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


            // $barang=$this->db->get_where('barang_toko',array('id_toko'=>$id_toko, 'id_barang'=>$items['id']));

            // $jumlahBarangToko = $barang->num_rows();

            // // echo $jumlahBarangToko; die();
            // if($jumlahBarangToko < 1){
            //     $this->db->set('id_barang',$items['id']);
            //     $this->db->set('id_toko',$id_toko);
            //     $this->db->set('stok',$items['qty']);
            //     $this->db->set('harga',$items['price']);
            //     $this->db->insert('barang_toko');
            // }else{
            //     $getBarang = $barang->row();
            //     $id_barang = $getBarang->id_barang;
            //     $stok_baru= $getBarang->stok + $items['qty'];

            //     $this->db->where('id_toko',$id_toko);
            //     $this->db->where('id_barang',$id_barang);
            //     $this->db->set('stok',$stok_baru);
            //     $this->db->set('harga',$items['price']);
            //     $this->db->update('barang_toko');
            // }

                           
        }

        $this->db->where('id_po',$id_po);
        $this->db->set('sts',$sts);
        $this->db->update('po');
        redirect(base_url('admin/Po'));

        // var_dump($this->cart->contents());
        // die();
    }
}