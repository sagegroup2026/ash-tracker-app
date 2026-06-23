<style>
.formerror{
  color:red;
}
</style>


<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<div class="main-div">
    <div class="profile-wrapper">
  <div class="profile-title">Visit</div>
<?php if ($this->session->flashdata('register-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('register-message'); ?>
    </div>         
    <?php endif; ?>
  <form method="POST" enctype="multipart/form-data"
        action="<?php echo base_url('save-visit'); ?>">

    <input type="hidden" name="location" id="location">

    <!-- PROFILE ID -->
    <div class="mb-2">
      <label class="form-label">Profile ID</label>
      <input type="text" id="profileId" name="profile_id" class="form-control" readonly>
    </div>
    
    <!-- PROFILE NAME -->
    <div class="mb-2 relative">
      <label class="form-label">Profile Name<span class="required-star"> *</span></label>
      <input type="text" name="profile_name" id="profileNameInput" class="form-control" autocomplete="off" required>
      <div id="nameSuggest" class="autocomplete-box" style="display:none;"></div>
    </div>
 
    <!-- CONTACT -->
    <div class="mb-2 relative">
      <label class="form-label">Contact Number<span class="required-star"> *</span></label>
      <input type="text" name="contact" id="contactInput" class="form-control" autocomplete="off" required>
      <div id="contactSuggest" class="autocomplete-box" style="display:none;"></div>
    </div>
    
    <!-- POC Name -->
    <div class="mb-2">
        <label class="form-label">POC Name<span class="required-star"> *</span></label>
        <select class="form-control" name="poc_select" required>
            <option value="">Select POC Name</option>
          </select>
    </div>
    

        
    <!-- DATE -->
    <div class="mb-2">
      <label class="form-label">Date<span class="required-star"> *</span></label>
      <input type="date" name="date" class="form-control custom-input common-date date-today-only">
    </div>
    
    <!-- DATE -->
    <div class="mb-2">
      <label class="form-label">Time<span class="required-star"> *</span></label>
      <input type="time" name="visit_time" class="form-control custom-input" required>
    </div>
    
    <!-- IMAGE -->
    <!--  <div class="mb-2">-->
      
    <!--  <button type="button" id="openBtn" class="btn submit-btn" onclick="openCamera()">-->
    <!--      Capture Image-->
    <!--    </button>-->
        
    <!--    <br><br>-->
        
    <!--    <video id="video" autoplay playsinline style="width:250px; display:none;"></video>-->
        
    <!--    <br>-->
        
    <!--    <button type="button" id="captureBtn" class="btn cam-btn" onclick="captureImage()" style="display:none;">-->
    <!--      Capture-->
    <!--    </button>-->
        
    <!--    <br><br>-->
        
    <!--    <img id="preview" style="display:none; width:250px; border:1px solid #ccc;"/>-->
        
    <!--    <input type="hidden" name="img_base64" id="img_base64">-->
        
    <!--    <canvas id="canvas" style="display:none;"></canvas>-->
    <!--</div>-->
    <div class="mb-2">

    <button type="button" id="openBtn" class="btn submit-btn" onclick="openCamera()">
      Capture Image
    </button>

    <br><br>

    <video id="video" autoplay playsinline style="width:250px; display:none;"></video>


    <img id="preview" style="display:none; width:250px; border:1px solid #ccc; margin-top:10px;"/>

    <input type="hidden" name="img_base64" id="img_base64">

    <canvas id="canvas" style="display:none;"></canvas>
    
        <div class="d-flex mt-2">
      <button type="button" id="retakeBtn" class="btn cam-btn" style="display:none;">
        Retake
      </button>

      <button type="button" id="captureBtn" class="btn cam-btn" style="display:none;">
        Capture
      </button>
    </div>

    <p id="imageError" class="formerror" style="display:none;">
      Please capture an image before submitting.
    </p>
  </div>

    <!-- Discussion -->
    <div class="mb-3">
      <label class="form-label">Discussion (Yes/No) <span class="text-danger">*</span></label>
      <div>
        <input type="radio" name="discussion" value="yes" class="discussionRadio" required>
        <span class="form-label">Yes</span>
    
        <input type="radio" name="discussion" value="no" class="discussionRadio">
        <span class="form-label">No</span>
      </div>
    </div>
    
    <!-- Discussion Pointer -->
    <div class="mb-3" id="discussionPointer" style="display:none;">
      <label class="form-label">Discussion Pointer<span class="required-star"> *</span></label>
      <textarea name="discussion_pointer" id="discussionText" class="form-control"></textarea>
    </div>


    <!-- FOLLOW UP -->
    <div class="mb-3" id="followUpDate">
      <label class="form-label">Next Follow Up Date<span class="required-star"> *</span></label>
      <input type="date" name="follow_up_date" class="form-control custom-input common-date date-no-past" required> 
    </div>

    <div class="">
      <button type="submit" class="btn" style="background:var(--blue); color:#fff;">Submit</button>
    </div>
  </form>
</div>
</div>
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
<!-- jQuery (ONLY ONCE) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
</script>

<script>

/* DISCUSSION TOGGLE */ 
$(document).on('change', '.discussionRadio', function () {
    const value = $(this).val();

    if (value === 'yes') {
        $('#discussionPointer').show();
        $('#discussionText').attr('required', true);
    } else {
        $('#discussionPointer').hide();
        $('#discussionText').removeAttr('required').val('');
    }
});




</script>
<script src="<?php echo base_url();?>assets/scripts/capture.js"></script>


<script>
$(document).on('click', '.autocomplete-item', function () {

    const profileId = $(this).data('profile');
    const pocSelect = $('[name="poc_select"]');

    if (!profileId || pocSelect.length === 0) return;

    $.ajax({
        url: "<?= base_url('Form/get_poc_by_profile') ?>",
        type: "POST",
        dataType: "json", 
        data: { profile_id: profileId },
        success: function (pocs) {

            pocSelect.html('<option value="">Select POC Name</option>');

            if (!pocs || pocs.length === 0) return;

            pocs.forEach(function (poc) {
                pocSelect.append(
                    `<option value="${poc.id}">${poc.poc_name}</option>`
                );
            });
        },
        error: function (xhr) {
            console.error('POC AJAX Error:', xhr.responseText);
        }
    });

});
</script>
<script>
    $('form').on('submit', function(e) {

    let followUp = $('input[name="follow_up_date"]').val().trim();

    if (followUp === '') {
        e.preventDefault();   // form submit rok do
        alert('Please select Follow Up Date');
        $('input[name="follow_up_date"]').focus();
        return false;
    }

});
</script>

<script src="<?php echo base_url();?>assets/scripts/fetch_location.js"></script>

