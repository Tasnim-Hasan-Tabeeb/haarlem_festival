<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm sticky-top">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold text-dark" href="/home/dashboard">
            Admin Dashboard
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">

                <!-- USER -->
                <li class="nav-item">
                    <div class="d-flex align-items-center gap-2 bg-light rounded-pill px-3 py-1 border">

                        <?php
                        $profile = $_SESSION['profile_picture'] ?? '';
                        ?>

                        <!-- PROFILE IMAGE -->
                        <?php if (!empty($profile)) : ?>
                            <img src="<?= htmlspecialchars($profile, ENT_QUOTES, 'UTF-8') ?>"
                                 class="user-avatar rounded-circle"
                                 alt="Profile">
                        <?php else : ?>
                            <div class="user-avatar d-flex align-items-center justify-content-center rounded-circle bg-secondary text-white">
                                <i class="fas fa-user"></i>
                            </div>
                        <?php endif; ?>

                        <span class="fw-semibold text-dark small">
                            <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>
                        </span>

                    </div>
                </li>

                <!-- LOGOUT -->
                <li class="nav-item">
                    <a class="btn btn-outline-dark btn-sm d-flex align-items-center gap-2"
                       href="/login/logout">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </li>

            </ul>

        </div>
    </div>
</nav>