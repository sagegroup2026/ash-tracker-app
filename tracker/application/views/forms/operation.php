<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<div class="main-div">
    <div class="profile-wrapper">
  <h4 class="profile-title">Agreement Preparation</h4>
    <?php if ($this->session->flashdata('register-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('register-message'); ?>
    </div>         
    <?php endif; ?>
  <form method="POST" enctype="multipart/form-data"
        action="<?php echo base_url('save-operation'); ?>">
      
    <!-- Hospital Onboard -->
    <div class="mb-3">
      <label class="form-label">Type of Operation<span class="required-star"> *</span></label>
      <input type="text" name="operation_type" class="form-control custom-input" required>
    </div>
    
     <!-- Profile Name -->
    <div class="mb-3">
      <label class="form-label">Date<span class="required-star"> *</span></label>
      <input type="date" name="operation_date" class="form-control custom-input common-date default-today date-no-past" required>
    </div>
    
    <!-- time -->
    <div class="row g-3 mb-3">
      <!--<label class="form-label">Time</label>-->
      <div class="col-6">
          <!--<label class="form-label">Time</label> <br>-->
       <label class="form-label">From Time<span class="required-star"> *</span></label>
      <input type="time" name="from_time" class="form-control custom-input" required>
      </div>
      <div class="col-6">
        <label class="form-label">To Time<span class="required-star"> *</span></label>
      <input type="time" name="to_time" class="form-control custom-input" required>
      </div>
    </div>
    
    

    <div class="">
      <button type="submit" class="btn submit-btn">Submit</button>
    </div>

  </form>
</div>
</div>