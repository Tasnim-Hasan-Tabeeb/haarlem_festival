<?php
use App\Services\PageService;

$pageService = new PageService();
$pages = $pageService->getAllActive();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Haarlem Festival' ?></title>
    <link rel="stylesheet" href="/frontend/css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/frontend/css/footer.css">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        
        <a class="navbar-brand" href="/">
            <img src="/assets/images/Logo.png" alt="Haarlem Festival" height="50">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#festivalNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="festivalNavbar">

            
            <ul class="navbar-nav mx-auto">

                <?php
                foreach ($pages as $page) {

                    $pageTitle = htmlspecialchars($page['title']);
                    $pageSlug = $page['slug'];
                    $lowerPageTitle = strtolower($pageTitle);

                    $pageUrl = ($lowerPageTitle === 'home')
                        ? '/'
                        : '/home/page?slug=' . $pageSlug . '&id=' . $page['page_id'];

                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="' . $pageUrl . '">' . $pageTitle . '</a>
                    </li>';
                }
                ?>

            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <?php
                if (isset($_SESSION['user'])) {

                    $username = htmlspecialchars($_SESSION['username']);

                    if ($_SESSION['role'] == "Admin") {

                        echo '
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="/home/dashboard">
                                <i class="bi bi-person"></i> ' . $username . '
                            </a>
                        </li>';

                    } elseif ($_SESSION['role'] == "Employee") {

                        echo '
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="/scanticket/scanticket">
                                <i class="bi bi-person"></i> ' . $username . '
                            </a>
                        </li>';

                    } else {

                        echo '
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="#">
                                <i class="bi bi-person"></i> ' . $username . '
                            </a>
                        </li>';
                    }

                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="/personalprogram/personalprogram">
                            Personal Program
                        </a>
                    </li>';

                    echo '
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-danger" href="/login/logout">
                            Logout
                        </a>
                    </li>';

                } else {

                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="/personalprogram/personalprogram">
                            Personal Program
                        </a>
                    </li>';

                    echo '
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary" href="/login/login">
                            Login
                        </a>
                    </li>';
                }
                ?>

            </ul>

        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script src="/frontend/js/footer.js"></script>