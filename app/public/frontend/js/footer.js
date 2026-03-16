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
            alert("Please enter a valid email address.");
            return;
        }

        axios.post("/api/sendmail/sendemail", { email: email })
            .then(function (response) {
                alert("Success! You have been registered to our newsletter successfully.");
                signupForm.reset();
            })
            .catch(function (error) {
                alert("An error occurred while sending the email.");
                console.error(error);
            });
    }
});