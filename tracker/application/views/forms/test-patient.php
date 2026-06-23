<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />

<div class="main-div">
  <div class="profile-wrapper">
    <h4 class="profile-title">IPD / OPD / HC</h4>

    <form method="POST" action="<?php echo base_url('home/save_test'); ?>">

      <!-- TYPE -->
      <div class="mb-3">
        <label class="form-label">IPD / OPD / HC</label>
        <select class="form-control" name="type" required>
          <option value="">Select</option>
          <option value="IPD">IPD</option>
          <option value="OPD">OPD</option>
          <option value="Healthcare">Healthcare</option>
        </select>
      </div>

      <!-- PATIENT NAME -->
      <div class="mb-3">
        <label class="form-label">Patient Name</label>
        <input type="text" name="p_name" class="form-control" required>
      </div>

      <!-- CONTACT -->
      <div class="mb-3">
        <label class="form-label">Patient Contact</label>
        <input type="text" name="p_contact" class="form-control" required>
      </div>
      
    <!-- Referred By -->
    <div class="mb-3">
      <label class="form-label">Referred By</label>
      <div>
        <input type="radio" name="ref_by" value="poc" id="refPoc">
        <span class="form-label">POC</span>
    
        <input type="radio" name="ref_by" value="doctor" id="refDoctor" class="ms-3">
        <span class="form-label">Doctor</span>
      </div>
    </div>
    
    <div id="docSection" class="d-none mt-3"> 
       <!-- Profile Name -->
        <input type="hidden" name="poc_type[]" value="Doctor">
            <div class="mb-3">
              <label class="form-label">Doctor Name</label>
              <input type="text" name="poc_name[]" oninput="validateInput(event, 'name')" class="form-control custom-input" >
              <span class="formerror" data-for="name"></span>
            </div>
        
            <!-- POC Contact -->
            <div class="mb-3">
              <label class="form-label">Doctor Contact</label>
              <input type="number" name="poc_contact[]" oninput="validateInput(event, 'phone')" class="form-control custom-input" >
               <span class="formerror" data-for="phone"></span>
            </div> 
    </div>    

    <div id="pocSection" class="d-none mt-3">
    
      <label class="form-label" >No of POC</label>
      <input type="number" id="pocCount" class="form-control mb-3">
    
      <div id="pocWrapper"></div>
    
    </div>

      <button type="submit" class="btn submit-btn">Submit</button>
    </form>
  </div>
</div>

<!-- JS -->
<script>
const refPoc = document.getElementById('refPoc');
const refDoctor = document.getElementById('refDoctor');
const pocSection = document.getElementById('pocSection');
const docSection = document.getElementById('docSection');
const pocCount = document.getElementById('pocCount');
const wrapper = document.getElementById('pocWrapper');

refPoc.onclick = () => {
    pocSection.classList.remove('d-none');
    docSection.classList.add('d-none');
}
refDoctor.onclick = () => {
    wrapper.innerHTML = pocSection.classList.add('d-none');
    docSection.classList.remove('d-none');
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
        <label class="form-label" >Type of POC</label>
        <select class="form-control pocType" name="poc_type[]">
          <option value="">Select</option>
          <option value="Corporate">Corporate</option>
          <option value="PSU">PSU</option>
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

      box.innerHTML = `
        <label class="form-label" >${name}</label>
         <select name="poc_name[]"
              class="form-control custom-input select2"
              id="profileId"
              onchange="getContactByProfileId(this.value)"
              >

        <option value="">Select POC Name</option>
        <?php foreach ($poc as $p) { ?>
          <option value="<?php echo $p->name; ?>">
            <?php echo $p->name; ?>
          </option>
        <?php } ?>
      </select>

        <label class="form-label mt-2">${contact}</label>
        <input type="text" name="poc_contact[]" oninput="validateInput(event, 'poc_contact')" class="form-control">
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

