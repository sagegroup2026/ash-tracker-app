<style>
.formerror{
  color:red;
}
</style>

<?php $profile_name = $this->input->get('profile_name'); ?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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
        action="<?php echo base_url('save-test-visit'); ?>">

    <input type="hidden" name="location" id="location">

    <!-- PROFILE ID -->
    <div class="mb-2">
      <label class="form-label">Profile ID</label>
      <input type="text" id="profileId"  name="profile_id" value="<?= isset($visit->profile_id) ? $visit->profile_id : '' ?>" class="form-control bg-light" readonly>
    </div>
    
    <!-- PROFILE NAME -->
    <div class="mb-2 relative">
      <label class="form-label">Profile Name</label>
      <input type="text" name="profile_name" id="profileNameInput" value="<?= !empty($profile_name) ? $profile_name : (isset($visit->name) ? $visit->name : '') ?>"  class="form-control bg-light" autocomplete="off" readonly>
      <div id="nameSuggest" class="autocomplete-box" style="display:none;"></div>
    </div>
 
    <!-- CONTACT -->
    <div class="mb-2 relative">
      <label class="form-label">Contact Number</label>
      <input type="text" name="contact" id="contactInput" value="<?= isset($visit->contact) ? $visit->contact : '' ?>" class="form-control bg-light" autocomplete="off" readonly>
      <div id="contactSuggest" class="autocomplete-box" style="display:none;"></div>
    </div>
    
    <!-- POC Name -->
    <div class="mb-2">
        
        <div class="d-flex align-items-center justify-content-between mb-1">
            <label class="form-label mb-0"> POC Name<span class="required-star"> *</span> </label>
    
            <!-- SMALL ADD BUTTON -->
            <button type="button" class="btn btn-sm  add-poc-btn" data-bs-toggle="modal"  data-bs-target="#addPocModal">
                <i class="fa fa-plus"></i> Add POC
            </button>
        </div>
            
        <select id="poc_name" class="form-control select2-poc"  name="poc_select[]" multiple="multiple" required>
            <option value="">Select POC Name</option>
          </select>
    </div>
    <!-- Add Cofellow Button -->
    <div class="mb-3" id="addCofellowWrapper">
        <button type="button" class="btn btn-sm cofellow-btn" id="addCofellowBtn">
            <i class="fa fa-plus"></i> Add Cofellow
        </button>
    </div>
    <!-- Cofellow Select -->
    <div class="mb-3" id="cofellowWrapper" style="display:none;">
    
        <label class="form-label">
            Cofellow Name
        </label>
    
        <select id="cofellow_name" class="form-control" name="cofellow_select[]" multiple="multiple">

        <?php foreach(getAgents() as $agent){ ?>

            <option value="<?= $agent->id ?>">
                <?= $agent->name ?>
            </option>

        <?php } ?>

    </select>
    
    </div>
    <!--</div>-->
    <!-- Image -->
    <div class="mb-2">

        <button type="button" id="openBtn" class="btn submit-btn" onclick="openCamera()">
          Capture Image
        </button>
    
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
          <button type="button"  id="switchBtn" class="btn cam-btn btn-info" onclick="switchCamera()" style="display:none;margin-left:5px;"><i class="fa-solid fa-camera-rotate"></i></button>
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
      <label class="form-label">Discussion Pointer</label>
      <textarea name="discussion_pointer" id="discussionText" class="form-control"></textarea>
    </div>


    <!-- FOLLOW UP -->
    <div class="mb-3" id="followUpDate" style="display:none;">
      <label class="form-label">Next Follow Up Date</label>
      <input type="date" name="follow_up_date" class="form-control  custom-input common-date" required>
    </div>
     <input type="hidden" id="noPoc" name="no_poc" value="0">
    <div class="">
      <button type="submit" class="btn" style="background:var(--blue); color:#fff;">Submit</button>
    </div>
  </form>
</div>
</div>

<!-- ADD POC MODAL -->
<div class="modal fade" id="addPocModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content poc-modal">

            <!-- HEADER -->
            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="fa fa-user-plus me-2"></i>
                    Add Point Of Contact
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <!-- BODY -->
            <div class="modal-body">

                <form method="POST" id="pocForm" enctype="multipart/form-data"  action="<?php echo base_url('save-poc'); ?>"> 

                        <input type="hidden" name="through_visit_form" value="1">
                        <input type="hidden" id="modalProfileId" name="p_id" class="form-control">

                        <input type="hidden" name="profile_name" id="modalProfileName" class="form-control">

                        <input type="hidden" name="contact" id="modalContact" class="form-control">

                    <!-- POC NAME -->
                    <div class="mb-3">

                        <label class="form-label"> Name <span class="required-star">*</span></label>

                        <input type="text" name="poc_name" class="form-control custom-input" oninput="validateInput(event, 'name')" required>
                        <span class="formerror" data-for="name"></span>
                    </div>

                    <!-- POC CONTACT -->
                    <div class="mb-3">

                        <label class="form-label">
                            POC Contact
                            <span class="required-star">*</span>
                        </label>

                        <input type="number"
                               name="poc_contact"
                               oninput="validateInput(event, 'phone')"
                               class="form-control custom-input"
                               required>
                        <span class="formerror" data-for="phone"></span>
                    </div>

                    <!-- DESIGNATION -->
                    <div class="mb-3">

                        <label class="form-label">
                            POC Designation
                            <span class="required-star">*</span>
                        </label>

                        <input type="text"
                               name="designation"
                               class="form-control custom-input">

                    </div>

                    <!-- SUBMIT -->
                    <div class="d-grid">

                        <button type="submit"
                                class="btn save-poc-btn">
                            Save POC

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
<?php $this->load->view('common/form-script'); ?>
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
#switchCameraBtn {
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 10;
}

/*----- POC Modal -----*/
/* SMALL BUTTON */
.add-poc-btn{
    background:#00799E;
    color:#fff;
    border:none;
    border-radius:10px;
    padding:6px 12px;
    font-size:12px;
    font-weight:600;
    transition:.3s;
}

.add-poc-btn:hover{
    background:#006684;
    color:#fff;
    transform:translateY(-1px);
}

/* MODAL */
.poc-modal{
    border:none;
    border-radius:20px;
    overflow:hidden;
}

.poc-modal .modal-header{
    background:#00799E;
    color:#fff !important;
    border:none;
}
.modal-title{
    color:#fff;
}

.poc-modal .btn-close{
    filter:brightness(0) invert(1);
}

.poc-modal .modal-body{
    padding:25px;
}

.save-poc-btn{
    background:#00799E;
    color:#fff;
    border:none;
    padding:12px;
    border-radius:12px;
    font-weight:600;
    transition:.3s;
}

.save-poc-btn:hover{
    background:#006684;
    color:#fff;
}

.cofellow-btn{
    float: inline-end;
    border: 1.5px solid var(--blue);
    color: var(--blue);

}
</style>
<!-- jQuery (ONLY ONCE) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

$(document).ready(function(){

    // OPEN MODAL + AUTO FILL
    $('.add-poc-btn').click(function(){

        $('#modalProfileId').val($('#profileId').val());

        $('#modalProfileName').val($('#profileNameInput').val());

        $('#modalContact').val($('#contactInput').val());

    });

});

</script>
<script>
$('#pocForm').on('submit', function(e){

    // Visit form wali validation rok do
    e.stopImmediatePropagation();

    // direct submit
    this.submit();

});
</script>

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
        $('#followUpDate').show();
        $('#discussionText').attr('required', true);
    } else {
        $('#discussionPointer').hide();
        $('#followUpDate').show();
        $('#discussionText').removeAttr('required').val('');
    }
});

</script>

<script>
    // let stream = null;

// /* OPEN CAMERA */
// function openCamera() {
//   $('#openBtn').hide();

//   navigator.mediaDevices.getUserMedia({
//     video: { facingMode: currentFacingMode }
//   }).then(function(mediaStream){
//     stream = mediaStream;

//     const video = document.getElementById('video');
//     video.srcObject = stream;
//     video.style.display = 'block';

//     $('#captureBtn').show();
//     $('#retakeBtn').hide();
//     $('#preview').hide();
//     $('#imageError').hide();
//     $('#switchCameraBtn').show();

//   }).catch(function(){
//     $('#openBtn').show();
//     alert('Camera permission denied');
//   });
// }

// /* CAPTURE IMAGE */
// $('#captureBtn').on('click', function () {

//   const video = document.getElementById('video');
//   const canvas = document.getElementById('canvas');
//   const preview = document.getElementById('preview');

//   canvas.width = video.videoWidth;
//   canvas.height = video.videoHeight;

//   const ctx = canvas.getContext('2d');
//   ctx.drawImage(video, 0, 0);

//   const imageData = canvas.toDataURL('image/jpeg', 0.8);

//   $('#img_base64').val(imageData);
//   $('#imageError').hide();

//   preview.src = imageData;
//   preview.style.display = 'block';

//   video.style.display = 'none';
//   $('#captureBtn').hide();
//   $('#retakeBtn').show();

//   stopCamera();
// });

// /* RETAKE IMAGE */
// $('#retakeBtn').on('click', function () {
//   $('#img_base64').val('');
//   $('#preview').hide();

//   $('#openBtn').show(); // SHOW BUTTON AGAIN
//   openCamera();
// });

// /* STOP CAMERA */
// function stopCamera() {
//   if (stream) {
//     stream.getTracks().forEach(track => track.stop());
//     stream = null;
//   }
// }

// $('#switchCameraBtn').on('click', function () {

//   // toggle front/back
//   currentFacingMode = (currentFacingMode === "environment") ? "user" : "environment";

//   stopCamera();   // pehle current camera band karo
//   openCamera();   // fir naya camera open karo
// });

/* IMAGE MANDATORY */
// $('form').on('submit', function (e) {
//   if (!$('#img_base64').val()) {
//     e.preventDefault();
//     $('#imageError').show();
//     return false; 
//   }
// });
</script>



<script>
// $(document).on('click', '.autocomplete-item', function () {

//     const profileId = $(this).data('profile');
//     const pocSelect = $('[name="poc_select"]');

//     if (!profileId || pocSelect.length === 0) return;

//     $.ajax({
//         url: "<?= base_url('Form/get_poc_by_profile') ?>",
//         type: "POST",
//         dataType: "json", // 🔥 IMPORTANT
//         data: { profile_id: profileId },
//         success: function (pocs) {

//             pocSelect.html('<option value="">Select POC Name</option>');

//             if (!pocs || pocs.length === 0) return;

//             pocs.forEach(function (poc) {
//                 pocSelect.append(
//                     `<option value="${poc.id}">${poc.poc_name}</option>`
//                 );
//             });
//         },
//         error: function (xhr) {
//             console.error('POC AJAX Error:', xhr.responseText);
//         }
//     });

// });

function getPocNameByProfileId() {

    const profileId = $('#profileId').val();
    const profileName = $("#profileNameInput").val();
    const pocSelect = $('[name="poc_select[]"]');

    if (!profileId || pocSelect.length === 0) return;

    $.ajax({
        url: "<?= base_url('Form/get_poc_by_profile') ?>",
        type: "POST",
        dataType: "json",
        data: { profile_id: profileId },

        success: function (pocs) {

            pocSelect.html('<option value="">Select POC Name</option>');

            // agar POC nahi mila
            if (!pocs || pocs.length === 0) {

                pocSelect.append(
                    `<option value="profile">${profileName} </option>`
                );
              
               $("#noPoc").val(1); // hidden field set

                
                return;
            }

            // agar POC mil gaye
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

}
window.onload = getPocNameByProfileId();

$(document).ready(function () {
    $('#poc_name').select2({
        placeholder: 'Select POC Name',
        width: '100%',
        minimumResultsForSearch: 0
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
</script>

<script>

$(document).ready(function(){

$('.select2-users').select2({
placeholder: "Select Users",
closeOnSelect:false,
width:'100%',
dropdownParent: $('#addPlanModal')
});

});
</script>

<script>

$(document).ready(function () {
    // Add Cofellow Click
    $('#addCofellowBtn').click(function () {

        $('#addCofellowWrapper').hide();

        $('#cofellowWrapper').fadeIn(200);

        // Initialize select2 AFTER show
        $('#cofellow_name').select2({
            placeholder: "Select Cofellow",
            closeOnSelect: false,
            width: '100%'
        });

    });

});

</script>

<script src="<?php echo base_url();?>assets/scripts/fetch_location.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!--<script src="<?php //echo base_url();?>assets/scripts/capture.js"></script>-->
<script src="<?php echo base_url();?>assets/scripts/captureSanjay.js"></script>