<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<div class="main-div">
    <div class="profile-wrapper">
  <h4 class="profile-title">In House Meetings</h4>
 <?php if ($this->session->flashdata('login-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('login-message'); ?>
    </div>         
<?php endif; ?>
  <form method="POST" enctype="multipart/form-data"
        action="<?php echo base_url('save-in-house'); ?>">
      
    <!-- Referred By -->
    <div class="mb-3">
      <label class="form-label">Meeting<span class="required-star"> *</span></label>
      <div>
        <input type="radio" name="meeting" value="doctor" id="meetDoctor" required>
        <span class="form-label">Doctor</span>
        
        <input type="radio" name="meeting" value="vc" id="meetvc" class="ms-3" required>
        <span class="form-label">Visiting Consultance</span>
        <br>
        <input type="radio" name="meeting" value="patient" id="meetPatient">
        <span class="form-label">Patient</span>
        
        <input type="radio" name="meeting" value="other" id="meetOther" class="ms-3">
        <span class="form-label">Other</span>
      </div>
    </div>
    
     <!-- IMAGE -->
    <!--  <div class="mb-2">-->
      
    <!--  <button type="button" id="openBtn" class="btn submit-btn" onclick="openCamera()">-->
    <!--      Capture Image-->
    <!--    </button>-->
        
        <!--<br><br>-->
        
    <!--    <video id="video" autoplay playsinline style="width:250px; display:none;"></video>-->
        
    <!--    <br>-->
        
    <!--    <button type="button" id="captureBtn" class="btn cam-btn" onclick="captureImage()" style="display:none;">-->
    <!--      Capture-->
    <!--    </button>-->
        
        <!--<br><br>-->
        
    <!--    <img id="preview" style="display:none; width:250px; border:1px solid #ccc;"/>-->
        
    <!--    <input type="hidden" name="img_base64" id="img_base64">-->
        
    <!--    <canvas id="canvas" style="display:none;"></canvas>-->
    <!--</div>-->
    
    
    <div class="mb-2">

        <button type="button" id="openBtn" class="btn submit-btn" onclick="openCamera()">
          Capture Image
        </button>
    
        <!--<br><br>-->
    
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
    
    <!-- Name -->
    <div class="mb-3">
      <label class="form-label">Name<span class="required-star"> *</span></label>
      <input type="text" name="name" class="form-control custom-input"  onkeyup="getText(this.value)" id="search" required>

        <ul id="result" class="list-group"></ul>

    </div>
    
    <!-- UHID (Only for Patient) -->
    <div class="mb-3" id="uhidField" style="display:none;">
      <label class="form-label">UHID <span class="required-star">*</span></label>
      <input type="text" maxlength="14" oninput="validateInput(event, 'uhid')" name="uhid" id="uhid" class="form-control custom-input">
      <span class="formerror" data-for="uhid"></span>
    </div>
    

    <!-- Room No. -->
    <div class="mb-3">
      <label class="form-label">Room no.</label>
      <input type="number" name="room_no" id="roomNo" class="form-control custom-input" required>
    </div>
    
    <!-- Date -->
    <div class="mb-3">
      <label class="form-label">Date<span class="required-star"> *</span></label>
      <input type="date" name="date" class="form-control custom-input common-date default-today" required>
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
    
    <!-- MOM -->
    <div class="mb-3" id="mom" style="display:none;">
      <label class="form-label">Minutes of Meeting (MOM)<span class="required-star"> *</span></label>
      <textarea name="mom" class="form-control custom-input"   required>
          </textarea>

        <ul id="result" class="list-group"></ul>

    </div>
    

    <div class="">
      <button type="submit" class="btn submit-btn">Submit</button>
    </div>
<canvas id="canvas" style="display:none;"></canvas>
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
#result{
  border:1px solid #ccc;
  list-style:none;
  padding:0;
  margin:0;
  max-height:150px;
  overflow-y:auto;
  display:none;
  position:absolute;
  background:#fff;
  width:80%;
  z-index:999;
}

#result li{
  padding:8px;
  cursor:pointer;
}

#result li:hover{
  background:#f1f1f1;
}

</style>

<script>
// const roomNo = document.getElementById('roomNo');

// const meetDoctor = document.getElementById('meetDoctor');
// const meetPatient = document.getElementById('meetPatient');
// const meetOther   = document.getElementById('meetOther');

// /* Doctor */
// meetDoctor.onclick = () => {
//     roomNo.removeAttribute('required');
// };

// /* Other */
// meetOther.onclick = () => {
//     roomNo.removeAttribute('required');
// };

// /* Patient */
// meetPatient.onclick = () => {
//     roomNo.setAttribute('required', true);
// };
</script>

<script>
const roomNo = document.getElementById('roomNo');
const meetDoctor = document.getElementById('meetDoctor');
const meetvc = document.getElementById('meetvc'); 
const meetPatient = document.getElementById('meetPatient');
const meetOther = document.getElementById('meetOther');

const uhidField = document.getElementById('uhidField');
const uhidInput = document.getElementById('uhid');

/* Doctor */
meetDoctor.onclick = () => {
    roomNo.removeAttribute('required');
    uhidField.style.display = "none";
    mom.style.display = "block";
    mom.setAttribute('required', true);
    uhidInput.removeAttribute('required');
};
/*meetvc*/
meetvc.onclick = () => {
    roomNo.removeAttribute('required');
    uhidField.style.display = "none";
    mom.style.display = "block";
    mom.setAttribute('required', true);
    uhidInput.removeAttribute('required');
};

/* Other */
meetOther.onclick = () => {
    roomNo.removeAttribute('required');
    uhidField.style.display = "none";
    mom.style.display = "block";
    mom.setAttribute('required', true);
    uhidInput.removeAttribute('required');
};

/* Patient */
meetPatient.onclick = () => {
    roomNo.setAttribute('required', true);
    uhidField.style.display = "block";
    mom.style.display = "none";
    mom.removeAttribute('required');
    uhidInput.setAttribute('required', true);
};
</script>

<script>

// function getText(text){

//   if(text.length < 3){
//     $("#result").hide();
//     return;
//   }

//   $.ajax({
//     url: "<?php echo base_url('search'); ?>",
//     type: "POST",
//     data: { text: text },
//     dataType: "json",
//     success: function(data){
//       $("#result").html("");

//       if(data.length == 0){
//         $("#result").hide();
//         return;
//       }

//       $.each(data, function(i, value){
//         $("#result").append(
//           "<li onclick=\"selectName('"+value+"')\">"+value+"</li>"
//         );
//       });

//       $("#result").show();
//     }
//   });
// }

// function selectName(name){
//   $("#search").val(name);
//   $("#result").hide();
// }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!--<script src="<?php //echo base_url();?>assets/scripts/capture.js"></script>-->
<script src="<?php echo base_url();?>assets/scripts/captureSanjay.js"></script>
