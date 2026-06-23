<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<?php $this->load->view('common/form-script'); ?>
<style>
    .formerror{
        color:red;
    }
</style>
<div class="main-div">
    <div class="profile-wrapper">
  <h4 class="profile-title">Admission</h4>
<?php if ($this->session->flashdata('register-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('register-message'); ?>
    </div>         
    <?php endif; ?>
  <form method="POST" enctype="multipart/form-data"
        action="<?php echo base_url('save-admission'); ?>">
      
    <!-- Student Name -->
    <div class="mb-3">
      <label class="form-label">Student Name<span class="required-star"> *</span></label>
      <input type="text" name="student_name" oninput="validateInput(event, 'name')" class="form-control custom-input" required>
      <span class="formerror" data-for="name"></span>
    </div>

    <!-- Father's Name -->
    <div class="mb-3">
      <label class="form-label">Father's Name<span class="required-star"> *</span></label>
      <input type="text" name="f_name" oninput="validateInput(event, 'team_name')" class="form-control custom-input" required>
              <span class="formerror" data-for="team_name"></span>
    </div>
    
     <!-- Profile Name -->
    <div class="mb-3">
      <label class="form-label">Institute/School Name<span class="required-star"> *</span></label> 
      <select class="form-control" name="vertical"  required>
        <option value="">Select Institute/School Name</option>
        <option value="SIS-AN">SIS-AN</option>
        <option value="SIS-DK">SIS-DK</option>
        <option value="SUI">SUI</option>
        <option value="SUB">SUB</option> 
        <option value="SIRT">SIRT</option>
        <option value="SIRTE">SIRTE</option>
        <option value="SIRTP">SIRTP</option>
        <option value="SIRTSP">SIRTSP</option>
      </select>
    </div>
    
    <div class="mb-3">
       <label class="form-label">Class/Branch<span class="required-star"> *</span></label>
       <input type="text" name="branch" class="form-control custom-input" required>
    </div>
    
    <!-- Referred By -->
    <div class="mb-3">
      <label class="form-label">Lead<span class="required-star"> *</span></label> 
      <div>
        <input type="radio" name="lead_or_comfirmed" value="lead" id="refPoc">
        <span class="form-label">lead</span>
    
        <input type="radio" name="lead_or_comfirmed" value="done" id="refDoctor" class="ms-3">
        <span class="form-label">Confirmed Admission</span>
      </div>
    </div>
    
    <div class="mb-3">
       <label class="form-label">Referred To<span class="required-star"> *</span></label>
       <input type="text" name="ref_to" oninput="validateInput(event, 'poc_name')" class="form-control custom-input" required>
             <span class="formerror" data-for="poc_name"></span>

    </div>
 
    <div class="">
      <button type="submit" class="btn submit-btn">Submit</button>
    </div>

  </form>
</div>
</div>