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
                  <h6 class="card-title " text-align="center"><strong>USER : <?= strtoupper($user->full_name)?>, INSTANSI <?= strtoupper($user->instansi)?></strong></h6><br>
                  <h6 class="card-title " text-align="center"><strong>PILIH SOAL YANG AKAN DI TANYAKAN KE USER</strong></h6>
                  <a class="btn btn-secondary btn-sm float-right" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i>&ensp;Back
                  </a>
                </div>
                <div class="card-body">
                  <form action="<?= base_url('admin/soal_check') ?>" method="post">
                      <input type="hidden" name="id_user" value="<?= $user->id ;?>">
                      <div class="form-group">
                        <?php foreach ($soal as $s): ?>
                          <?php
                              $soal_exist = $this->admin_model->cekSoalExist($user->id, $s->id);
                          ?>
                          <div class="row">
                              <div class="col-md-12">  
                                  <label>
                                      <input type="checkbox" name="fruit[]" value="<?= $s->id ?>" <?= $soal_exist ? 'checked' : '' ?>> <?= $s->nama_soal ?>
                                  </label>
                              </div>
                          </div>
                          <?php endforeach; ?>
                      </div>

                      <?php if (!empty($soal)): ?>
                          <?php foreach ($soal as $s): ?>
                          <?php endforeach; ?>
                           <input type="hidden" name="id_klaster" value="<?= $s->id_klaster ;?>">
                              <input type="hidden" name="id_subklaster" value="<?= $s->id_subklaster;?>">
                                            
                              <div class="form-group text-right">
                                  <button type="submit" class="btn btn-primary btn-sm ">Submit &ensp;<i class="fas fa-arrow-right"></i></button>
                              </div>
                      <?php else: ?>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-12">  
                                <h2>Belum ada soal</h2>
                              </div>
                            </div>
                          </div>
                      <?php endif; ?>

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

<script>
function goBack() {
  window.history.back();
}
</script>
