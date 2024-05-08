        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header" style="text-align:center;">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <h4 class="m-0 text-dark"><strong><?= strtoupper($soal->nama_klaster);?><br><?= strtoupper($soal->nu);?>. <?= strtoupper($soal->nama_subklaster);?><br><?= strtoupper($soal->no_urut);?>. <?= strtoupper($soal->nama_soal);?></strong></h4>
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
                  <h6 class="card-title " text-align="center"><strong>CHECKLIST ADD</strong></h6>
                  <a class="btn btn-secondary btn-sm float-right" href="<?php echo base_url('admin/checklist/'.$this->encrypt->encode($id_soal));?>">
                    <i class="fas fa-arrow-left"></i>&ensp;Back
                  </a>
                </div>
                <div class="card-body">

                  <form action="<?= base_url('admin/checklist_add/'.$this->encrypt->encode($id_soal))?>" method="post">

                  <input type="hidden"  id="id_soal" name="id_soal" value="<?= $id_soal; ?>">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">  
                          <label class="col-form-label">Checklist Soal</label>
                        </div>
                        <div class="col-md-9">  
                           <textarea style="height: 100px;" type="text" name="nama_checklist" class="form-control" id="nama_checklist"><?= $checklist_soal; ?></textarea>
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