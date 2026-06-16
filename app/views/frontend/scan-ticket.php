<?php include __DIR__ . '/inc/header.php'; ?>

<link rel="stylesheet" href="/frontend/css/scanticket.css" />

<div class="scan-page">
    <div class="scan-container">

        <!-- ── PAGE HEADER ──────────────────────────────────── -->
        <div class="scan-header">
            <h1>Scan Ticket</h1>
            <p>Point your camera at a QR code to verify a ticket</p>
        </div>

        <!-- ── CAMERA CARD ──────────────────────────────────── -->
        <div class="scan-card">

            <div class="scan-card__header">
                <h2>Camera</h2>
                <div class="scan-indicator">
                    <div class="scan-indicator__dot" id="indicatorDot"></div>
                    <span id="indicatorLabel">Starting…</span>
                </div>
            </div>

            <!-- Video + QR frame overlay -->
            <div class="scan-video-wrapper" id="videoWrapper">
                <video id="camera-feed" autoplay playsinline muted></video>

                <div class="scan-overlay">
                    <div class="scan-frame">
                        <div class="scan-frame__bl"></div>
                        <div class="scan-frame__br"></div>
                        <div class="scan-line" id="scanLine"></div>
                    </div>
                </div>
            </div>

            <div class="scan-card__footer">
                <p class="scan-status" id="scanStatus">
                    <strong>Scanning</strong> — hold QR code steady inside the frame
                </p>
                <button class="btn-restart d-none" id="restartBtn" >
                    ↺ Restart
                </button>
            </div>

        </div>

        <!-- ── RESULT BANNER ────────────────────────────────── -->
        <div id="alert-message"></div>

        <!-- ── SCAN LOG ──────────────────────────────────────── -->
        <div class="scan-log">
            <div class="scan-log__header">Recent Scans</div>
            <div class="scan-log__body" id="scanLogBody">
                <div class="scan-log__empty" id="scanLogEmpty">No scans yet.</div>
            </div>
        </div>

    </div>
</div>
<?php include __DIR__ . '/inc/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
<script>
(function () {

    const video       = document.getElementById('camera-feed');
    const alertEl     = document.getElementById('alert-message');
    const dot         = document.getElementById('indicatorDot');
    const label       = document.getElementById('indicatorLabel');
    const statusEl    = document.getElementById('scanStatus');
    const restartBtn  = document.getElementById('restartBtn');
    const logBody     = document.getElementById('scanLogBody');
    const logEmpty    = document.getElementById('scanLogEmpty');
    const scanLine    = document.getElementById('scanLine');
    const videoWrapper = document.getElementById('videoWrapper');

    let scanning = false;
    let rafId    = null;

    /* ── indicator state ──────────────────────────────────── */
    function setIndicator(state) {
        dot.className   = 'scan-indicator__dot ' + state;
        const labels    = { live: 'Live', idle: 'Idle', error: 'Error', processing: 'Processing…' };
        label.textContent = labels[state] || state;
    }

    function setStatus(html) {
        statusEl.innerHTML = html;
    }

    /* ── show result banner ───────────────────────────────── */
    function showAlert(message, success) {
        alertEl.textContent = message;
        alertEl.className   = success ? 'success' : 'error';
        alertEl.style.display = 'block';
        setTimeout(() => { alertEl.style.display = 'none'; alertEl.className = ''; }, 4000);
    }

    /* ── append to scan log ───────────────────────────────── */
    function logScan(message, ok) {
        logEmpty.style.display = 'none';
        const now  = new Date().toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        const item = document.createElement('div');
        item.className = 'scan-log__item';
        item.innerHTML = `
            <span class="scan-log__badge ${ok ? 'ok' : 'err'}">${ok ? '✓' : '✗'}</span>
            <span class="scan-log__text">${message}</span>
            <span class="scan-log__time">${now}</span>
        `;
        logBody.prepend(item);
    }

    /* ── start camera ─────────────────────────────────────── */
    function startCamera() {
        setIndicator('idle');
        setStatus('<strong>Starting</strong> — requesting camera access…');
        restartBtn.style.display = 'none';

        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then(stream => {
                video.srcObject = stream;
                video.onloadedmetadata = () => {
                    video.play();
                    scanning = true;
                    scanLine.style.display = 'block';
                    setIndicator('live');
                    setStatus('<strong>Scanning</strong> — hold QR code steady inside the frame');
                    rafId = requestAnimationFrame(() => detectQRCode());
                };
            })
            .catch(err => {
                console.error('Camera error:', err);
                setIndicator('error');
                setStatus('<strong>Camera unavailable</strong> — check permissions and try again');
                restartBtn.style.display = 'inline-flex';

                // show friendly message inside video area
                videoWrapper.innerHTML = `
                    <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:300px;gap:12px;">
                        <span style="font-size:48px;opacity:.35;">📷</span>
                        <p style="color:rgba(255,255,255,.5);font-size:13px;text-align:center;max-width:240px;margin:0;">
                            Camera access denied.<br>Please allow camera permissions and restart.
                        </p>
                    </div>`;
            });
    }

    /* ── QR detection loop ────────────────────────────────── */
    function detectQRCode() {
        if (!scanning) return;

        const canvas  = document.createElement('canvas');
        const context = canvas.getContext('2d');
        canvas.width  = video.videoWidth  || 640;
        canvas.height = video.videoHeight || 480;

        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
        const code      = jsQR(imageData.data, imageData.width, imageData.height);

        if (code) {
            scanning = false;
            cancelAnimationFrame(rafId);
            scanLine.style.display = 'none';

            // stop camera
            if (video.srcObject) {
                video.srcObject.getTracks().forEach(t => t.stop());
            }

            setIndicator('processing');
            setStatus('<strong>QR detected</strong> — verifying…');

            fetch('/scanticket/verifyTicket', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ code: code.data })
            })
            .then(r => r.text())
            .then(text => {
                let data;
                try { data = JSON.parse(text); } catch (e) {
                    showAlert('Invalid server response. Please try again.', false);
                    logScan('Parse error', false);
                    scheduleRestart();
                    return;
                }

                if (data.success) {
                    showAlert('✓ Ticket verified successfully!', true);
                    logScan('Ticket verified', true);
                    setStatus('<strong>Verified</strong> — restarting in 3 s…');
                    setIndicator('live');
                } else {
                    showAlert('✗ ' + (data.message || 'Verification failed.'), false);
                    logScan(data.message || 'Verification failed', false);
                    setStatus('<strong>Failed</strong> — ' + (data.message || 'try again'));
                    setIndicator('error');
                }
                scheduleRestart();
            })
            .catch(err => {
                console.error('Fetch error:', err);
                showAlert('Network error. Please try again.', false);
                logScan('Network error', false);
                setIndicator('error');
                scheduleRestart();
            });

        } else {
            rafId = requestAnimationFrame(() => detectQRCode());
        }
    }

    /* ── restart after delay ──────────────────────────────── */
    function scheduleRestart(delay = 3000) {
        restartBtn.style.display = 'inline-flex';
        setTimeout(() => {
            restartBtn.style.display = 'none';
            startCamera();
        }, delay);
    }

    restartBtn.addEventListener('click', () => {
        scanning = false;
        cancelAnimationFrame(rafId);
        startCamera();
    });

    /* ── boot ─────────────────────────────────────────────── */
    startCamera();

})();
</script>

