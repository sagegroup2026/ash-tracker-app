<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<?php $this->load->view('common/form-script'); ?>
<style>
    .formerror{
        color:red;
    }
</style>
<div class="main-div">
    <div class="profile-wrapper">
  <h4 class="profile-title">Booking</h4>
    <?php if ($this->session->flashdata('register-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('register-message'); ?>
    </div>         
    <?php endif; ?>
  <form method="POST" enctype="multipart/form-data"
        action="<?php echo base_url('save-booking'); ?>">
      
    <!-- Hospital Onboard -->
    <div class="mb-3">
      <label class="form-label">Customer Name<span class="required-star"> *</span></label>
      <input type="text" name="customer_name" oninput="validateInput(event, 'name')" class="form-control custom-input" required>
      <span class="formerror" data-for="name"></span>
    </div>
    
    <!-- Referred By -->
    <div class="mb-3">
      <label class="form-label">Lead/Confirmed<span class="required-star"> *</span></label>
      <div>
        <input type="radio" name="lead_or_comfirmed" value="lead" id="refPoc">
        <span class="form-label">Lead</span>
    
        <input type="radio" name="lead_or_comfirmed" value="Booked" id="refDoctor" class="ms-3">
        <span class="form-label">Confirmed Booking</span>
      </div>
    </div>
     
    <!-- Project Name -->
    <div class="mb-3">
      <label class="form-label">Project Name<span class="required-star"> *</span></label>
      <input type="text" name="project_name" class="form-control custom-input" required> 
    </div>
    
    <!-- Deal By -->
    <div class="mb-3">
      <label class="form-label">Deal By<span class="required-star"> *</span></label>
      <input type="text" name="deal_by" oninput="validateInput(event, 'team_name')" class="form-control custom-input" required>
            <span class="formerror" data-for="team_name"></span>

    </div>
    
     <!-- Date Name -->
    <div class="mb-3">
      <label class="form-label">Date<span class="required-star"> *</span></label>
      <input type="date" name="given_date" class="form-control custom-input default-today common-date" required>
    </div>
    

    <div class="">
      <button type="submit" class="btn submit-btn">Submit</button>
    </div>

  </form>
</div>
</div>