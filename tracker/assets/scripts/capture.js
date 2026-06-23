let stream = null;

/* OPEN CAMERA */
function openCamera() {
  $('#openBtn').hide();

  navigator.mediaDevices.getUserMedia({
    video: { facingMode: "environment" }
  }).then(function(mediaStream){
    stream = mediaStream;

    const video = document.getElementById('video');
    video.srcObject = stream;
    video.style.display = 'block';

    $('#captureBtn').show();
    $('#retakeBtn').hide();
    $('#preview').hide();
    $('#imageError').hide();

  }).catch(function(){
    $('#openBtn').show();
    alert('Camera permission denied');
  });
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
  $('#retakeBtn').show();

  stopCamera();
});

/* RETAKE IMAGE */
$('#retakeBtn').on('click', function () {
  $('#img_base64').val('');
  $('#preview').hide();

  $('#openBtn').show();
  openCamera();
});

/* STOP CAMERA */
function stopCamera() {
  if (stream) {
    stream.getTracks().forEach(track => track.stop());
    stream = null;
  }
}

/* IMAGE MANDATORY */
$('form').on('submit', function (e) {
  if (!$('#img_base64').val()) {
    e.preventDefault();
    $('#imageError').show();
    alert('Please capture image before submitting️');
    return false;
  }
});

