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
                  <h6 class="card-title " text-align="center"><strong>KLASTER EDIT</strong></h6>
                  <a class="btn btn-secondary btn-sm float-right" href="<?php echo base_url('Admin/klaster');?>">
                    <i class="fas fa-arrow-left"></i>&ensp;Back
                  </a>
                </div>
                <div class="card-body">

                  <form action="<?= base_url('Admin/klaster_edit/'.$this->encrypt->encode($klaster->id).'')?>" method="post">

                    <input type="hidden" name="id" value="<?= $klaster->id ;?>">

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">  
                          <label class="col-form-label">Nomor Urut</label>
                        </div>
                        <div class="col-md-9">  
                           <input type="text" name="no_urut" class="form-control" id="no_urut" value="<?= $klaster->no_urut?>">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">  
                          <label class="col-form-label">Nama Klaster</label>
                        </div>
                        <div class="col-md-9">  
                           <textarea style="height: 100px;" type="text" name="nama_klaster" class="form-control" id="nama_klaster"><?= $klaster->nama_klaster?></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="form-group text-right">
                      <button type="submit" class="btn btn-warning btn-sm ">Update &ensp;<i class="fas fa-edit"></i></button>
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