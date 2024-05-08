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
              <h6 class="m-0 text-dark"><strong><?= strtoupper($soal->nama_klaster);?><br><?= strtoupper($soal->nu);?>. <?= strtoupper($soal->nama_subklaster);?><br><?= strtoupper($soal->no_urut);?>. <?= strtoupper($soal->nama_soal);?></strong></h6>
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
              <h4 class="card-title " text-align="center"><strong>CHECKLIST SOAL</strong></h4>

              <a class="btn btn-sm btn-outline-info float-right" href="<?= base_url('admin/checklist_add/'.$this->encrypt->encode($soal->id))?>">
                <i class="fas fa-plus"></i> Add Data
              </a>
              <a style="margin-right: 10px" class="btn btn-secondary btn-sm float-right" href="<?php echo base_url('admin/soal/'.$this->encrypt->encode($soal->id_subklaster));?>">
                    <i class="fas fa-arrow-left"></i>&ensp;Back
                  </a>
            </div>
            <div class="card-body">
              <!-- SEARCH FORM -->
              <input type="hidden" name="id_soal" value="<?= $soal->id ;?>">
              <div class="input-group ">
                <input class="form-control col-sm-12" name="searchchecklist" id="searchchecklist" type="text" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-primary">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
              <div style="overflow: auto;">
              <table id="checklistData" class="table table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th class="first-column" scope="col" style="vertical-align:middle;"><center>Nama Checklist</th>  
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
