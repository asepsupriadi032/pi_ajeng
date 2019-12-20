<?php $this->load->view('user/header') ?>
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
                  <form class="forms-sample" method="post" action="<?php echo base_url("index/cart_customer") ?>">
                    <input type="hidden" name="id_toko" value="<?php echo $this->session->userdata("id") ?>">
                    <div class="form-group">
                      <label for="exampleInputUsername1">Nama Customer</label>
                      <select name="id_customer" class="form-control">

                        <option value="">Pilih Customer</option>

                        <?php  
                          foreach ($user->result() as $key) {
                        ?>
                          <option value="<?php echo $key->id_customer ?>"><?php echo $key->nama_customer ?></option>
                        
                        <?php } ?>
                      </select>
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
                      <td>Nama Customer</td>
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
                      <td><?php echo $item["options"]["nama"] ?></td>
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
                    $id_customer =  $item["options"]["id_customer"];
                    endforeach; ?>
                    <tr>
                      <td colspan="6" style="text-align: center">
                        Total : <?php echo number_format($this->cart->total())  ?>
                      </td>
                      <td>
                        <form method="post" action="<?php echo base_url("index/proses_penjualan") ?>">
                          <input type="hidden" name="id_toko" value="<?php echo $this->session->userdata("id") ?>">
                          <?php if(isset($id_customer)){ ?>
                          <input type="hidden" name="id_customer" value="<?php echo $id_customer ?>">
                          <?php } ?>
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
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4>Pre Order</h4>
                  <table class="table">
                    <tr>
                      <td>No</td>
                      <td>Kode PO</td>
                      <td>Total</td>
                    </tr>
                    <?php
                      $no=1;
                      foreach ($penjualan->result() as $key): ?>
                        
                      <tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo $key->kode_penjualan ?></td>
                        <td> Rp. <?php echo number_format($key->total_harga); ?></td>
                      </tr>

                      <?php 
                      $no++;
                      endforeach ?>
                   
                  </table>
                </div>
              </div>
            </div>
          </div>


        </div>

<?php $this->load->view('user/footer') ?>