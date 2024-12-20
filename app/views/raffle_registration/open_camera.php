<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0" />
	<title>Web Cam</title>
	<script>
	document.addEventListener("DOMContentLoaded", () => {
		var but = document.getElementById("but");
		var video = document.getElementById("vid");
		var mediaDevices = navigator.mediaDevices;
		vid.muted = true;
		but.addEventListener("click", () => {

		// Accessing the user camera and video.
		mediaDevices
			.getUserMedia({
                video: {
                    facingMode: 'environment'
                },
			    audio: false,
			})
			.then((stream) => {

			// Changing the source of video to current stream.
			video.srcObject = stream;
			video.addEventListener("loadedmetadata", () => {
				video.play();
			});
			})
			.catch(alert);
		});
	});
	</script>
</head>

<style>
	div {
	width: 500px;
	height: 400px;
	border: 2px solid black;
	position: relative;
	}
	video {
	width: 500px;
	height: 400px;
	object-fit: cover;
	}
</style>

<body>
	<center>
	<div>
		<video id="vid"></video>
	</div>
	<br />
	<button id="but" autoplay>
		Open WebCam
	</button>
	</center>
</body>
</html>
