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