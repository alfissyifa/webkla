<style>
    /* Mengatur lebar kolom pertama menjadi 25% dari lebar kontainer induknya */
    .first-column {
      width: 85%;
    }
  </style>
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
      <section class="content">
        <div class="container-fluid">
          <!-- Default box -->
          <div class="card card-outline card-info">
            <div class="card-header">
              <h6 class="card-title " text-align="center"><strong>SETTING SOAL</strong></h6><br>
              <h6 class="card-title " text-align="center"><strong>USER : <?= strtoupper($user->full_name)?>, INSTANSI <?= strtoupper($user->instansi)?></strong></h6><br>
              <h6 class="card-title " text-align="center"><strong>PILIH KLASTER</strong></h6>
              <a class="btn btn-secondary btn-sm float-right" href="<?php echo base_url('admin/user');?>"><i class="fas fa-arrow-left"></i>&ensp;Back</a>
            </div>
            <div class="card-body">
              <!-- SEARCH FORM -->
              <input type="hidden" name="id_user" value="<?= $user->id ;?>">              

              <div class="input-group ">
                <input class="form-control col-sm-12" name="seachListSklaster" id="seachListSklaster" type="text" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-primary">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
              <div style="overflow: auto;">
              <table id="SklasterData" class="table table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th scope="col" style="vertical-align:middle;"><center>Nama Klaster</th>
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
