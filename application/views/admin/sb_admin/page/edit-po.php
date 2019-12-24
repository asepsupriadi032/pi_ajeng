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

            
          </div>



        </div>
