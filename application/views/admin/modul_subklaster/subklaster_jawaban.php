    <style>
    /* Mengatur lebar kolom pertama menjadi 25% dari lebar kontainer induknya */
    .first-column {
      width: 90%;
    }
  </style>
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header" style="text-align:center;">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h4 class="m-0 text-dark"><strong><?= strtoupper($klaster->nama_klaster);?></strong></h4>
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
      <section class="content">
        <div class="container-fluid">
          <!-- Default box -->
          <div class="card card-outline card-info">
            <div class="card-header">
              <h6 class="card-title " text-align="center"><strong>.:: J A W A B A N ::.</strong></h6><br>
              <h6 class="card-title " text-align="center"><strong>USER : <?= strtoupper($user->full_name)?>, INSTANSI <?= strtoupper($user->instansi)?></strong></h6><br>
              <h6 class="card-title " text-align="center"><strong>PILIH SUB KLASTER</strong></h6>
              <a class="btn btn-secondary btn-sm float-right" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i>&ensp;Back
                  </a>
            </div>
            <div class="card-body">
              <!-- SEARCH FORM -->
              <input type="hidden" name="id_klaster_jawaban" value="<?= $klaster->id ;?>">
              <input type="hidden" name="id_user_subklaster_jawaban" value="<?= $user->id ;?>">

              <div class="input-group ">
                <input class="form-control col-sm-12" name="seachsubklasterUser_jawaban" id="seachsubklasterUser_jawaban" type="text" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-primary">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
              <div style="overflow: auto;">
              <table id="subklasterDataUser_jawaban" class="table table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th scope="col" style="vertical-align:middle;"><center>Nama Sub Klaster</th>  
                    <th style="width:100px" scope="col" style="vertical-align:middle;"><center>Action</th>  
                  </tr>
                </thead>
              </table>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.Container Fluid -->
      </section>
      <!-- /.content -->

    </div>
    <!-- Barang Hapus Modal-->

<script>
  function goBack() {
    window.history.back();
  }
</script>