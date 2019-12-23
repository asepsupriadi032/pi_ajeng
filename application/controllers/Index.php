<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {


	function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('user/login');
	}


	public function login()
	{
		$check= $this->db->get_where('toko',array('username'=>$this->input->post("user"),
													"password"=>$this->input->post("pass")))->row();
		if($check){
			$this->session->set_userdata("login_toko",true);
			$this->session->set_userdata("id",$check->id_toko);
			$this->session->set_userdata("nama_toko",$check->nama_toko);

			redirect(base_url('index/home'));
		}
		else {
			redirect(base_url());
		}
	}


	public function home(){
		$this->load->view('user/home');
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}


	public function customer(){
		$data['orang']=$this->db->get_where('customer',array('id_toko'=>$this->session->userdata("id")));
		$this->load->view('user/customer',$data);
	}

	public function customer_proses(){
		$this->db->insert('customer',$_POST);
		redirect(base_url("index/customer"));
	}

	public function customer_hapus($id){
		$this->db->delete("customer",array('id_customer'=>$id));
		redirect(base_url("index/customer"));
	}

	public function po(){
		$barang['po']=$this->db->get_where('po',array( 'id_toko'=>$this->session->userdata('id')));
		$barang['brg']=$this->db->get('barang');
		$this->load->view('user/po',$barang);
	}

	public function lihat_po(){
		$this->db->join('barang','po_detail.id_barang=barang.id_barang');
		$barang['po_detail']=$this->db->get_where('po_detail',array('id_po'=>$this->input->post('id_po')));
		$barang['po']=$this->db->get_where('po',array( 'id_toko'=>$this->session->userdata('id')));
		$barang['brg']=$this->db->get('barang');
		$this->load->view('user/po',$barang);
	}
	public function cart_po(){
		$row=$this->db->get_where("barang",array('id_barang'=>$this->input->post('id_barang')))->row();

		$data=array(
			'id'=>$row->id_barang,
			'qty'=>$this->input->post("qty"),
			'price'=>$row->harga,
			'name'=>$row->nama_barang
		);
		$this->cart->insert($data);
		// print_r($this->cart->contents());
		// die();

		redirect (base_url('index/po'));
	
	}


	public function hapus_cart_po(){
		$id=$this->input->post('id',true);
		$data=array(
					'rowid'=>$id,
					'qty'=>0
				);
		$this->cart->update($data);
		redirect (base_url('index/po'));
	}

	public function proses_po(){
		if (!$this->input->post())
			redirect('index/po');

		$code=time();
		// echo $code;die();
		$data=array('id_toko'=>$this->input->post('id_toko'),'kode_po'=>$code);

		$this->db->insert('po',$data);
		$id_po=$this->db->insert_id();

		foreach ($this->cart->contents() as $items){
			// print_r($items);die();

			$this->db->insert('po_detail',array(
				'id_po'=>$id_po,
				'id_barang'=>$items['id'],
				'qty'=>$items['qty']));

			$data=array(
						'rowid'=>$items['rowid'],
						'qty'=>0
					);
			$this->cart->update($data);
		}
		redirect (base_url('index/po'));
	}

	public function update_po($id_toko,$po){
		// id_barang di ambil dari barang_toko
		$barang=$this->db->get_where('barang_toko',array('id_toko'=>$id_toko));
		foreach ($barang->result() as $key ) {
			$po_detail=$this->db->get_where('po_detail',array('id_po'=>$po));
			foreach ($po_detail->result() as $v) {
				if ($key->id_barang == $v->id_barang) {
					$stok_baru= $key->stok + $v->qty;

					$this->db->where('id_toko',$id_toko);
					$this->db->where('id_barang',$key->id_barang);
					$this->db->update('barang_toko',array('stok'=>$stok_baru));
				}
			}
		}
		$this->db->where('id_po',$po);
		$this->db->update('po',array('sts'=>'diterima'));

		redirect(base_url('index/po'));
	}

	public function penjualan($id_penjualan = NULL){
		$id_toko =  $this->session->userdata('id');
		$barang['user']=$this->db->get('customer');

		$this->db->select('barang.*');
		$this->db->where('barang_toko.id_toko', $id_toko);
		$this->db->join('barang_toko','barang_toko.id_barang=barang.id_barang');
		$barang['brg']=$this->db->get('barang');

		if(!empty($id_penjualan)){
			$this->db->where('penjualan_detail.id_penjualan',$id_penjualan);
			$this->db->join('barang','barang.id_barang=penjualan_detail.id_barang');
			$barang['po_detail'] = $this->db->get('penjualan_detail');
		}

		$barang['penjualan']=$this->db->get('penjualan');
		$this->load->view('user/penjualan',$barang);
	}

	public function addcustomer(){
		$this->session->set_userdata('nama_customer',$this->input->post('nama_customer'));

		redirect(base_url('Index/penjualan'));
	}

	public function cart_customer(){
		$this->db->select('barang_toko.*, barang.nama_barang');
		$this->db->join('barang_toko','barang_toko.id_barang=barang.id_barang');
		$row=$this->db->get_where("barang",array('barang_toko.id_barang'=>$this->input->post('id_barang'), 'barang_toko.id_toko'=>$this->session->userdata('id')))->row();
		// var_dump($row); die();

		$harga=$row->harga;

		$data=array(
			'id'=>$row->id_barang,
			'qty'=>$this->input->post("qty"),
			'price'=>$harga,
			'name'=>$row->nama_barang,
			'options'=>array('nama_customer'=>$this->input->post('nama_customer'))
		);
		$this->cart->insert($data);
		// print_r($this->cart->contents());
		// die();
		$stokBaru = $row->stok - $this->input->post("qty");

		$this->db->set('stok', $stokBaru);
		$this->db->where('id_toko',$this->session->userdata('id'));
		$this->db->where('id_barang',$this->input->post('id_barang'));
		$this->db->update('barang_toko');


		redirect (base_url('index/penjualan'));
	
	}
	public function hapus_cart_penjualan(){
		foreach ($this->cart->contents() as $key) {
			$qty = $key['qty'];
			$id = $key['id'];

			$row = $this->db->get_where('barang_toko',array('id_toko'=>$this->session->userdata('id'), 'id_barang'=>$id))->row();

			$stokBaru = $row->stok + $qty;

			$this->db->where('id_barang',$id);
			$this->db->where('id_toko',$this->session->userdata('id'));
			$this->db->set('stok',$stokBaru);
			$this->db->update('barang_toko');
		}

		$id=$this->input->post('id',true);
		$data=array(
					'rowid'=>$id,
					'qty'=>0
				);
		$this->cart->update($data);
		redirect (base_url('index/penjualan'));
	}

	public function proses_penjualan(){
		if (!$this->input->post())
			redirect('index/penjualan');

		$code=time();
		// echo $code;die();
		$data=array('id_toko'=>$this->input->post('id_toko'),
					'kode_penjualan'=>$code,
					'nama_customer'=>$this->input->post('id_customer'),
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


			
		}

        $this->session->unset_userdata('nama_customer');
        $this->cart->destroy();
			// die();
		redirect (base_url('index/penjualan'));
	}

	public function gudang(){
		$this->db->select('barang_toko.*, barang.nama_barang');
		$this->db->join('barang','barang.id_barang=barang_toko.id_barang');
		$barang['brg']=$this->db->get_where('barang_toko',array('id_toko'=>$this->session->userdata('id')));
		// var_dump($barang); die();
		$this->load->view('user/gudang',$barang);
	}

	public function UpdateHarga(){
		$id_barangtoko = $this->input->post('id_barangtoko');
		$harga = $this->input->post('harga');

		$this->db->where('id_barangtoko',$id_barangtoko);
		$this->db->set('harga',$harga);
		$this->db->update('barang_toko');

		redirect(base_url('Index/gudang'));
	}


}