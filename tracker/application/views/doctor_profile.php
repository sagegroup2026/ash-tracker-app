<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />

<div class="main-div">
  <div class="profile-wrapper">
    <h4 class="profile-title">Profile</h4>
    <?php if ($this->session->flashdata('register-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('register-message'); ?>
    </div>         
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data" action="<?php echo base_url('save-profile'); ?>">

      <input type="hidden" name="location" id="location">
      
       <!-- Profile Type -->
        <div class="mb-2">
          <label class="form-label">Profile Type<span class="required-star"> *</span></label>
          <select class="form-control" name="profile_type" onchange="toggleForm(this.value)" required>
            <option value="">Select Profile</option>
            <option value="doctor">Doctor</option>
            <option value="pharmacy">Pharmacy</option>
            <option value="lab">Lab</option>
            <option value="hr">HR</option>
            <option value="apartment">Apartment</option>
            <option value="clubs">Clubs</option>
            <option value="society">Society</option>
            <!--<option value="visiting-consultant">Visiting Consultant</option>-->
          </select>
          <small class="form-label" >Select the category of the person (Doctor / Pharmacy / Lab, etc.)</small>
        </div>

      <!-- Profile Name -->
      <div class="mb-3">
        <label class="form-label">Name<span class="required-star"> *</span></label>
        <input type="text" oninput="validateInput(event, 'name')" name="name"  class="form-control custom-input" placeholder="Enter the full name" required>
        <span class="formerror" data-for="name"></span>
      </div>
      
      <!-- Number -->
      <div class="mb-3">
        <label class="form-label">Contact<span class="required-star"> *</span></label>
        <input type="number" oninput="validateInput(event, 'phone')" name="contact" data-type="patient" class="form-control custom-input checkMobile" placeholder="Enter the active mobile number for communication" required>
        <span class="formerror" data-for="phone"></span>
      </div>
      
      <!-- Profile Address -->
      <div class="mb-3">
        <label class="form-label">Address<span class="required-star"> *</span></label>
        <input type="text" name="address" class="form-control custom-input" required>
      </div>
      
      <!-- Pincode Address -->
      <div class="mb-3">
        <label class="form-label">Pincode<span class="required-star"> *</span></label>
        <input type="number" oninput="validateInput(event, 'pincode')" name="pincode" class="form-control custom-input" required>
        <span class="formerror" data-for="pincode"></span>
      </div>
      
      <!-- DOCTOR ONLY FIELDS -->
      <div class="doctor-fields" style="display:none;">
              <div class="mb-2">
                <label class="form-label">Degree<span class="required-star"> *</span></label>
                <input type="text" name="degree" class="form-control custom-input" required>
              </div>
        
              <div class="mb-2">
                <label class="form-label">Specialty<span class="required-star"> *</span></label>
                <input type="text" name="specialty" class="form-control custom-input" required>
              </div>
        
              <div class="mb-2">
                <label class="form-label">Years of Practice<span class="required-star"> *</span></label>
                <input type="number" name="experience" class="form-control custom-input" required>
              </div>
        
              <div class="row g-2">
                <div class="col-6">
                  <label class="form-label">DOB</label>
                  <input type="date" name="dob" class="form-control custom-input" data-optional="true">
                </div>
                <div class="col-6">
                  <label class="form-label">DOA</label>
                  <input type="date" name="doa" class="form-control custom-input" data-optional="true">
                </div>
              </div>
              
              <div class="mb-2 mt-2">
                <label class="form-label">First Interacting Date<span class="required-star"> *</span></label>
                <input type="date" name="first_follow_up_date" class="form-control custom-input" required>
                <small class="form-label" >Select the date when you first interacted with the doctor.</small>
              </div>
        
              <div class="mb-2">
                <label class="form-label">Other Details</label>
                <textarea class="form-control" name="other_detail" rows="2" ></textarea>
                <small class="form-label" >You may add any additional information or important observations here.</small>
              </div>
        
              <div class="row g-2">
                <div class="col-6">
                  <label class="form-label">OPD / Month<span class="required-star"> *</span></label>
                  <input type="number" name="opd" class="form-control custom-input" required>
                </div>
                <div class="col-6">
                  <label class="form-label">IPD / Month<span class="required-star"> *</span></label>
                  <input type="number"name="ipd" class="form-control custom-input" required>
                </div>
              </div>
              
              <div class="mb-2">
                <label class="form-label">Doctor Grade<span class="required-star"> *</span></label>
                <input type="text" name="dr_grade" class="form-control custom-input" required>
              </div>

            <div class="mt-3">
            <label class="fw-bold mb-2">Social Media Connectivity<span class="required-star"> *</span></label>
        
            <div class="row g-3">
        
                <!-- WhatsApp -->
                <div class="col-12">
                    <label class=" fw-semibold form-label d-block">WhatsApp</label>
                    <div>
                        <input type="radio" name="whatsapp" value="connected" required> <span class="form-label">Connected</span> 
                        <input type="radio" name="whatsapp" value="not_connected" class="ms-3"> <span class="form-label">Not Connected</span>
                        <input type="radio" name="whatsapp" value="request_sent" class="ms-3"> <span class="form-label">Request Sent</span>
                    </div>
                </div>
        
                <!-- Facebook -->
                <div class="col-12">
                    <label class=" fw-semibold form-label d-block">Facebook</label>
                    <div>
                        <input type="radio" name="facebook" value="connected" required> <span class="form-label">Connected</span> 
                        <input type="radio" name="facebook" value="not_connected" class="ms-3"> <span class="form-label">Not Connected</span>
                        <input type="radio" name="facebook" value="request_sent" class="ms-3"><span class="form-label">Request Sent</span> 
                    </div>
                </div>
        
                <!-- Instagram -->
                <div class="col-12">
                    <label class=" fw-semibold form-label d-block">Instagram</label>
                    <div>
                        <input type="radio" name="instagram" value="connected" required> <span class="form-label">Connected</span> 
                        <input type="radio" name="instagram" value="not_connected" class="ms-3"> <span class="form-label">Not Connected</span>
                        <input type="radio" name="instagram" value="request_sent" class="ms-3"> <span class="form-label">Request Sent</span>
                    </div>
                </div>
        
                <!-- LinkedIn -->
                <div class="col-12">   
                    <label class=" fw-semibold form-label d-block">LinkedIn</label>
                    <div>
                        <input type="radio" name="linkedin" value="connected" required> <span class="form-label">Connected</span> 
                        <input type="radio" name="linkedin" value="not_connected" class="ms-3"> <span class="form-label">Not Connected</span>
                        <input type="radio" name="linkedin" value="request_sent" class="ms-3"> <span class="form-label">Request Sent</span>
                    </div>
                </div>
        
            </div>
            
            
        </div>
            
            <hr>
            
            <!-- Hospital Onboard -->
          <div class="mb-3">
            <label class="form-label">Hospital Onboarded<span class="required-star"> *</span></label>
            <input type="number" name="h_onboard" id="h_onboard" class="form-control custom-input" min="0" required>
            <small class="form-label" >Please mention whether the hospital/clinic is onboarded.</small>
          </div>
    
          <!-- Dynamic Hospital Fields -->
          <div id="hospitalFields"></div>
          
          <hr>
     </div>
     
         <!-- HR ONLY FIELD -->
       <div class="hr-fields" style="display:none;">
            <div class="mb-2">
                <label class="form-label" id="nameLabel">Company Name<span class="required-star"> *</span></label>
                <input type="text" name="company_name" class="form-control custom-input" required>
            </div>
        </div>
        <!-- HR ONLY FIELD -->



      <!-- No. of Employees -->
      <div class="mb-3">
        <label class="form-label">No. of Employees<span class="required-star"> *</span></label>
        <input type="number" name="emp_no" class="form-control custom-input" required>
      </div>

      <hr>
      
      <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" name="is_poc" id="is_poc" value="1">
        <span class="form-label">&#32; Set as Point of Contact </span>
      </div> 

     <hr>
      <!-- No. of POC -->
      <div class="mb-3">
        <label class="form-label">No. of POC<span class="required-star"> *</span></label>
        <input type="number" name="poc_no" id="poc_no" class="form-control custom-input" min="1" required>
        <small class="form-label" >Please select the number of key contacts available at this hospital/clinic.</small>
      </div>

      <!-- Dynamic POC Fields -->
      <div id="pocFields"></div>
    
        <!-- Validity Date -->
        <div class="row g-3 mb-3"> 
          <div class="col-6">
           <label class="form-label">Valid From<span class="required-star validity-star"> *</span></label>
          <input type="date" id="valid_from" name="valid_from" class="form-control custom-input common-date" required>
          </div>
          <div class="col-6">
            <label class="form-label">Valid Up To<span class="required-star validity-star"> *</span></label>
          <input type="date" id="valid_to" name="valid_to" class="form-control custom-input common-date date-no-past" required>
          </div>
        </div>
        
      <div class="mt-4">
        <button type="submit" id="submitBtn" class="btn submit-btn">Submit</button>
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
<script>

/* REQUIRED TOGGLE */
function toggleRequired(container, enable) {
  const fields = container.querySelectorAll('input, textarea, select');

  fields.forEach(el => {

    // Skip optional fields like DOB & DOA
    if (el.dataset.optional === 'true') {
      el.removeAttribute('required');
      return;
    }

    enable
      ? el.setAttribute('required', 'required')
      : el.removeAttribute('required');
  });
}


/* ================= POC FIELDS ================= */
document.getElementById('poc_no').addEventListener('input', function () {
  let count = parseInt(this.value) || 0;
  let container = document.getElementById('pocFields');
  container.innerHTML = '';

  for (let i = 1; i <= count; i++) {
    container.innerHTML += `
      <hr>
      <h6>POC ${i}</h6>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label class="form-label">POC Name<span class="required-star"> *</span></label>
          <input type="text" oninput="validateInput(event, 'poc_name')" name="poc_name[]" class="form-control custom-input" required>
          <small class="form-label">Kindly enter the full name of the point of contact.</small><br>
          <span class="formerror" data-for="poc_name"></span>
        </div>

        <div class="col-md-12 mb-3">
          <label class="form-label">POC Designation<span class="required-star"> *</span></label>
          <input type="text" name="poc_designation[]" class="form-control custom-input" required>
          <small class="form-label" >Please mention the designation (e.g., Receptionist, Manager, Coordinator, Nurse, Admin).</small>
        </div>

        <div class="col-md-12 mb-3">
          <label class="form-label">POC Contact<span class="required-star"> *</span></label>
          <input type="text" name="poc_contact[]"  data-type="poc" oninput="validateInput(event, 'poc_contact')" class="form-control custom-input checkMobile" required>
          
          <span class="formerror" data-for="poc_contact"></span>
        </div>
      </div>
    `;
  }
});

/* ================= HOSPITAL FIELDS ================= */
document.getElementById('h_onboard').addEventListener('input', function () {
  let count = parseInt(this.value) || 0;
  let container = document.getElementById('hospitalFields');
  container.innerHTML = '';

  for (let i = 1; i <= count; i++) {
    container.innerHTML += `
      <hr>
      <h6>Hospital ${i}</h6>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label class="form-label">Hospital Name<span class="required-star"> *</span></label>
          <input type="text" name="h_name[]" class="form-control custom-input">
        </div>

        <div class="col-md-12 mb-3">
          <label class="form-label">Hospital City<span class="required-star"> *</span></label>
          <input type="text" name="h_city[]" class="form-control custom-input">
        </div>
      </div>
    `;
  }
});

/* PROFILE TYPE TOGGLE */
function toggleForm(type) {
  const doctor = document.querySelector('.doctor-fields');
  const hr = document.querySelector('.hr-fields');
  const label = document.getElementById('nameLabel');
  const vf = document.getElementById('valid_from');
  const vt = document.getElementById('valid_to');
  const stars = document.querySelectorAll('.validity-star');

  doctor.style.display = 'none';
  hr.style.display = 'none';

  toggleRequired(doctor, false);
  toggleRequired(hr, false);

  if (type === 'doctor' || type === 'visiting-consultant') {
    vf.removeAttribute('required');
    vt.removeAttribute('required');
    stars.forEach(s => s.style.display = 'none');
  } else {
    vf.setAttribute('required', 'required');
    vt.setAttribute('required', 'required');
    stars.forEach(s => s.style.display = 'inline');
  }
  
  if (type === 'doctor' || type === 'visiting-consultant') {
    doctor.style.display = 'block';
    toggleRequired(doctor, true);
  }

  if (['hr','pharmacy','lab','apartment','clubs','society'].includes(type)) {
    hr.style.display = 'block';
    toggleRequired(hr, true);
    label.innerText = type === 'hr' ? 'Company Name' : type === 'pharmacy' ? 'Shop Name' : type === 'apartment' ? 'Apartment Name' : type === 'clubs' ? 'Club Name' : type === 'society' ? 'Society Name' : 'Lab Name';
  }
} 


/* ================= NEW: AUTO FILL POC IF "Set as POC" ================= */
// document.getElementById('is_poc').addEventListener('change', function () {
//     const isChecked = this.checked;
//     const pocNoInput = document.getElementById('poc_no');
//     const pocFieldsContainer = document.getElementById('pocFields');

//     if (isChecked) {
//         pocNoInput.value = 1;
//         pocFieldsContainer.innerHTML = `
//             <hr>
//             <h6>POC 1</h6>
//             <div class="row">
//                 <div class="col-md-12 mb-3">
//                     <label class="form-label">POC Name<span class="required-star"> *</span></label>
//                     <input type="text" name="poc_name[]" class="form-control custom-input" required value="${document.querySelector('input[name="name"]').value}">
//                 </div>
//                 <div class="col-md-12 mb-3">
//                     <label class="form-label">POC Designation<span class="required-star"> *</span></label>
//                     <input type="text" name="poc_designation[]" class="form-control custom-input" required value="Profile">
//                 </div>
//                 <div class="col-md-12 mb-3">
//                     <label class="form-label">POC Contact<span class="required-star"> *</span></label>
//                     <input type="text" name="poc_contact[]" class="form-control custom-input checkMobile" required value="${document.querySelector('input[name="contact"]').value}">
//                 </div>
//             </div>
//         `;
//     } else {
//         pocNoInput.value = '';
//         pocFieldsContainer.innerHTML = '';
//     }
// });

const pocCheckbox = document.getElementById('is_poc');
const pocNoField = document.getElementById('poc_no');
const pocFieldsContainer = document.getElementById('pocFields');

function togglePOCFields() {
    if (pocCheckbox.checked) {
        // Hide No. of POC input
        pocNoField.closest('.mb-3').style.display = 'none';
        // Clear any dynamic POC fields
        pocFieldsContainer.innerHTML = '';
        // Remove 'required' from POC number
        pocNoField.removeAttribute('required');
    } else {
        // Show No. of POC input
        pocNoField.closest('.mb-3').style.display = 'block';
        pocNoField.setAttribute('required', 'required');
    }
}

// Trigger on checkbox change
pocCheckbox.addEventListener('change', togglePOCFields);

// Trigger once on page load
togglePOCFields();

</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
let mobileTimer = null;

$(document).on('input', '.checkMobile', function () {

    const input     = this;
    const mobile    = input.value.trim();
    const submitBtn = document.getElementById('submitBtn');
    const errorEl   = input.nextElementSibling;

    errorEl.textContent = '';
    errorEl.style.color = '#dc3545';
    input.classList.remove('is-invalid');
    submitBtn.disabled = false;

    if (!/^\d{10}$/.test(mobile)) {
        submitBtn.disabled = true;
        return;
    }

    clearTimeout(mobileTimer);

    mobileTimer = setTimeout(() => {
        $.ajax({
            url: "<?= base_url('ajax/check-mobile-exists') ?>",
            type: "POST",
            data: { mobile: mobile },
            dataType: "json",
            success: function (res) {
                if (res.exists) {
                    errorEl.textContent = res.message;
                    input.classList.add('is-invalid');
                    submitBtn.disabled = true;
                } else {
                    submitBtn.disabled = false;
                }
            }
        });
    }, 400);
});
</script>


<script src="<?php echo base_url();?>assets/scripts/fetch_location.js"></script>
