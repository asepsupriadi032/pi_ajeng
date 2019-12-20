<?php $this->load->view('user/header') ?>
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>                 
              </span>
              Customer
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
                  <h4 class="card-title">Tambah Customer</h4>
                  <form class="forms-sample" method="post" action="<?php echo base_url("index/customer_proses") ?>">
                    <input type="hidden" name="id_toko" value="<?php echo $this->session->userdata("id") ?>">
                    <div class="form-group">
                      <label for="exampleInputUsername1">Nama Lengkap</label>
                      <input type="text" class="form-control" name="nama_customer"  placeholder="Nama">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputUsername1">Alamat</label>
                      <input type="text" class="form-control" name="alamat_customer"  placeholder="Alamat">
                    </div> 
                    <div class="form-group">
                      <label for="exampleInputUsername1">Nomor Telepon</label>
                      <input type="text" class="form-control" name="no_telp"  placeholder="Nomor Telepon">
                    </div>

                    <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <table class="table">
                    <tr>
                      <td>No</td>
                      <td>Nama Customer</td>
                      <td>Alamat Customer</td>
                      <td>Nomor Telepon</td>
                      <td>Aksi</td>
                    </tr>
                    <?php  
                      $no=1;
                      foreach ($orang->result() as $key) {
                       
                    ?>
                      <tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo $key->nama_customer ?></td>
                        <td><?php echo $key->alamat_customer ?></td>
                        <td><?php echo $key->no_telp ?></td>
                        <td><a href="<?php echo base_url('index/customer_hapus/'.$key->id_customer) ?>" class="btn btn-danger">X</a></td>
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