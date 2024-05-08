    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark"><?= $page ;?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><small><?= $user->username ;?></small></li>
                <li class="breadcrumb-item"><a href="<?= base_url('user')?>"><small><?= $page ;?></small></a></li>
              </ol>
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
          <!-- Small boxes (Stat box) -->
          <div class="row">
            
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?= $ttlklaster ;?></h3>

                  <p>Klaster</p>
                </div>
                <div class="icon">
                  <i class="far fas fa-tasks"></i>
                </div>
              </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3 ><?= $ttlsubklaster?></h3>

                  <p>Sub Klaster</p>
                </div>
                <div class="icon">
                  <i class="far fas fa-tasks"></i>
                </div>
              </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-4 col-6 ">
              <!-- small box -->
              <div class="small-box bg-secondary ">
                <div class="inner">
                  <h3 ><?= $ttlsoal?></h3>

                  <p >Soal</p>
                </div>
                <div class="icon">
                  <i class="far fa-list-alt" aria-hidden="true"></i>
                </div>

              </div>
            </div>
            
          </div>
          <!-- /.row -->

      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>

</div>