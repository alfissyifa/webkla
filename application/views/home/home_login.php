    <div class="intro-section" id="home-section">

      <div style="background:white;" data-stellar-background-ratio="0.1">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="row align-items-center" style="margin-top:100px;">
                <div class="col-lg-3" style="text-align:center;">
                </div>
                <div class="col-lg-6" style="text-align:center;">
                  <img src="<?= base_url('assets/');?>images/banner.png" style="width:100%;">
                </div>
                <div class="col-lg-3" style="text-align:center;">
                </div>

                <div class="col-lg-8 mb-4" style="text-align:center;">
                  <h1 style="line-height:35px;margin-bottom:7px;font-size:35px;color:black;" data-aos="fade-up" data-aos-delay="100">Dinas Pemberdayaan Perempuan</h1>
                  <h1 style="line-height:35px;margin-bottom:7px;font-size:35px;color:black" data-aos="fade-up" data-aos-delay="100">dan Perlindungan Anak</h1>
                </div>

                <div class="col-lg-4 mb-2" data-aos="fade-up" data-aos-delay="500">
                  <form action="<?= base_url('home/login');?>" method="post" class="form-box">
                    <h1 class="h4 mb-4" style="color:#6ac112;"><strong>Sign Up</strong>
										</h1>
                    <div class="form-group">
                      <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off">
                      <?php echo form_error('username', '<small class="text-danger pl-3">', '</small>');?>
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off">
                      <?php echo form_error('password', '<small class="text-danger pl-3">', '</small>');?>
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-success" value="Login" style="color:#fff;;font-size: 15px;padding: 10px;border-radius: 10px;border: 5px solid #514f4f">
                    </div>
                  </form>

                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>


