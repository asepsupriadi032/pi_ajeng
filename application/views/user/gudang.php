<?php $this->load->view('user/header') ?>
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>                 
              </span>
              Gudang
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
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <table class="table">
                    <tr>
                      <td>No</td>
                      <td>Nama Barang</td>
                      <td>Stok</td>
                      <td>Harga/pcs</td>
                      <td>Edit Harga</td>
                    </tr>
                    <?php  
                      $no=1;
                      foreach ($brg->result() as $key) {
                       
                    ?>
                      <tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo $key->nama_barang ?></td>
                        <td><?php 
                          if ($key->stok <= 25) {
                            echo "<span class='badge badge-pill badge-warning'>". $key->stok ."</span>";
                          }
                          else{
                            echo $key->stok ;
                          }
                          ?></td>
                        <td><?php echo $key->harga ?></td>
                        <td>
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $key->id_barangtoko ?>">
                            Edit
                          </button>
                          <!-- Modal -->
                          <form action="<?php echo base_url('Index/UpdateHarga') ?>" method="post">
                            <div class="modal fade" id="exampleModal<?php echo $key->id_barangtoko ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Harga <?php echo $key->nama_barang ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <input type="text" name="harga" class="form-control" value="<?php echo $key->harga ?>">
                                    <input type="hidden" name="id_barangtoko" value="<?php echo $key->id_barangtoko ?>">
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                          <!--End Modal-->
                        </td>
                       
                      </tr>
                    <?php  
                      $no++;
                    }
                    ?>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

<?php $this->load->view('user/footer') ?>