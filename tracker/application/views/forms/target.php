<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<div class="main-div">
    <div class="profile-wrapper">
  <h4 class="profile-title">Monthly Target</h4>
     <?php if ($this->session->flashdata('login-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('login-message'); ?>
    </div>         
<?php endif; ?>
  <form method="POST" action="<?php echo base_url('save-target'); ?>">

    <!-- Row 1 -->
    <div class="row g-3">
      <div class="col-6">
        <label class="form-label">Healthcheckup<span class="required-star"> *</span></label>
        <input type="number" name="healthcheckup" class="form-control custom-input" required>
      </div>
      <div class="col-6">
        <label class="form-label">OPD<span class="required-star"> *</span></label>
        <input type="number" name="opd" class="form-control custom-input" required>
      </div>
    </div>

    <!-- Row 2 -->
    <div class="row g-3 mt-1">
      <div class="col-6">
        <label class="form-label">IPD<span class="required-star"> *</span></label>
        <input type="number" name="ipd" class="form-control custom-input" required>
      </div>
      <div class="col-6">
        <label class="form-label">Booking<span class="required-star"> *</span></label>
        <input type="number" name="booking" class="form-control custom-input" required>
      </div>
    </div>   
 
    <!-- Row 3 -->
    <div class="row g-3 mt-1">
      <div class="col-6">
        <label class="form-label">Admission<span class="required-star"> *</span></label>
        <input type="number" name="admission" class="form-control custom-input" required>
      </div>
      <div class="col-6">
        <label class="form-label">Profile Created<span class="required-star"> *</span></label>
        <input type="number" name="profile_created" class="form-control custom-input" required>
      </div>
    </div>

    <!-- Row 4 -->
    <div class="row g-3 mt-1">
      <div class="col-6">
        <label class="form-label">POC Onboard<span class="required-star"> *</span></label>
        <input type="number" name="poc_onboard" class="form-control custom-input" required>
      </div>
      <div class="col-6">
        <label class="form-label">Visit<span class="required-star"> *</span></label>
        <input type="number" name="visit" class="form-control custom-input" required>
      </div>
    </div>

    
    
    <div class="mt-4">
      <button type="submit" class="btn submit-btn">Save Target</button>
    </div>

  </form>
</div>
</div>


