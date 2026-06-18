document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('form').addEventListener('submit', function (e) {
        const captcha = grecaptcha.getResponse();

        if (captcha.length === 0) {
            e.preventDefault();
            toastr.error('Please confirm you are not a robot');
        }
    });

    document.getElementById('profile_picture').addEventListener('change', function () {
        previewImage(this);
    });
});

function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('avatarPlaceholder');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            placeholder.classList.add('d-none');
        };

        reader.readAsDataURL(input.files[0]);
    }
}
