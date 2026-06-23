<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<div class="main-div">
    <div class="profile-wrapper">
  <h4 class="profile-title">IPD/OPD/HC</h4>
    <?php if ($this->session->flashdata('register-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('register-message'); ?>
    </div>         
    <?php endif; ?>
  <form method="POST" enctype="multipart/form-data"
        action="<?php echo base_url('test-save-patient'); ?>">
    
     <!-- Profile Name -->
    <div class="mb-3">
      <label class="form-label">IPD/OPD/HC<span class="required-star"> *</span></label>
      <select class="form-control" name="type"  required>
        <option value="">Select</option>
        <option value="IPD">IPD</option>
        <option value="OPD">OPD</option>
        <option value="IPD+OPD">IPD + OPD</option>
        <option value="Healthcheckup">Health Checkup</option>
      </select>
    </div>
    

<!-- Profile Type -->
        <div class="mb-2">
          <label class="form-label">Team Name<span class="required-star"> *</span></label>
          <select class="form-control" name="t_name"required>
            <option value="">Select Team Name</option>
            <option value="Corporate">Corporate</option>
            <option value="Trade">Trade</option>
            <option value="Upcountry">Upcountry</option>
            <option value="PSU">PSU</option>
            <option value="Support">Support</option>
          </select>
        </div>
        
        
    <!-- Patient Name -->
    <div class="mb-3">
      <label class="form-label">Patient Name<span class="required-star"> *</span></label>
      <input type="text" name="p_name" oninput="validateInput(event, 'name')" class="form-control custom-input" placeholder="Enter Patient's Full Name" required>
      <span class="formerror" data-for="name"></span>
    </div>

    <!-- Patient Contact -->
    <div class="mb-3">
      <label class="form-label">Patient Contact</label>
      <input type="text" name="p_contact" oninput="validateInput(event, 'phone')" class="form-control custom-input" placeholder="Enter Patient's Contact" >
      <span class="formerror" data-for="phone"></span>
    </div>
<div class="d-flex align-items-center my-3">
    <hr class="flex-grow-1">
    <span class="mx-2 form-label">Referred By</span>
    <hr class="flex-grow-1">
</div>
    
    <!-- POC Select Type -->
    <!-- TYPE -->
    <div class="mb-3">
      <label class="form-label">Profile Type <span class="required-star"> *</span></label>
        <?php 
            $this->config->load('custom_config');
            $profiletypes = $this->config->item('profiletype');
        ?>
        <select class="form-control" name="ref_by" onchange="getProfileByType(this.value)" required>
        <option value="">Select Profile</option>
    
        <?php foreach($profiletypes as $key => $value){ ?>
            <option value="<?= $key ?>"><?= $value ?></option>
        <?php } ?>
    
        <option value="other">Other</option>
        </select>
    </div>
    
    <!-- PROFILE NAME -->
    <div class="mb-3">
        <label class="form-label pName">Profile Name <span class="required-star"> *</span></label>
        <select class="form-control pName" name="profile_id" id="profileName" onchange="getPocByProfile(this.value)" required>
            <option value="">Select Profile Name</option>
        </select>
    </div>
    
    <!-- POC NAME -->
    <div class="mb-3">
        <label class="form-label pName">POC Name <span class="required-star"> *</span></label>
        <select class="form-control pName" name="poc_id" id="pocName" required>
            <option value="">Select POC Name</option>
        </select>
    </div>
    
    <!-- Other Inpts -->
    <div id="otherFields" style="display:none;" class="mt-3"> 
       
            <div class="mb-3">
              <label class="form-label">Name<span class="required-star"> *</span></label>
              <input type="text" name="other_name" oninput="validateInput(event, 'poc_name')" class="form-control custom-input" >
              <span class="formerror" data-for="poc_name"></span>
            </div>
        
            
            <div class="mb-3">
              <label class="form-label">Contact<span class="required-star"> *</span></label>
              <input type="number" name="other_contact" oninput="validateInput(event, 'mobile')" class="form-control custom-input" >
               <span class="formerror" data-for="mobile"></span>
            </div> 
            
            <div class="mb-3">
                <label class="form-label">Comment</label>
                <textarea name="other_comment" class="form-control"></textarea>
            </div>
    </div>   


    
    <div class="">
      <button type="submit" class="btn submit-btn">Submit</button>
    </div>

  </form>
</div>
</div>
<?php $this->load->view('common/form-script'); ?>
<style>
    .formerror{
        color:red;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
/* -------- GET PROFILE BY TYPE -------- */
function getProfileByType(profileType){
    // OTHER SELECTED
    if(profileType === 'other'){
        $('#otherFields').show();
        $('.pName').hide().removeAttr('required');
        return;
    }
    
    $('#otherFields').hide();
    $('.pName').show().attr('required', true);

    $.ajax({
        url: "<?= base_url('get-profilename-by-type') ?>",
        type: "POST",
        data: { profile_type: profileType },

        success: function (response) {
            let data = JSON.parse(response);
            $('#profileName').html('<option value="">Select Profile Name</option>');
            $('#pocName').html('<option value="">Select POC Name</option>');

            data.forEach(function (item) {
                $('#profileName').append(
                    '<option value="'+item.profile_id+'">'+item.name+'</option>'
                );
            });
        }
    });
}


/* -------- GET POC BY PROFILE -------- */
function getPocByProfile(profileId){
    if(profileId === ''){
        $('#pocName').html('<option value="">Select POC Name</option>');
        return;
    }

    $.ajax({
        url: "<?= base_url('get-pocname-by-profile') ?>",
        type: "POST",
        data: { profile_id: profileId },

        success: function (response) {

            let data = JSON.parse(response);

            $('#pocName').html('<option value="">Select POC Name</option>');

            if(data.length === 0){
                $('#pocName').append('<option value="self">Self</option>');
                return;
            }

            data.forEach(function (poc) {
                $('#pocName').append(
                    '<option value="'+poc.id+'">'+poc.poc_name+'</option>'
                );
            });
        }
    });
}
</script>





<script>
const refPoc = document.getElementById('refPoc');
const refDoctor = document.getElementById('refDoctor');
const pocSection = document.getElementById('pocSection');
const docSection = document.getElementById('docSection');
const pocCount = document.getElementById('pocCount');
const wrapper = document.getElementById('pocWrapper');
const doctorName = document.getElementById('doctorName');
const doctorContact = document.getElementById('doctorContact');

refPoc.onclick = () => {
    pocSection.classList.remove('d-none');
    docSection.classList.add('d-none');
    // POC count REQUIRED
    pocCount.setAttribute('required', true);
    // Doctor fields NOT required
    doctorName.removeAttribute('required');
    doctorContact.removeAttribute('required');
}
refDoctor.onclick = () => {
    // wrapper.innerHTML = pocSection.classList.add('d-none');
    pocSection.classList.add('d-none');
    docSection.classList.remove('d-none');
     // POC count NOT required
    pocCount.removeAttribute('required');
    pocCount.value = '';
    
    // Doctor fields REQUIRED
    doctorName.setAttribute('required', true);
    doctorContact.setAttribute('required', true);
}

pocCount.oninput = () => {
  wrapper.innerHTML = '';
  let count = pocCount.value;
  if (count < 1) return;

  for (let i = 1; i <= count; i++) {
    wrapper.innerHTML += `
      <div class="border p-3 mb-3">
        <b class="form-label">POC ${i}</b>
        <br>
        <label class="form-label" >Type of POC<span class="required-star"> *</span></label>
        <select class="form-control pocType" name="poc_type[]" required>
            <option value="">Select</option>
            <option value="doctor">Doctor</option>
            <option value="pharmacy">Pharmacy</option>
            <option value="lab">Lab</option>
            <option value="hr">HR</option>
            <option value="apartment">Apartment</option>
            <option value="clubs">Clubs</option>
            <option value="society">Society</option>
          <option value="Others">Others</option>
        </select>

        <div class="fields mt-2"></div>
      </div>
    `;
  }

  document.querySelectorAll('.pocType').forEach(select => {
    select.onchange = function () {
      let box = this.nextElementSibling;
      let type = this.value;
      if (!type) return;

      let name = type === 'Corporate' ? 'Corporate Name'
              : type === 'PSU' ? 'PSU Name' : 'Name';

      let contact = type === 'Corporate' ? 'Corporate Contact'
                  : type === 'PSU' ? 'PSU Contact' : 'Contact';

    //   box.innerHTML = `
    //     <label class="form-label" >${name}<span class="required-star"> *</span></label>
    //      <select name="poc_name[]"
    //           class="form-control custom-input select2"
    //           id="profileId"
    //           onchange="getContactByProfileId(this.value)"
    //           required>

    //     <option value="">Select POC Name<span class="required-star"> *</span></option>
    //     <?php foreach ($poc as $p) { ?>
    //       <option value="<?php echo $p->name; ?>">
    //         <?php echo $p->name; ?>
    //       </option>
    //     <?php } ?>
    //   </select>

    //     <label class="form-label mt-2">${contact}<span class="required-star"> *</span></label>
    //     <input type="text" name="poc_contact[]" oninput="validateInput(event, 'poc_contact')" class="form-control" >
    //     <span class="formerror" data-for="poc_contact"></span>
    //     ${type === 'Others' ? `
    //       <label class="form-label mt-2">Comment</label>
    //       <textarea name="poc_comment[]" class="form-control"></textarea>
    //     ` : ''}
    //   `;
    
    let nameField = '';

    if (type === 'Others') {
      nameField = `
        <label class="form-label">${name}<span class="required-star"> *</span></label>
        <input type="text"
               name="poc_name[]"
               class="form-control"
               required>
      `;
    } else {
      nameField = `
        <label class="form-label">${name}<span class="required-star"> *</span></label>
        <select name="poc_name[]"
                class="form-control custom-input select2"
                onchange="getContactByProfileId(this.value)"
                required>
          <option value="">Select POC Name</option>
          <?php foreach ($poc as $p) { ?>
            <option value="<?php echo $p->name; ?>">
              <?php echo $p->name; ?>
            </option>
          <?php } ?>
        </select>
      `;
    }
    
    box.innerHTML = `
      ${nameField}
    
      <label class="form-label mt-2">${contact}<span class="required-star"> *</span></label>
      <input type="text"
             name="poc_contact[]"
             oninput="validateInput(event, 'poc_contact')"
             class="form-control"
             required>
      <span class="formerror" data-for="poc_contact"></span>
    
      ${type === 'Others' ? `
        <label class="form-label mt-2">Comment</label>
        <textarea name="poc_comment[]" class="form-control"></textarea>
      ` : ''}
    `;

    };
  });
};



</script>

