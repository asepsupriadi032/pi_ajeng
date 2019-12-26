        <div class="content-wrapper">
          
          <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  
                  <form class="forms-sample" method="post" action="<?php echo base_url("admin/Po/updatePo") ?>">
                    <div class="form-group">
                      <label for="exampleInputUsername1">Nama Toko</label>
                      <input type="text" name="nama_toko" id="nama_toko" value="<?php echo $toko->nama_toko ?>" readonly class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputUsername1">Kode PO</label>
                      <input type="text" name="kode_po" value="<?php echo $toko->kode_po ?>" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputUsername1">Waktu</label>
                      <input type="text" class="form-control" name="waktu" value="<?php echo $toko->waktu ?>" readonly>
                    </div> 
                    <div class="form-group">
                      <label>Status</label>
                      <select name="sts" class="form-control">
                        <option value="sedang dipesan" <?php if($toko->sts=='sedang dipesan'){?> selected <?php } ?>>sedang dipesan</option>
                        <option value="sedang dikirim" <?php if($toko->sts=='sedang dikirim'){?> selected <?php } ?>>sedang dikirim</option>
                        <option value="diterima" <?php if($toko->sts=='diterima'){?> selected <?php } ?>>diterima</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                    <input type="hidden" name="id_po" value="<?php echo $toko->id_po ?>">
                    <input type="hidden" name="id_toko" value="<?php echo $toko->id_toko ?>">
                    <a href="<?php echo base_url('admin/Po') ?>">Batal</a>
                  </form>
                </div>
              </div>
            </div>

            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3>PO Detail</h3>
                  <table class="table">
                    <tr>
                      <td>No</td>
                      <td>Nama Barang</td>
                      <td>Harga</td>
                      <td>Qty</td>
                      <td>Sub Total</td>
                    </tr>
                    <?php 
                    $no=1;
                    $total = 0;
                    foreach ($detail as $key): ?>
                    <tr>
                      <td><?php echo $no ?></td>
                      <td><?php echo $key->nama_barang ?></td>
                      <td><?php echo number_format ($key->harga) ?></td>
                      <td><?php echo $key->qty ?></td>
                      <td><?php echo number_format ($key->harga * $key->qty) ?></td>
                    </tr>

                    <?php 
                    $total = $total + ($key->harga * $key->qty);
                    $no++;
                    // $id_customer =  $item["options"]["id_customer"];
                    endforeach; ?>
                    <tr>
                      <td colspan="4"></td>
                      <td>
                        Total : <?php echo number_format($total)  ?>
                      </td>
                      
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>



        </div>
