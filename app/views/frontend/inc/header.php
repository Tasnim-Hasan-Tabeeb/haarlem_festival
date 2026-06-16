<?php
use App\Services\PageService;
$pageService = new PageService();
$pages       = $pageService->getAllActive();
$cartCount   = isset($_SESSION['basket']) ? count($_SESSION['basket']) : 0;
$currentUri  = $_SERVER['REQUEST_URI'] ?? '/';
$role        = $_SESSION['role']       ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=  'Haarlem Festival' . (isset($title) ? ' | ' . $title : '') ?></title>

    <!-- 1. Global tokens -->
    <link rel="stylesheet" href="/frontend/css/main.css">
    <!-- 2. Bootstrap Icons (icons only, no BS layout) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- 3. Navbar + footer -->
    <link rel="stylesheet" href="/frontend/css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
<div class="hf-page-wrapper">

<nav class="hf-navbar" id="hf-navbar">
    <div class="hf-navbar__container">

        <a class="hf-navbar__brand" href="/">
            <img src="/assets/images/Logo.png" alt="Haarlem Festival">
        </a>

        <button
            class="hf-navbar__toggler"
            id="hf-toggler"
            type="button"
            aria-label="Toggle navigation"
            aria-expanded="false"
            aria-controls="hf-nav-collapse"
        >
            <i class="bi bi-list" id="hf-toggler-icon"></i>
        </button>

        <div class="hf-navbar__collapse" id="hf-nav-collapse">

            <ul class="hf-navbar__nav hf-navbar__nav--center">
                <?php foreach ($pages as $page) :
                    $title = htmlspecialchars($page['title']);
                    $slug  = $page['slug'];
                    $url   = strtolower($slug) === 'home'
                        ? '/'
                        : '/home/page?slug=' . $slug . '&id=' . $page['page_id'];
                    $active = ($url === $currentUri || strpos($currentUri, $slug) !== false);
                ?>
                <li class="hf-navbar__item">
                    <a class="hf-navbar__link<?= $active ? ' hf-navbar__link--active' : '' ?>"
                       href="<?= $url ?>"><?= $title ?></a>
                </li>
                <?php endforeach; ?>

       
            </ul>

            <ul class="hf-navbar__nav hf-navbar__nav--right">


                <?php if (isset($_SESSION['user'])) :
                    $uname = htmlspecialchars($_SESSION['username'] ?? 'Account');

                    $dash = $role === 'Admin' ? '/home/dashboard'
                           : ($role === 'Employee' ? '/scanticket/scanticket' : '/account/index');
                ?>
                <li class="hf-navbar__item">
                    <a class="hf-navbar__link hf-navbar__link--user" href="<?= $dash ?>">
                        <i class="bi bi-person-circle"></i> <?= $uname ?>
                    </a>
                </li>

            
                <li class="hf-navbar__item">
                    <a class="hf-navbar__cart" href="/personalprogram/personalprogram" aria-label="Cart">
                        <i class="bi bi-bag"></i>
                       
                        <span class="hf-navbar__cart-badge cart-counter <?= $cartCount == 0 ? 'd-none' : '' ?>">
                            <?= $cartCount ?>
                        </span>               
                    </a>
                </li>
                <li class="hf-navbar__item">
                    <a class="hf-navbar__btn hf-navbar__btn--danger" href="/login/logout">Logout</a>
                </li>
                <?php else : ?>
                <li class="hf-navbar__item">
                    <a class="hf-navbar__cart" href="/personalprogram/personalprogram" aria-label="Cart">
                        <i class="bi bi-bag"></i>
                       
                        <span class="hf-navbar__cart-badge cart-counter <?= $cartCount == 0 ? 'd-none' : '' ?>"><?= $cartCount ?></span>
                      
                    </a>
                </li>
                <li class="hf-navbar__item">
                    <a class="hf-navbar__btn hf-navbar__btn--primary" href="/login/login">Login</a>
                </li>
                <?php endif; ?>

                           
                <?php if (isset($_SESSION['user']) && $role == 'Admin') : ?>
                <li class="hf-navbar__item">
                    <a class="hf-navbar__btn hf-navbar__btn--primary" href="/scanticket/scanticket">
                        Scan Ticket
                    </a>
                </li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</nav>

<main class="hf-main">