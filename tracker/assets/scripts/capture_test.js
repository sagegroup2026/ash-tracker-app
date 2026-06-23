let stream = null;
let facingMode = "environment"; // back camera default

/* OPEN CAMERA */
function openCamera() {

  $('#openBtn').hide();

  navigator.mediaDevices.getUserMedia({
    video: { facingMode: facingMode },
    audio: false
  }).then(function(mediaStream){

    stream = mediaStream;

    const video = document.getElementById('video');
    video.srcObject = stream;
    video.style.display = 'block';

    $('#captureBtn').show();
    $('#switchBtn').show();
    $('#retakeBtn').hide();
    $('#preview').hide();
    $('#imageError').hide();

  }).catch(function(err){
    console.log(err);
    $('#openBtn').show();
    alert('Camera permission denied');
  });
}


/* SWITCH CAMERA */
function switchCamera() {

  facingMode = (facingMode === "environment") ? "user" : "environment";

  if (stream) {
    stream.getTracks().forEach(track => track.stop());
  }

  openCamera();
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

  if(imageData){
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

  openCamera();
});


/* STOP CAMERA */
function stopCamera() {
  if (stream) {
    stream.getTracks().forEach(track => track.stop());
    stream = null;
  }
}


/* BUTTON EVENTS */
$('#openBtn').on('click', function () {
  openCamera();
});

$('#switchBtn').on('click', function () {
  switchCamera();
});


/* IMAGE MANDATORY VALIDATION */
$('form').on('submit', function (e) {
  if (!$('#img_base64').val()) {
    e.preventDefault();
    $('#imageError').show();
    alert('Please capture image before submitting');
    return false;
  }
});