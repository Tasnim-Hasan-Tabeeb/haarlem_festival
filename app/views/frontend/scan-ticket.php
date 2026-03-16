<?php include __DIR__ . '/../frontend/inc/header.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.0.9/html5-qrcode.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
<link rel="stylesheet" href="/frontend/css/scanticket.css" />

<h1>Scan Ticket</h1>
<div>
    <video id="camera-feed" width="500" autoplay style="margin-top: 10%;"></video>
    <div id="alert-message" class="hidden"></div>
    <br>
</div>

<script>
    const videoElement = document.getElementById('camera-feed');
    const alertMessage = document.getElementById('alert-message');

    navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: 'environment'
            }
        })
        .then(stream => {
            videoElement.srcObject = stream;
            videoElement.onloadedmetadata = () => {
                videoElement.play();
                detectQRCode(videoElement);
            };
        })
        .catch(error => console.error('Error accessing camera:', error));

    function detectQRCode(video) {
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, imageData.width, imageData.height);

        if (code) {
            console.log('QR Code detected:', code.data);
            console.log('Request body:', JSON.stringify({
                code: code.data
            }));
            video.srcObject.getTracks().forEach(track => track.stop());

            fetch('/scanticket/verifyTicket', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        code: code.data
                    })
                })
                .then(response => response.text())
                .then(text => {
                    console.log('Response text:', text);
                    try {
                        const data = JSON.parse(text);
                        console.log('Parsed JSON response:', data);
                        if (data.success) {
                            alert('Ticket status updated to Scanned.');
                        } else {
                            showAlert(data.message, false);
                        }
                    } catch (error) {
                        console.error('JSON parse error:', error);
                        showAlert('Failed to verify QR code. Please try again.', false);
                    }
                    restartScan();
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    showAlert('Failed to verify QR code. Please try again.', false);
                    restartScan();
                });
        } else {
            requestAnimationFrame(() => detectQRCode(video));
        }
    }

    function restartScan() {
        setTimeout(() => {
            const videoElement = document.getElementById('camera-feed');
            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment'
                    }
                })
                .then(stream => {
                    videoElement.srcObject = stream;
                    videoElement.onloadedmetadata = () => {
                        videoElement.play();
                        detectQRCode(videoElement);
                    };
                })
                .catch(error => console.error('Error accessing camera:', error));
        }, 3000); // Restart scan after 3 seconds
    }

    function showAlert(message, success) {
        alertMessage.innerText = message;
        alertMessage.classList.remove('hidden');
        if (success) {
            alertMessage.classList.add('success');
        } else {
            alertMessage.classList.add('error');
        }
        setTimeout(() => {
            alertMessage.classList.add('hidden');
        }, 3000); // Hide alert after 3 seconds
    }
</script>