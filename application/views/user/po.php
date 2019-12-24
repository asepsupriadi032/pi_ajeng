<?php $this->load->view('user/header') ?>
<style type="text/css">
  input[type=number]{
    padding: 5px;
  }
</style>
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>                 
              </span>
              Pre Order
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
                  <h4 class="card-title">Tambah Order</h4>
                  <form class="forms-sample" method="post" action="<?php echo base_url("index/cart_po") ?>">
                    <input type="hidden" name="id_toko" value="<?php echo $this->session->userdata("id") ?>">
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
                      <td>Nama Barang</td>
                      <td>Qty</td>
                      <td>Aksi</td>
                    </tr>
                    <?php 
                    $no=1;
                    foreach ($this->cart->contents() as $item): ?>
                       
                    <tr>
                      <td><?php echo $no ?></td>
                      <td><?php echo $item["name"] ?></td>
                      <td><?php echo $item["qty"] ?></td>
                      <td>
                        <form method="post" action="<?php echo base_url("index/hapus_cart_po") ?>">
                          <input type="hidden" value="<?php echo $item["rowid"] ?>" name="id">
                          <input type="submit" value="X" class="btn btn-danger">
                        </form>

                      </td>
                    </tr>

                    <?php 
                    $no++;
                    endforeach; ?>
                    <tr>
                      <td colspan="4" text-align-center>
                        <form method="post" action="<?php echo base_url("index/proses_po") ?>">
                          <input type="hidden" name="id_toko" value="<?php echo $this->session->userdata("id") ?>">
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
                  <h4>Pre Order</h4>
                  <table class="table">
                    <tr>
                      <td>No</td>
                      <td>Kode PO</td>
                      <td>Aksi</td>
                    </tr>
                    <?php
                      $no=1;
                      foreach ($po->result() as $key): ?>
                        
                      <tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo $key->kode_po ?></td>
                        <td>
                          <?php 
                          if($key->sts == "sedang dikirim"){
                          ?>
                            <a href="<?php echo base_url('index/update_po/'.$this->session->userdata('id').'/'.$key->id_po) ?>" class="btn btn-gradient-primary mr-2">terima</a>
                          <?php
                          } 
                          else{
                          ?>
                            
                            <span class="badge badge-dark" style="padding:10px "><?php  echo $key->sts;?> </span> <br>

                          <?php
                          }

                          ?>
                          <form method="post" action="<?php echo base_url("index/lihat_po") ?>">
                            <input type="hidden" name="id_po" value="<?php echo $key->id_po ?>">
                            <button type="submit" class="btn btn-info">Lihat</button>
                          </form>
                        </td>
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
                  <h4>Detail Barang</h4>
                  <table class="table">
                    <tr>
                      <td>No</td>
                      <td>Barang</td>
                      <td>Harga</td>
                      <td>Qty</td>
                      <td>Sub Total</td>
                    </tr>
                    <?php
                      $no=1;
                      if(isset($po_detail)){
                        foreach ($po_detail->result() as $key): ?>
                          
                        <tr>
                          <td><?php echo $no ?></td>
                          <td><?php echo $key->nama_barang ?></td>
                          <td><?php echo number_format ($key->harga) ?></td>
                          <td><?php echo $key->qty ?></td>
                          <td>
                           <?php 
                              $sub_total = $key->qty * $key->harga;
                              echo number_format ($sub_total);
                            ?>
                          </td>
                        </tr>

                        <?php 
                        $no++;
                        endforeach; 
                        }
                    ?>
                  </table>
                </div>
              </div>
            </div>
          </div>


        </div>

<?php $this->load->view('user/footer') ?>