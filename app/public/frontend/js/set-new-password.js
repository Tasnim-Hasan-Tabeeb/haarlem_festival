document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('resetPasswordForm').addEventListener('submit', function (e) {
        const pass = document.getElementById('password').value;
        const confirm = document.getElementById('confirmPassword').value;
        const msg = document.getElementById('passwordMismatchMessage');

        if (pass !== confirm) {
            e.preventDefault();
            msg.textContent = 'Passwords do not match';
        } else {
            msg.textContent = '';
        }
    });
});
