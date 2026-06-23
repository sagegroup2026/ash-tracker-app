<link href="<?php echo base_url();?>assets/stylesheet/common/auth.css" rel="stylesheet" />
<div class="welcome-page">
    <div class="app-phone">
    <div class="app-center">
    <h2 class="app-primary">Create Account</h2>
    <!--<p class="app-small">-->
    <!--  Create an account so you can explore all the existing jobs-->
    <!--</p>-->
  </div>
  <?php if ($this->session->flashdata('register-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('register-message'); ?>
    </div>         
<?php endif; ?>
    <form method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>save-register">
    <div class="app-field">
        <label class="app-label">Name</label>
        <input name="name" type="text" oninput="validateInput(event, 'name')" class="app-input" placeholder="Enter your name" required>
        <span class="formerror" data-for="name"></span>
      </div>
    
      <div class="app-field">
        <label class="app-label">Email</label>
        <input name="email" type="email" oninput="validateInput(event, 'email')" class="app-input" placeholder="Enter your email" required>
        <span class="formerror" data-for="email"></span>
      </div>
      
      <div class="app-field">
        <label class="app-label">Contact</label>
        <input name="contact" type="number" oninput="validateInput(event, 'phone')" class="app-input" placeholder="Enter your contact" required>
        <span class="formerror" data-for="phone"></span>
      </div>
    
        <div class="app-field">
        <label class="app-label">Password</label>
        <input name="password" type="password" class="app-input" placeholder="Create password" required>
      </div>
    
        <div class="app-field">
        <label class="app-label">Team Type</label>
        <select name="team_type" class="app-input" required>
          <option value="">Select Team Type</option>
          <option value="Corporate">Corporate</option>
          <option value="Trade">Trade</option>
          <option value="Upcountry">Upcountry</option>
          <option value="PSU">PSU</option>
          <option value="Activation Team">Activation Team</option>
          <option value="Support Office">Support Office</option>
        </select>
      </div>
    
        <div class="app-field">
        <label class="app-label">Company Name</label>
        <input name="farm_name" type="text" class="app-input" placeholder="Enter company name" required>
      </div>

    <button class="app-btn">Sign up</button>
    </form>
      <p class="app-center app-small" style="margin-top:15px;">
        Already have an account? <a href="<?php echo base_url();?>login" class="app-primary">Sign In</a>
      </p>
    </div>
</div>
<?php $this->load->view('common/form-script'); ?>
<style>
    .app-phone {
    width: 100%;
    }
      .formerror{
      color:red;
  }
</style>

<style>
.welcome-page {
    height: 100%;
}

.app-phone {
    height: 100%;
    overflow-y: auto; 
    -webkit-overflow-scrolling: touch;
}

.app-input {
    font-size: 16px;
}
</style>
