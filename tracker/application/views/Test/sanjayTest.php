<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<div class="main-div">
<div class="profile-wrapper">
  <h4 class="profile-title">Time With Senior</h4>
<?php if ($this->session->flashdata('register-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('register-message'); ?>
    </div>         
    <?php endif; ?>
  <form method="POST" enctype="multipart/form-data"
        action="<?php echo base_url('save-senior'); ?>">
      
    <!-- Hospital Onboard -->
    <div class="mb-3">
      <label class="form-label">Agenda<span class="required-star"> *</span></label>
      <input type="text" name="agenda" class="form-control custom-input" required> 
    </div>
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
     <div class="">
      <button type="submit" class="btn submit-btn">Submit</button>
    </div>

  </form>
</div>
</div>


<script>
let stream = null;
let currentFacingMode = "environment"; // default back camera

/* OPEN CAMERA */
function openCamera(facingMode = "environment") {
    currentFacingMode = facingMode;

    $('#openBtn').hide();

    // old stream stop
    stopCamera();

    navigator.mediaDevices.getUserMedia({
        video: { facingMode: currentFacingMode },
        audio: false
    }).then(function(mediaStream) {
        stream = mediaStream;

        const video = document.getElementById('video');
        video.srcObject = stream;
        video.style.display = 'block';

        $('#captureBtn').show();
        $('#retakeBtn').hide();
        $('#switchBtn').show();
        $('#preview').hide();
        $('#imageError').hide();

    }).catch(function(err) {
        $('#openBtn').show();
        $('#switchBtn').hide();
        alert('Camera permission denied or camera not available');
        console.log(err);
    });
}

/* SWITCH CAMERA */
function switchCamera() {
    if (currentFacingMode === "environment") {
        openCamera("user"); // front camera
    } else {
        openCamera("environment"); // back camera
    }
}

/* CAPTURE IMAGE */
$('#captureBtn').on('click', function () {
    
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const preview = document.getElementById('preview');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0);

    const imageData = canvas.toDataURL('image/jpeg', 0.8);

    if (imageData) {
        alert('Image captured successfully!');
    }

    $('#img_base64').val(imageData);
    $('#imageError').hide();

    preview.src = imageData;
    preview.style.display = 'block';

    video.style.display = 'none';
    $('#captureBtn').hide();
    $('#switchBtn').hide();
    $('#retakeBtn').show();

    stopCamera();
});

/* RETAKE IMAGE */
$('#retakeBtn').on('click', function () {
    $('#img_base64').val('');
    $('#preview').hide();
    openCamera(currentFacingMode);
});

/* STOP CAMERA */
function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
}

/* IMAGE MANDATORY ON FORM SUBMIT */
$('form').on('submit', function (e) {
    if (!$('#img_base64').val()) {
        e.preventDefault();
        $('#imageError').show();
        alert('Please capture image before submitting');
        return false;
    }
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo base_url();?>assets/scripts/capture.js"></script>