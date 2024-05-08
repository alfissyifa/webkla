<style>
    /* Mengatur lebar kolom pertama menjadi 25% dari lebar kontainer induknya */
    .f1-column {
      width: 22%;
    }
    .f2-column {
      width: 22%;
    }
    .f3-column {
      width: 40%;
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
              <h6 class="card-title " text-align="center"><strong>USER</strong></h6>
              <a class="btn btn-sm btn-outline-info float-right" href="<?= base_url('admin/user_add')?>">
                <i class="fas fa-plus"></i> Add Data
              </a>
            </div>
            <div class="card-body">
              <!-- SEARCH FORM -->
              

              <div class="input-group ">
                <input class="form-control col-sm-12" name="seachuser" id="seachuser" type="text" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-primary">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
              <div style="overflow: auto;">
              <table id="userData" class="table table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th scope="col" style="vertical-align:middle;"><center>Username</th>
                    <th scope="col" style="vertical-align:middle;"><center>Nama Lengkap</th>
                    <th scope="col" style="vertical-align:middle;"><center>Instansi</th>
                    <th scope="col" style="vertical-align:middle;"><center>Action</th>  
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
