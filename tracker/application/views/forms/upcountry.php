  <link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<div class="main-div">
    <div class="profile-wrapper">
  <h4 class="profile-title">Upcountry</h4>
 <?php if ($this->session->flashdata('register-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('register-message'); ?>
    </div>         
<?php endif; ?>
  <form method="POST" enctype="multipart/form-data"
        action="<?php echo base_url('save-upcountry'); ?>">
      
      <!-- No. of POC -->
      <div class="mb-3">
        <label class="form-label">No. of People<span class="required-star"> *</span></label>
        <input type="number" name="no_of_people" class="form-control custom-input" min="1">
      </div>
      
      <!-- Tour Date -->
        <div class="row g-3 mb-3"> 
          <div class="col-6">
           <label class="form-label">Starts From<span class="required-star"> *</span></label>
          <input type="date" name="start_date" class="form-control custom-input common-date date-no-past">
          </div>
          <div class="col-6">
            <label class="form-label">End<span class="required-star"> *</span></label>
          <input type="date" name="end_date" class="form-control custom-input common-date date-no-past">
          </div>
        </div>
        
        <!-- Hospital Onboard --> 
        <div class="mb-3">
          <label class="form-label">Tour City<span class="required-star"> *</span></label>
          <input type="text" name="tour_city" class="form-control custom-input" id="search" required>
        </div>
        
        <!-- Profile Type -->
        <div class="mb-2" >
          <label class="form-label">Tour Type<span class="required-star"> *</span></label>
          <select class="form-control" id="tour_type" name="tour_type">
            <option value="">Select Tour Type</option>
            <option value="Conference">Conference</option>
            <option value="Event">Event</option>
            <option value="Doctor Visit">Doctor Visit</option>
            <option value="All">All</option>
            <option value="Others">Others</option>
          </select>
        </div>
        
        <!-- Travel By -->
        <div class="mb-3" id="other-detail" style="display:none;">
          <!--<label class="form-label"></label> -->
          <input type="text" name="other_tour_type" class="form-control custom-input" required>
        </div>
        
        <!-- Travel By -->
        <div class="mb-3">
          <label class="form-label">Travel By<span class="required-star"> *</span></label> 
          <input type="text" name="travel_by" class="form-control custom-input" required>
        </div>
        
      <!-- IMAGE -->
      <div class="mb-2">
      
      <button type="button" id="openBtn" class="btn submit-btn" onclick="openCamera()">
          Capture Image
        </button>
        
        <video id="video" autoplay playsinline style="width:250px; display:none;"></video>
        
        <br>
        <button type="button" id="captureBtn" class="btn cam-btn" onclick="captureImage()" style="display:none;">
          Capture
        </button>
        
        <br>
        
        <img id="preview" style="display:none; width:250px; border:1px solid #ccc;"/>
        
        <input type="hidden" name="img_base64" id="img_base64">
        
        <canvas id="canvas" style="display:none;"></canvas>
    </div>

    <div class="">
      <button type="submit" class="btn submit-btn">Submit</button>
    </div>
  </form>
</div> 
</div>

<script>
  document.getElementById("tour_type").addEventListener("change", function () {
    if (this.value == "Others") {
      document.getElementById("other-detail").style.display = "block";
    } else {
      document.getElementById("other-detail").style.display = "none";
    }
  });
</script>

<script>
let video = document.getElementById("video");
let stream = null;

function openCamera() {
  navigator.mediaDevices.getUserMedia({
    video: { facingMode: "environment" },
    audio: false
  })
  .then(s => {
    stream = s;
    video.srcObject = stream;

    // show video & capture button
    video.style.display = "block";
    document.getElementById("captureBtn").style.display = "inline-block";

    // hide open camera button
    document.getElementById("openBtn").style.display = "none";
  })
  .catch(err => {
    alert("Camera error: " + err.name);
  });
}

function captureImage() {
  let canvas = document.getElementById("canvas");
  let ctx = canvas.getContext("2d");

  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;

  ctx.drawImage(video, 0, 0);

  let imageData = canvas.toDataURL("image/jpeg", 0.8);
  document.getElementById("img_base64").value = imageData;

  // preview image show
  let preview = document.getElementById("preview");
  preview.src = imageData;
  preview.style.display = "block";

  // stop camera
  if (stream) {
    stream.getTracks().forEach(track => track.stop());
  }

  // hide video & capture button
  video.style.display = "none";
  document.getElementById("captureBtn").style.display = "none";

  alert("Image captured successfully");
}

</script>