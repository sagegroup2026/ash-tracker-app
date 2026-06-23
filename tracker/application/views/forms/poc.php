<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<div class="main-div">
    <div class="profile-wrapper">
      <h4 class="profile-title">Point of Contact</h4>
        <?php if ($this->session->flashdata('login-message')): ?>
        <div class="mb-2" id="login-alert">
            <?= $this->session->flashdata('login-message'); ?>
        </div>         
        <?php endif; ?>
      <form method="POST" enctype="multipart/form-data"
            action="<?php echo base_url('save-poc'); ?>">
          
        <!-- PROFILE ID -->
        <div class="mb-2">
          <label class="form-label">Profile ID</label>
          <input type="text" id="profileId" name="p_id" class="form-control" readonly>
        </div>
        
        <!-- PROFILE NAME -->
        <div class="mb-2 relative">
          <label class="form-label">Profile Name<span class="required-star"> *</span></label>
          <input type="text" name="profile_name" id="profileNameInput" class="form-control" autocomplete="off">
          <div id="nameSuggest" class="autocomplete-box" style="display:none;"></div>
        </div>
     
        <!-- CONTACT -->
        <div class="mb-2 relative">
          <label class="form-label">Contact Number<span class="required-star"> *</span></label>
          <input type="text" name="contact" id="contactInput" class="form-control" autocomplete="off">
          <div id="contactSuggest" class="autocomplete-box" style="display:none;"></div>
        </div>
         <!-- PROFILE ID -->
        <!--<div class="mb-2">-->
        <!--  <label class="form-label">Profile Id</label>-->
        <!--  <select name="p_id"class="form-control  select2"-->
        <!--          id="profileId"-->
        <!--          onchange="getContactByProfileId(this.value)"-->
        <!--          required>-->
    
        <!--    <option value="">Select Profile ID</option>-->
        <!--        <?php foreach ($profile_id as $p) { ?>-->
        <!--      <option value="<?php echo $p->profile_id; ?>">-->
        <!--        <?php echo $p->profile_id; ?>-->
        <!--    </option>-->
        <!--    <?php } ?>-->
        <!--  </select>-->
        <!--</div>-->
    
        <!-- CONTACT -->
        <!--<div class="mb-2">-->
        <!--  <label class="form-label">Contact Number</label>-->
        <!--  <input type="text"-->
        <!--         id="contact"-->
        <!--         name="contact"-->
        <!--         class="form-control"-->
        <!--         oninput="handleContactInput(this)">-->
        <!--</div>-->
        
        <!-- Hospital Onboard -->
        <!--<div class="mb-3">-->
        <!--  <label class="form-label">Profile Id</label>-->
        <!--  <input type="text" name="p_id" class="form-control custom-input">-->
        <!--</div>-->
    
        <!-- Profile Name -->
        <div class="mb-3">
          <label class="form-label">Name<span class="required-star"> *</span></label>
          <input type="text" name="poc_name" oninput="validateInput(event, 'name')" class="form-control custom-input" required>
          <span class="formerror" data-for="name"></span>
        </div>
    
        <!-- POC Contact -->
        <div class="mb-3">
          <label class="form-label">POC Contact<span class="required-star"> *</span></label>
          <input type="number" name="poc_contact" oninput="validateInput(event, 'phone')" class="form-control custom-input" required>
           <span class="formerror" data-for="phone"></span>
        </div>
        
        <!-- POC Designation -->
        <div class="mb-3">
          <label class="form-label">POC Designation<span class="required-star"> *</span></label>
          <input type="text" name="poc_designation" class="form-control custom-input">
           <!--<span class="formerror" data-for="phone"></span>-->
        </div>
        
        <div class="d-grid">
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
<style>
.autocomplete-box{
  position: absolute;
  background:#fff;
  border:1px solid #ddd;
  width:100%;
  max-height:200px;
  overflow-y:auto;
  z-index:999;
}
.autocomplete-item{
  padding:8px 10px;
  cursor:pointer;
}
.autocomplete-item:hover{
  background:#f1f3f4;
}
.relative{ position:relative; }
</style>
<script>
let typingTimer;
let isSelected = false;
const delay = 300;

/* ================= CONTACT INPUT ================= */
$('#contactInput').on('input', function () {
    const val = $(this).val().trim();

    //  check section already selected or not
    if (isSelected) {
        isSelected = false;
        $('#profileId').val('');
        $('#profileNameInput').val(''); //  name clear
    }

    if (val.length === 0) {
        hideSuggestions();
        return;
    }

    debounceSearch(val, 'contact');
});

/* ================= PROFILE NAME INPUT ================= */
$('#profileNameInput').on('input', function () {
    const val = $(this).val().trim();

    if (isSelected) {
        isSelected = false;
        $('#profileId').val('');
        $('#contactInput').val(''); // contact clear
    }

    if (val.length === 0) {
        hideSuggestions();
        return;
    }

    debounceSearch(val, 'name');
});

/* ================= DEBOUNCE ================= */
function debounceSearch(val, type) {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => {
        const url = type === 'contact'
            ? "<?= base_url('home/searchContact') ?>"
            : "<?= base_url('home/searchProfileName') ?>";

        $.post(url, { keyword: val }, function (res) {
            if (type === 'contact') {
                renderSuggestions(res, '#contactSuggest', 'contact');
            } else {
                renderSuggestions(res, '#nameSuggest', 'name');
            }
        }, 'json');
    }, delay);
}

/* ================= RENDER ================= */
function renderSuggestions(data, boxId, type) {
    if (!data || data.length === 0) {
        $(boxId).hide().html('');
        return;
    }

    let html = '';
    data.forEach(item => {
        html += `
        <div class="autocomplete-item"
             data-profile="${item.profile_id}"
             data-contact="${item.contact}"
             data-name="${item.name}">
            ${type === 'contact' ? item.contact : item.name}
        </div>`;
    });

    $(boxId).html(html).show();
}

/* ================= SELECT ================= */
$(document).on('click', '.autocomplete-item', function () {
    $('#profileId').val($(this).data('profile'));
    $('#contactInput').val($(this).data('contact'));
    $('#profileNameInput').val($(this).data('name'));

    isSelected = true;
    hideSuggestions();
});

/* ================= UTIL ================= */
function hideSuggestions() {
    $('#contactSuggest').hide().html('');
    $('#nameSuggest').hide().html('');
}

$(document).on('click', function (e) {
    if (!$(e.target).closest('.relative').length) {
        hideSuggestions();
    }
});

/* DISCUSSION TOGGLE */
function changeDiscussion(value){
  $('#discussionPointer').hide();
  $('#followUpDate').hide();

  if(value === "yes"){
    $('#discussionPointer').show();
    $('#followUpDate').show();
  }
  if(value === "no"){
    $('#followUpDate').show();
  }
}
</script>