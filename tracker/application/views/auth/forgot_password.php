<link href="<?php echo base_url();?>assets/stylesheet/common/auth.css" rel="stylesheet" />
<section class="welcome-page">
<div class="app-phone">
  <div class="app-center">
    <h2 class="app-primary">Email</h2>
    <hr>
    <p class="app-small"> </p>
  </div>
          <?php if ($this->session->flashdata('login_msg')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('login_msg'); ?>
    </div>         
<?php endif; ?>

        <form method="POST" action ="<?php echo base_url(); ?>forgot-password-form">
            
            <div class="app-field">
                <label class="app-label">Forgot Password</label>
                <input id="email" class="app-input"  name="email" type="text" placeholder="Enter Your Email">
                
            </div>

            <button class="app-btn">Get OTP</button>
        </form>
   </div> 
</section>
<?php $this->load->view('common/form-script'); ?>
<style>
    .app-phone {
    width: 100%;
    }
      .formerror{
      color:red;
  }
</style>
