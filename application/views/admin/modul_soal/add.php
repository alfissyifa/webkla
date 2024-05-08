        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header" style="text-align:center;">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <h4 class="m-0 text-dark"><strong><?= strtoupper($subklaster->nama_klaster);?><br><?= strtoupper($subklaster->nu);?>. <?= strtoupper($subklaster->nama_subklaster);?></strong></h4>
                </div><!-- /.col -->
              </div><!-- /.row -->
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
                  <h6 class="card-title " text-align="center"><strong>SOAL ADD</strong></h6>
                  <a class="btn btn-secondary btn-sm float-right" href="<?php echo base_url('admin/soal/'.$this->encrypt->encode($id_subklaster));?>">
                    <i class="fas fa-arrow-left"></i>&ensp;Back
                  </a>
                </div>
                <div class="card-body">

                  <form action="<?= base_url('admin/soal_add/'.$this->encrypt->encode($id_subklaster))?>" method="post">

                  <input type="hidden"  id="id_subklaster" name="id_subklaster" value="<?= $id_subklaster; ?>">

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-5">  
                          <label class="col-form-label">Nomor Urut</label>
                        </div>
                        <div class="col-md-7">  
                           <input type="number" name="no_urut" class="form-control" id="no_urut" value="<?= $no_urut; ?>">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-5">  
                          <label class="col-form-label">Nama Soal</label>
                        </div>
                        <div class="col-md-7">  
                           <textarea style="height: 150px;" type="text" name="nama_soal" class="form-control" id="nama_soal"><?= $nama_soal; ?></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-5">  
                          <label class="col-form-label">Pilihan Jika Ya</label>
                        </div>
                        <div class="col-md-7">  
                           <textarea style="height: 150px;" type="text" name="jika_ya" class="form-control" id="jika_ya"><?= $jika_ya; ?></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-5">  
                          <label class="col-form-label">Link Lampiran</label>
                        </div>
                        <div class="col-md-7">  
                           <textarea style="height: 150px;" type="text" name="lampiran" class="form-control" id="lampiran"><?= $lampiran; ?></textarea>
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