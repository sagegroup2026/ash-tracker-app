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

    <!-- Profile Name -->
    <div class="mb-3">
      <label class="form-label">Senior Name<span class="required-star"> *</span></label>
      <input type="text" name="senior_name" class="form-control custom-input" required>
    </div>
    
    <!-- IMAGE -->
    <!--<div class="mb-2">-->
      
    <!--  <button type="button" id="openBtn" class="btn submit-btn" onclick="openCamera()">-->
    <!--      Capture Image-->
    <!--    </button>-->
        
    <!--    <br><br>-->
        
    <!--    <video id="video" autoplay playsinline style="width:250px; display:none;"></video>-->
        
    <!--    <br>-->
        
    <!--    <button type="button" id="captureBtn" class="btn cam-btn" onclick="captureImage()" style="display:none;">-->
    <!--      Capture-->
    <!--    </button>-->
        
    <!--    <br>-->
        
    <!--    <img id="preview" style="display:none; width:250px; border:1px solid #ccc;"/>-->
        
    <!--    <input type="hidden" name="img_base64" id="img_base64">-->
        
    <!--    <canvas id="canvas" style="display:none;"></canvas>-->
    <!--</div>-->
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
    
    <!-- time -->
    <div class="row g-3 mb-3">
      <div class="col-6">
       <label class="form-label">From Time<span class="required-star"> *</span></label>
      <input type="time" name="from_time" class="form-control custom-input" required>
      </div>
      <div class="col-6">
        <label class="form-label">To Time<span class="required-star"> *</span></label>
      <input type="time" name="to_time" class="form-control custom-input" required>
      </div>
    </div>

    <div class="">
      <button type="submit" class="btn submit-btn">Submit</button>
    </div>

  </form>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo base_url();?>assets/scripts/captureSanjay.js"></script>