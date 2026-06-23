
// let video = document.getElementById("video");
// let stream = null;

// function openCamera() {
//   navigator.mediaDevices.getUserMedia({
//     video: { facingMode: "environment" }, // back camera
//     audio: false
//   })
//   .then(s => {
//     stream = s;
//     video.srcObject = stream;
//     video.play();
//   })
//   .catch(err => {
//     alert("Camera error: " + err.name);
//   });
// }

// function captureImage() {
//   let canvas = document.getElementById("canvas");
//   let ctx = canvas.getContext("2d");

//   canvas.width = video.videoWidth;
//   canvas.height = video.videoHeight;

//   ctx.drawImage(video, 0, 0);
//   document.getElementById("img_base64").value =
//     canvas.toDataURL("image/jpeg", 0.8);

//   // camera band kar do
//   if (stream) {
//     stream.getTracks().forEach(track => track.stop());
//   }

//   alert("Image captured, now submit");
// }



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

