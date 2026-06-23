<link href="<?php echo base_url();?>assets/stylesheet/common/auth.css" rel="stylesheet" />
<section class="welcome-page">
<div class="app-phone">
  <div class="app-center">
    <h2 class="app-primary">OTP</h2>
    <hr>
    <p class="app-small">Please enter your OTP below!</p>
  </div>
          <?php if ($this->session->flashdata('login-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('login-message'); ?>
    </div>         
<?php endif; ?>

        <form method="POST" action ="<?php echo base_url(); ?>add-otp-form">
             
            <div class="app-field">
                <label class="app-label">Enter Otp</label>
                <input id="email" class="app-input"  name="forgot_pass_otp" type="text" placeholder="Enter Your Otp" >
            </div>

            <button class="app-btn">Verify OTP</button>
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
