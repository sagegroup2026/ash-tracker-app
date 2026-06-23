<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<div class="main-div">
    <div class="profile-wrapper">
  <h4 class="profile-title">Healthcare</h4>

  <form method="POST" enctype="multipart/form-data"
        action="<?php echo base_url('save-healthcare'); ?>">
      
    <!-- Patient Name -->
    <div class="mb-3">
      <label class="form-label">Name of Patient</label>
      <input type="text" name="patient_name" class="form-control custom-input">
    </div>
    
    <!-- Referred By Name -->
    <div class="mb-3">
      <label class="form-label">Referred By</label>
      <input type="text" name="ref_by" class="form-control custom-input">
    </div>
    
    <!-- Date-->
    <div class="mb-3">
      <label class="form-label">Date</label>
      <input type="date" name="given_date" class="form-control custom-input">
    </div>
    
     <!-- Profile Name -->
    <div class="mb-3">
      <label class="form-label">IPD/OPD/HC</label>
      <select class="form-control" name="type"  required>
        <option value="">Select</option>
        <option value="IPD">IPD</option>
        <option value="OPD">OPD</option>
        <option value="Healthcare">HealthCare</option>
      </select>
    </div>
    

    <div class="">
      <button type="submit" class="btn submit-btn">Submit</button>
    </div>

  </form>
</div>
</div>