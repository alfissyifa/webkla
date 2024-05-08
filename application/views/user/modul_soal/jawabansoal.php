<?php
    echo '<script>';
    var_dump($subklaster);
    echo '</script>';
?>

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
                  <h6 class="card-title " text-align="center"><strong>JAWABAN</strong></h6>
                  <a class="btn btn-secondary btn-sm float-right" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i>&ensp;Back
                  </a>
                </div>
                <div class="card-body">
                  <form action="<?= base_url('user/checklist_check') ?>" method="post">
                      <input type="hidden" name="id_user" value="<?= $user->id ;?>">
                      <input type="hidden" name="id_soal" value="<?= $nosoal->id ;?>">
                      <input type="hidden" name="id_subklaster" value="<?= $subklaster->id_subklaster ;?>">
                      
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-12">  
                            <label class="col-form-label"><?= $nosoal->no_urut ;?>. <?= $nosoal->nama_soal ;?></label>
                          </div>
                          <?php if ($nosoal->lampiran != '' && $nosoal->lampiran != '-' && $nosoal->lampiran != '#'): ?>
                              <div class="col-md-12">  
                                  <a class="btn btn-sm btn-success" href="<?= $nosoal->lampiran; ?>" target="_blank">Lampiran</a>
                              </div>
                          <?php endif; ?>
                        </div>
                      </div>

                      <?php if (is_object($jawaban) && property_exists($jawaban, 'jawaban_a')): ?>
                        <div class="form-group">
                          <div class="row">
                              <div class="col-md-2">  
                                  <?php if ($jawaban->jawaban_a == 'Ya'): ?>
                                      <label><input type="radio" name="pilihan" value="Tidak" onclick="toggleTextarea()"> Tidak</label>
                                  <?php else: ?>
                                      <label><input type="radio" name="pilihan" value="Tidak" onclick="toggleTextarea()" checked> Tidak</label>
                                  <?php endif; ?>
                              </div>
                              <div class="col-md-2">  
                                  <?php if ($jawaban->jawaban_a == 'Tidak'): ?>
                                      <label><input type="radio" name="pilihan" value="Ya" onclick="toggleTextarea()"> Ya</label>
                                  <?php else: ?>
                                      <label><input type="radio" name="pilihan" value="Ya" onclick="toggleTextarea()" checked> Ya</label>
                                  <?php endif; ?>
                              </div>
                          </div>
                      </div>
                      <?php else: ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">  
                                        <label><input type="radio" name="pilihan" value="Tidak" onclick="toggleTextarea()" checked> Tidak</label>
                                </div>
                                <div class="col-md-2">  
                                      <label><input type="radio" name="pilihan" value="Ya" onclick="toggleTextarea()"> Ya</label>
                                </div>
                            </div>
                        </div>
                      <?php endif; ?>

                      <div class="form-group" id="textareab" style="display: none;">
                          <div class="row">
                              <div class="col-md-12">  
                                  <textarea style="height: 100px;" type="text" name="jawaban_b" class="form-control" id="jawaban_b"  readonly><?= $nosoal->jika_ya ;?></textarea>
                              </div>
                          </div>
                      </div>

                      <div class="form-group" id="textareac" style="display: none;">
                          <div class="row">
                              <div class="col-md-12">  
                                  <textarea style="height: 100px;" type="text" name="jawaban_c" class="form-control" id="jawaban_c"></textarea>
                              </div>
                          </div>
                      </div>

                      

                      <?php if (is_object($jawaban) && property_exists($jawaban, 'jawaban_a')): ?>
                          <div class="form-group" id="checkboxes" style="display: <?= $jawaban->jawaban_a == 'Ya' ? 'block' : 'none' ?>">
                              <?php foreach ($soal as $s): ?>
                                  <?php
                                      $soal_exist = $this->admin_model->cekChecklistExist($user->id, $s->id);
                                  ?>
                                  <div class="row">
                                      <div class="col-md-12">  
                                          <label>
                                              <input type="checkbox" name="fruit[]" value="<?= $s->id ?>" <?= $soal_exist ? 'checked' : '' ?>> <?= $s->nama_checklist ?>
                                          </label>
                                      </div>
                                  </div>
                              <?php endforeach; ?>
                          </div>
                      <?php else: ?>
                          <div class="form-group" id="checkboxes" style="display: none">
                              <?php foreach ($soal as $s): ?>
                                  <?php
                                      $soal_exist = $this->admin_model->cekChecklistExist($user->id, $s->id);
                                  ?>
                                  <div class="row">
                                      <div class="col-md-12">  
                                          <label>
                                              <input type="checkbox" name="fruit[]" value="<?= $s->id ?>" <?= $soal_exist ? 'checked' : '' ?>> <?= $s->nama_checklist ?>
                                          </label>
                                      </div>
                                  </div>
                              <?php endforeach; ?>
                          </div>
                      <?php endif; ?>


                      <?php if ($jawaban && isset($jawaban->catatan)): ?>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-3">  
                              <label class="col-form-label">Catatan</label>
                            </div>
                            <div class="col-md-9">  
                               <input type="text" name="catatan" class="form-control" id="catatan" value="<?= $jawaban->catatan ;?>">
                            </div>
                          </div>
                        </div>
                      <?php else: ?>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-3">  
                              <label class="col-form-label">Catatan</label>
                            </div>
                            <div class="col-md-9">  
                               <input type="text" name="catatan" class="form-control" id="catatan" value="">
                            </div>
                          </div>
                        </div>
                      <?php endif; ?>

                      <?php if ($jawaban && isset($jawaban->lampiran)): ?>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-3">  
                              <label class="col-form-label">Link Lampiran</label>
                            </div>
                            <div class="col-md-9"> 
                              <textarea style="height: 100px;" type="text" name="lampiran" class="form-control" id="lampiran"><?= $jawaban->lampiran ;?></textarea>
                            </div>
                          </div>
                        </div>
                      <?php else: ?>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-3">  
                              <label class="col-form-label">Link Lampiran</label>
                            </div>
                            <div class="col-md-9">  
                               <textarea style="height: 100px;" type="text" name="lampiran" class="form-control" id="lampiran"></textarea>
                            </div>
                          </div>
                        </div>
                      <?php endif; ?>
                                            
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

<script>

function goBack() {
  window.history.back();
}

    function toggleTextarea() {
        var radios = document.getElementsByName('pilihan');
        var textareab = document.getElementById('textareab');
        var textareac = document.getElementById('textareac');
        //var checkboxes = document.getElementById('checkboxes');

        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked && radios[i].value === 'Ya') {
                textareab.style.display = 'block';
                textareac.style.display = 'none';
                checkboxes.style.display = 'block';
            } else {
                textareab.style.display = 'none';
                textareac.style.display = 'block';
                checkboxes.style.display = 'none';
            }
        }
    }

    // Panggil fungsi toggleTextarea saat halaman dimuat
    window.onload = toggleTextarea;
  
</script>
