<script>
function takeSnapshot() {
    var video = document.querySelector("#videoElement");
    var canvas = document.createElement("canvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
    return canvas.toDataURL('image/png');
}

function setupCamera() {
    if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                var video = document.getElementById('videoElement');
                video.srcObject = stream;
            })
            .catch(function (error) {
                console.log("Something went wrong with the webcam.");
            });
    }
}

document.addEventListener('DOMContentLoaded', setupCamera);
</script>

<video autoplay="true" id="videoElement"></video>
<button onclick="document.getElementById('imageData').value = takeSnapshot();">Take Snapshot</button>
<input type="hidden" id="imageData" name="imageData">

<form method="POST" action="?page=saveImage" enctype="multipart/form-data">
    <label for="fileInput">Upload an image:</label>
    <input type="file" id="fileInput" name="fileInput">
    <input type="hidden" name="overlay" value="<?php echo $_GET['overlay']; ?>">
    <button type="submit">Save Image</button>
</form>
