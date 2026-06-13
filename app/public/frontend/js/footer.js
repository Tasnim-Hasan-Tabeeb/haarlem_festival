document.addEventListener("DOMContentLoaded", function () {
    const signupForm = document.getElementById("signupForm");

    if (!signupForm) return;

    signupForm.addEventListener("submit", function (event) {
        event.preventDefault();
        sendEmail();
    });

    function sendEmail() {
        const emailInput = document.getElementById("email");
        const email = emailInput.value.trim();

        if (!email) {
            toastr.error("Please enter an email address.");
            return;
        }

        axios.post("/api/sendmail/sendemail", { email: email })
            .then(function (response) {
                toastr.success("Success! You have been registered to our newsletter successfully.");
                signupForm.reset();
            })
            .catch(function (error) {
                toastr.error("An error occurred while sending the email.");
                console.error(error);
            });
    }
});