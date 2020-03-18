<?php $this->load->view('user/header') ?>
<style type="text/css">
  input[type=number]{
    padding: 5px;
  }

  .kodePenjualan{
    color: #b66dff;
  }
</style>
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>                 
              </span>
              Penjualan
            </h3>
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span></span>Overview
                  <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
              </ul>
            </nav>
          </div>

          <div class="row">
            <div class="col-md-4 grid-margin stretch-card">

              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tambah Order Penjualan</h4>
                  <!-- alert -->
                  <?php if(!empty($this->session->userdata('alert'))){ ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf!</strong> Stok barang <b><?php echo $this->session->userdata('nama_barang'); ?></b> tidak cukup.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <?php 
                    }
                    $this->session->unset_userdata('alert');
                    $this->session->unset_userdata('nama_barang');
                  ?>
                  <!-- alert -->
                  <?php if(empty($this->session->userdata('kode_penjualan'))){ ?>
                  <form class="forms-sample" method="post" action="<?php echo base_url("Index/addcustomer") ?>">
                    <div class="form-group">
                      <label for="exampleInputUsername1">Kode Penjualan</label>
                      <input type="text" name="kode_penjualan" class="form-control" value="<?php echo time(); ?>" readonly>
                    </div>
                    <div class="form-group">
                      <input type="submit" name="" value="Add" class="btn btn-primary">
                    </div>

                  </form>
                  <?php }else{?>
                  <form action="<?php echo base_url('Index/cart_customer') ?>" method="post">
                    <div class="form-group">
                      <input type="text" name="kode_penjualan" class="form-control" value="<?php echo $this->session->userdata('kode_penjualan') ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputUsername1">Nama Barang</label>
                      <select name="id_barang" class="form-control">

                        <option value="">Pilih Barang</option>
                        <?php  
                          foreach ($brg->result() as $key) {
                        ?>
                          <option value="<?php echo $key->id_barang ?>"><?php echo $key->nama_barang ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputUsername1">Qty</label>
                      <input type="Number" class="form-control" name="qty" min="1"  placeholder="qty">
                    </div> 
                    <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                  </form>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3>Order List</h3>
                  <table class="table">
                    <tr>
                      <td>No</td>
                      <td>Kode Penjualan</td>
                      <td>Nama Barang</td>
                      <td>Harga</td>
                      <td>Qty</td>
                      <td>Sub Total</td>
                      <td>Aksi</td>
                    </tr>
                    <?php 
                    $no=1;
                    foreach ($this->cart->contents() as $item): ?>
                       
                    <tr>
                      <td><?php echo $no ?></td>
                      <td><?php echo $item["kode_penjualan"] ?></td>
                      <td><?php echo $item["name"] ?></td>
                      <td><?php echo number_format ($item["price"]) ?></td>
                      <td><?php echo $item["qty"] ?></td>
                      <td><?php echo number_format ($item["subtotal"]) ?></td>
                      <td>
                        <form method="post" action="<?php echo base_url("index/hapus_cart_penjualan") ?>">
                          <input type="hidden" value="<?php echo $item["rowid"] ?>" name="id">
                          <input type="submit" value="X" class="btn btn-danger">
                        </form>

                      </td>
                    </tr>

                    <?php 
                    $no++;
                    //$id_customer =  $item["options"]["id_customer"];
                    endforeach; ?>
                    <tr>
                      <td colspan="6" style="text-align: center">
                        Total : <?php echo number_format($this->cart->total())  ?>
                      </td>
                      <td>
                        <form method="post" action="<?php echo base_url("index/proses_penjualan") ?>">
                          <input type="hidden" name="id_toko" value="<?php echo $this->session->userdata("id") ?>">
                          <input type="hidden" name="kode_penjualan" value="<?php echo $this->session->userdata('kode_penjualan') ?>">
                          <button type="submit" class="btn btn-gradient-primary mr-2">order</button>
                        </form>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>

           <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4>Rekap Penjualan</h4>
                  <table class="table">
                    <tr>
                      <th>No</th>
                      <th>Tanggal</th>
                      <th>Kode Penjualan</th>
                      <th>Total</th>
                      <th>Detail</th>
                    </tr>
                    <?php
                      $no=1;
                      foreach ($penjualan->result() as $key): ?>
                        
                      <tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo tanggalShow($key->waktu) ?></td>
                        <td><?php echo $key->kode_penjualan ?></td>
                        <td> Rp. <?php echo number_format($key->total_harga); ?></td>
                        <td><a href="<?php echo base_url('Index/Penjualan/').$key->id_penjualan ?>">Lihat</a></td>
                      </tr>

                      <?php 
                      $no++;
                      endforeach ?>
                   
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4>Detail Barang <?php echo $kode_penjualan ?></h4>
                  <table class="table">
                    <tr>
                      <td>No</td>
                      <td>Barang</td>
                      <td>Harga (@)</td>
                      <td>Qty</td>
                      <td>Sub Total</td>
                    </tr>
                    <?php
                      $no=1;
                      $total = 0;
                      if(isset($po_detail)){
                        foreach ($po_detail->result() as $key): ?>
                          
                        <tr>
                          <td><?php echo $no ?></td>
                          <td><?php echo $key->nama_barang ?></td>
                          <td><?php echo number_format ($key->harga) ?></td>
                          <td><?php echo $key->qty ?></td>
                          <td>Rp. 
                           <?php 
                              $sub_total = $key->qty * $key->harga;
                              echo number_format ($sub_total);
                            ?>
                          </td>
                        </tr>

                        <?php 
                        $no++;
                        $total = $total + $sub_total;
                        endforeach; 
                        ?>
                        <tr>
                          <td colspan="4" class="text-right">Total</td>
                          <td>Rp. <?php echo number_format($total); ?></td>
                        </tr>
                        <?php } ?>
                  </table>
                </div>
              </div>
            </div>
          </div>


        </div>

<?php $this->load->view('user/footer') ?>