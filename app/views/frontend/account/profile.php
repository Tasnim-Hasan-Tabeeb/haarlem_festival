<?php include __DIR__ . '/../inc/header.php'; ?>


<?php
// Guard — redirect if not logged in
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
}

$user        = $_SESSION['user'];
$memberSince = date('F j, Y', strtotime($user['registration_date']));
$avatarSrc   = !empty($user['profile_picture'])
                    ? htmlspecialchars($user['profile_picture'])
                    : '/images/default.png';
?>

<link rel="stylesheet" href="/frontend/css/profile.css" />

<div class="profile-page">
    <div class="profile-container">

        <!-- ── PAGE HEADER ──────────────────────────────────── -->
        <div class="profile-header">
            <div class="profile-avatar">
                <img src="<?= $avatarSrc ?>"
                     alt="<?= htmlspecialchars($user['name']); ?>"
                     id="headerAvatar" />
                <label class="profile-avatar__change" for="avatarFileQuick" title="Change photo">📷</label>
                <input type="file" id="avatarFileQuick" accept="image/*" />
            </div>

            <div class="profile-header__info">
                <h1><?= htmlspecialchars($user['name']); ?></h1>
                <p><?= htmlspecialchars($user['email']); ?></p>
            </div>

            <span class="profile-header__badge"><?= htmlspecialchars($user['role']); ?></span>
        </div>

        <!-- ── TABS ─────────────────────────────────────────── -->
        <div class="profile-tabs" role="tablist">
            <button class="profile-tab active" data-tab="profile" role="tab">Profile</button>
            <button class="profile-tab"        data-tab="password" role="tab">Password</button>
        </div>

        <!-- ══════════════════════════════════════════════════
             TAB 1 — PROFILE
        ══════════════════════════════════════════════════════ -->
        <div class="profile-panel active" id="tab-profile">

            <!-- Avatar upload -->
            <div class="profile-card mb-20" >
                <div class="profile-card__header">
                    <h2>Profile Photo</h2>
                    <p>Upload a new profile picture (JPG, PNG — max 2 MB)</p>
                </div>
                <div class="avatar-section">
                    <img src="<?= $avatarSrc ?>" alt="Avatar preview" class="avatar-preview" id="avatarPreview" />
                    <div class="avatar-actions">
                        <label class="btn-outline cursor-pointer" for="avatarFile">
                            Choose Photo
                        </label>
                        <p>Changes are saved when you click <strong>Save Changes</strong> below.</p>
                    </div>
                </div>

                <form class="profile-card__body" id="profileForm"
                      action="/account/updateProfile" method="POST"
                      enctype="multipart/form-data">

                    <!-- hidden file bound to both triggers -->
                    <input type="file" class="d-none" id="avatarFile" name="profile_picture" accept="image/*"/>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="<?= htmlspecialchars($user['name']); ?>" required />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">
                                Email <span>(cannot be changed)</span>
                            </label>
                            <input type="email" class="form-control" id="email"
                                   value="<?= htmlspecialchars($user['email']); ?>"
                                   disabled />
                        </div>
                    </div>

                    <div class="info-box">
                        🗓️ &nbsp;Member since <strong>&nbsp;<?= $memberSince ?></strong>
                        &nbsp;·&nbsp; Role: <strong>&nbsp;<?= htmlspecialchars($user['role']); ?></strong>
                    </div>

                    <div class="profile-card__footer">
                        <p>Only your name and photo can be updated.</p>
                        <div class="btn-wrapper">
                            <a href="/home" class="btn-outline">Cancel</a>
                            <button type="submit" class="btn-primary">Save Changes</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>

        <!-- ══════════════════════════════════════════════════
             TAB 2 — PASSWORD
        ══════════════════════════════════════════════════════ -->
        <div class="profile-panel" id="tab-password">

            <div class="profile-card">
                <div class="profile-card__header">
                    <h2>Change Password</h2>
                    <p>Choose a strong password of at least 8 characters.</p>
                </div>

                <form class="profile-card__body" id="passwordForm"
                      action="/account/updatePassword" method="POST">

                    <!-- New password -->
                    <div class="form-group">
                        <label class="form-label" for="new_password">New Password</label>
                        <div class="input-wrapper">
                            <input type="password" class="form-control" id="new_password"
                                   name="new_password" required autocomplete="new-password" />
                            <button type="button" class="input-toggle" data-target="new_password">👁</button>
                        </div>
                        <div class="password-strength">
                            <div class="password-strength__bar" id="strengthBar"></div>
                        </div>
                        <span class="strength-text" id="strengthText"></span>
                        <span class="form-hint">Min. 8 characters, mix of letters and numbers recommended.</span>
                    </div>

                    <!-- Confirm password -->
                    <div class="form-group">
                        <label class="form-label" for="confirm_password">Confirm New Password</label>
                        <div class="input-wrapper">
                            <input type="password" class="form-control" id="confirm_password"
                                   name="confirm_password" required autocomplete="new-password" />
                            <button type="button" class="input-toggle" data-target="confirm_password">👁</button>
                        </div>
                        <span class="form-hint" id="matchHint"></span>
                    </div>

                    <div class="profile-card__footer">
                        <button type="button" class="btn-danger" id="resetPasswordForm">Reset Fields</button>
                        <button type="submit" class="btn-primary" id="submitPassword">Update Password</button>
                    </div>

                </form>
            </div>

        </div>
        <!-- end panels -->

    </div>
</div>

<!-- ── TOAST ──────────────────────────────────────────────── -->
<div class="profile-toast" id="profileToast"></div>


<?php include __DIR__ . '/../inc/footer.php'; ?>

<script>
(function () {

    /* ── toast ────────────────────────────────────────────── */
    function showToast(msg, type = 'success') {
        const el = document.getElementById('profileToast');
        el.textContent = msg;
        el.className = 'profile-toast ' + type + ' show';
        setTimeout(() => el.className = 'profile-toast', 3200);
    }

    /* ── tabs ─────────────────────────────────────────────── */
    document.querySelectorAll('.profile-tab').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.profile-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.profile-panel').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('tab-' + this.dataset.tab).classList.add('active');
        });
    });

    /* ── avatar preview (both triggers share same file input) ── */
    function bindAvatarPreview(inputId) {
        document.getElementById(inputId).addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                toastr.error('Image must be under 2 MB.');
                this.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('avatarPreview').src  = e.target.result;
                document.getElementById('headerAvatar').src   = e.target.result;
                // sync both file inputs
                if (inputId === 'avatarFileQuick') {
                    // copy files to the form input (works in modern browsers)
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    document.getElementById('avatarFile').files = dt.files;
                }
            };
            reader.readAsDataURL(file);
        });
    }

    bindAvatarPreview('avatarFile');
    bindAvatarPreview('avatarFileQuick');

    /* ── show / hide password ─────────────────────────────── */
    document.querySelectorAll('.input-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const inp = document.getElementById(this.dataset.target);
            if (inp.type === 'password') {
                inp.type = 'text';
                this.textContent = '🙈';
            } else {
                inp.type = 'password';
                this.textContent = '👁';
            }
        });
    });

    /* ── password strength ────────────────────────────────── */
    const newPw      = document.getElementById('new_password');
    const bar        = document.getElementById('strengthBar');
    const strengthTx = document.getElementById('strengthText');
    const matchHint  = document.getElementById('matchHint');
    const confirmPw  = document.getElementById('confirm_password');

    function checkStrength(pw) {
        let score = 0;
        if (pw.length >= 8)                    score++;
        if (pw.length >= 12)                   score++;
        if (/[A-Z]/.test(pw))                  score++;
        if (/[0-9]/.test(pw))                  score++;
        if (/[^A-Za-z0-9]/.test(pw))           score++;
        return score;
    }

    newPw.addEventListener('input', function () {
        const score = checkStrength(this.value);
        const pct   = Math.min(score / 5 * 100, 100);
        bar.style.width = pct + '%';

        if (score <= 1) {
            bar.style.background = '#ef4444';
            strengthTx.textContent = 'Weak';
            strengthTx.style.color = '#ef4444';
        } else if (score <= 3) {
            bar.style.background = '#f59e0b';
            strengthTx.textContent = 'Fair';
            strengthTx.style.color = '#f59e0b';
        } else {
            bar.style.background = '#16a34a';
            strengthTx.textContent = 'Strong';
            strengthTx.style.color = '#16a34a';
        }

        checkMatch();
    });

    confirmPw.addEventListener('input', checkMatch);

    function checkMatch() {
        if (!confirmPw.value) { matchHint.textContent = ''; return; }
        if (confirmPw.value === newPw.value) {
            matchHint.textContent = '✓ Passwords match';
            matchHint.style.color = '#16a34a';
        } else {
            matchHint.textContent = '✗ Passwords do not match';
            matchHint.style.color = '#ef4444';
        }
    }

    /* ── password form validation ─────────────────────────── */
    document.getElementById('passwordForm').addEventListener('submit', function (e) {
        if (newPw.value !== confirmPw.value) {
            e.preventDefault();
            toastr.error('Passwords do not match.');
            return;
        }
        if (newPw.value.length < 6) {
            e.preventDefault();
            toastr.error('Password must be at least 6 characters.');
        }
    });

    /* ── reset password fields ────────────────────────────── */
    document.getElementById('resetPasswordForm').addEventListener('click', function () {
        document.getElementById('passwordForm').reset();
        bar.style.width = '0%';
        strengthTx.textContent = '';
        matchHint.textContent  = '';
    });


})();
</script>

