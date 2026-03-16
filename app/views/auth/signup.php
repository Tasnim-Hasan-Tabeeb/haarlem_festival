<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="icon" type="image/x-icon" href="/images/fav.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <!--    <script src="https://www.google.com/recaptcha/api.js" async defer></script>-->
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>
<body class="bg-dark p-5 text-white">
    <div class="container pt-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black h-100" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <?php if (isset($_SESSION['flash_message'])) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= $_SESSION['flash_message'] ?>
                                    </div>
                                    <?php unset($_SESSION['flash_message']); ?>
                                <?php endif; ?>

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4">Sign up</p>
                                <form id="registerUserForm" class="mx-1 mx-md-4" method="POST" enctype="multipart/form-data">
                                    <div class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="position-relative">
                                                <div class="avatar-upload">
                                                    <div class="avatar-edit">
                                                        <input type='file' name="profile_picture" id="profile_picture" accept=".png, .jpg, .jpeg" onchange="previewImage(this)" />
                                                        <label for="imageUpload"><i class="fas fa-edit"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example4c">Name</label>
                                            <input type="text" name="name" id="name" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example4c">Email</label>
                                            <input type="email" name="email" id="email" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" name="password" id="password" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="confirmPassword">Confirm
                                                Password</label>
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" />
                                        </div>
                                    </div>
                                    <!--                                <div class="g-recaptcha" data-sitekey="6LcaqH4pAAAAALSDLlcTRzfF5eBWyWIqkPZmNa8s"></div>-->
                                    <br />
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" name="signup-button" class="btn btn-primary btn-lg">
                                            Register
                                        </button>
                                    </div>
                                    <?php if (!empty($errorMessage)) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $errorMessage; ?>
                                        </div>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!--<script>-->
<!--    grecaptcha.ready(function () {-->
<!--        grecaptcha.execute('6LcaqH4pAAAAAIRxLN3RBK8YokHaweiW72FObc4I', {action: 'submit'}).then(function (token) {-->
<!--            console.log(token);-->
<!--        });-->
<!--    });-->
<!--</script>-->
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>