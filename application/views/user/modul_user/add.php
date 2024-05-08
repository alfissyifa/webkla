        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header">
            <div class="container-fluid">
 
              <?php if(validation_errors()) : ?>
                <!-- Row Note -->
                <div class="row">
                  <div class="col-12">
                    <div class="alert callout callout-info bg-danger" role="alert">
                      <h5><i class="fas fa-info"></i> Note:</h5>
                      <?= validation_errors(); ?>
                    </div>
                  </div>
                  <!--/. Col -->
                </div>
              <?php endif ;?>
              <?php if($this->session->flashdata('message') == TRUE) : ?>
                <!-- Row Note -->
                <div class="row">
                  <div class="col-12">
                    <div class="alert callout callout-info bg-danger" role="alert">
                      <h5><i class="fas fa-info"></i> Note:</h5>
                      <?= $this->session->flashdata('message'); ?>
                    </div>
                  </div>
                  <!--/. Col -->
                </div>
              <?php endif ;?>             
            </div><!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->

          <!-- Main content -->
          <section class="content ">
            <div class="container-fluid col-sm-8">
              <!-- Default box -->
              <div class="card card-outline card-info">
                <div class="card-header">
                  <h6 class="card-title " text-align="center"><strong>USER ADD</strong></h6>
                  <a class="btn btn-secondary btn-sm float-right" href="<?php echo base_url('admin/user');?>">
                    <i class="fas fa-arrow-left"></i>&ensp;Back
                  </a>
                </div>
                <div class="card-body">

                  <form action="<?= base_url('admin/user_add')?>" method="post">

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">  
                          <label class="col-form-label">Username</label>
                        </div>
                        <div class="col-md-9">  
                           <input type="text" name="username" class="form-control" id="username" value="<?= $username; ?>">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">  
                          <label class="col-form-label">Email</label>
                        </div>
                        <div class="col-md-9">  
                           <input type="text" name="email" class="form-control" id="email" value="<?= $email; ?>">
                        </div>
                    </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">  
                          <label class="col-form-label">Nama Lengkap</label>
                        </div>
                        <div class="col-md-9">  
                           <input type="text" name="full_name" class="form-control" id="full_name" value="<?= $full_name; ?>">
                        </div>
                    </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                          <div class="col-md-3">  
                              <label class="col-form-label">Jenis Kelamin</label>
                          </div>
                          <div class="col-md-9">  
                              <select name="jns_kelamin" id="jns_kelamin" class="form-control select2 cari_ak" style="width: 100%;" >
                                  <option value="" <?php if ($jns_kelamin == "") echo "selected"; ?>>Pilih Salah Satu</option>
                                  <option value="laki-laki" <?php if ($jns_kelamin == "laki-laki") echo "selected"; ?>>Laki-laki</option>
                                  <option value="perempuan" <?php if ($jns_kelamin == "perempuan") echo "selected"; ?>>Perempuan</option>
                              </select>
                          </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">  
                          <label class="col-form-label">Tanggal Lahir</label>
                        </div>
                        <div class="col-md-9">  
                           <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" value="<?= $tgl_lahir; ?>">
                        </div>
                    </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">  
                          <label class="col-form-label">Phone</label>
                        </div>
                        <div class="col-md-9">  
                           <input type="text" name="phone" class="form-control" id="phone" value="<?= $phone; ?>">
                        </div>
                    </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">  
                          <label class="col-form-label">Instansi</label>
                        </div>
                        <div class="col-md-9">  
                           <textarea style="height: 100px;" type="text" name="instansi" class="form-control" id="instansi"><?= $instansi; ?></textarea>
                        </div>
                    </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">  
                          <label class="col-form-label">Default Password</label>
                        </div>
                        <div class="col-md-9">  
                           <input type="text" name="password" class="form-control" id="password" value="User123" readonly>
                        </div>
                    </div>
                    </div>
                    
                    <div class="form-group text-right">
                      <button type="submit" class="btn btn-primary btn-sm ">Submit &ensp;<i class="fas fa-arrow-right"></i></button>
                    </div> 

                  </form>

                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.Container Fluid -->
          </section>
          <!-- /.content -->
          
        </div>