        <div class="content-wrapper">
          
          <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Toko</h4>
                  <div class="form-group">
                    <?php if(empty($this->session->userdata('nama_toko'))){?>
                    <label for="exampleInputUsername1">Pilih Toko</label>
                    <form method="post" action="<?php echo base_url('admin/Penjualan/addToko') ?>">
                      <select name="id_toko" class="form-control">
                        <option value="">Toko</option>
                        <?php  
                          foreach ($toko->result() as $key) {
                        ?>
                          <option value="<?php echo $key->id_toko ?>"><?php echo $key->nama_toko ?></option>
                        
                        <?php } ?>
                      </select>
                      <input type="submit" name="" value="Pilih" class="mr-2">
                    </form>
                    <?php } ?>
                    </div>
                  <?php if(!empty($this->session->userdata('nama_toko'))){?>
                  <form class="forms-sample" method="post" action="<?php echo base_url("admin/Penjualan/cartToko") ?>">
                    <div class="form-group">
                      <label for="exampleInputUsername1">Nama Toko</label>
                      <input type="text" name="nama_toko" id="nama_toko" value="<?php echo $this->session->userdata('nama_toko') ?>" readonly class="form-control">
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
                    <a href="<?php echo base_url('admin/Penjualan/hapusSession') ?>">Batal</a>
                  </form>
                  <?php } ?>
                </div>
              </div>
            </div>

            <?php if(!empty($this->session->userdata('nama_toko'))){?>
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3>Order List</h3>
                  <table class="table">
                    <tr>
                      <td>No</td>
                      <!-- <td>Nama Customer</td> -->
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
                      <!-- <td><?php echo $item["options"]["nama"] ?></td> -->
                      <td><?php echo $item["name"] ?></td>
                      <td><?php echo number_format ($item["price"]) ?></td>
                      <td><?php echo $item["qty"] ?></td>
                      <td><?php echo number_format ($item["subtotal"]) ?></td>
                      <td>
                        <form method="post" action="<?php echo base_url("admin/Penjualan/hapus_cart_penjualan") ?>">
                          <input type="hidden" value="<?php echo $item["rowid"] ?>" name="id">
                          <input type="submit" value="X" class="btn btn-danger">
                        </form>

                      </td>
                    </tr>

                    <?php 
                    $no++;
                    // $id_customer =  $item["options"]["id_customer"];
                    endforeach; ?>
                    <tr>
                      <td colspan="6" style="text-align: center">
                        Total : <?php echo number_format($this->cart->total())  ?>
                      </td>
                      <td>
                        <form method="post" action="<?php echo base_url("admin/Penjualan/proses_penjualan") ?>">
                          <input type="hidden" name="id_penerima" value="<?php echo $this->session->userdata('id_toko') ?>">
                          <button type="submit" class="btn btn-gradient-primary mr-2">Pesan</button>
                        </form>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>



        </div>
