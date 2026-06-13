</main>

<footer class="hf-footer">
    <div class="hf-container">
        <div class="hf-footer__grid">

            <div class="hf-footer__logo">
                <a href="/"><img src="/assets/images/Logo.png" alt="Haarlem Festival"></a>
            </div>

            <div class="hf-footer__center">
                <p class="hf-footer__label">Newsletter</p>
                <p class="hf-footer__text">
                    Sign up to stay informed about our events, exhibitions and recommendations.
                </p>
                <form id="hf-footer-form" class="hf-footer__form" novalidate>
                    <input
                        type="email"
                        class="hf-footer__input"
                        placeholder="Your email address"
                        required
                        id="hf-footer-email"
                    >
                    <button type="submit" class="hf-footer__btn" id="hf-footer-btn">Subscribe</button>
                </form>
            </div>

            <div>
                <p class="hf-footer__label">Follow us</p>
                <ul class="hf-footer__social-list">
                    <li><a href="#" class="hf-footer__social-link" aria-label="Facebook"><i class="bi bi-facebook"></i></a></li>
                    <li><a href="#" class="hf-footer__social-link" aria-label="X / Twitter"><i class="bi bi-twitter-x"></i></a></li>
                    <li><a href="#" class="hf-footer__social-link" aria-label="Instagram"><i class="bi bi-instagram"></i></a></li>
                </ul>
            </div>

        </div>

        <div class="hf-footer__bottom">
            <p class="hf-footer__copy">&copy; <?= date('Y') ?> Haarlem Festival. All rights reserved.</p>
        </div>
    </div>
</footer>

</div><!-- /.hf-page-wrapper -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "4000"
};
</script>

<?php include __DIR__ . '/toastr.php'; ?>
<script>
/* Hamburger toggle */
(function () {
    var toggler  = document.getElementById('hf-toggler');
    var collapse = document.getElementById('hf-nav-collapse');
    var icon     = document.getElementById('hf-toggler-icon');
    if (!toggler || !collapse) return;

    function close() {
        collapse.classList.remove('is-open');
        toggler.setAttribute('aria-expanded', 'false');
        icon.className = 'bi bi-list';
    }

    toggler.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = collapse.classList.toggle('is-open');
        toggler.setAttribute('aria-expanded', isOpen);
        icon.className = isOpen ? 'bi bi-x-lg' : 'bi bi-list';
    });

    document.addEventListener('click', function (e) {
        if (!collapse.contains(e.target) && !toggler.contains(e.target)) close();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') close();
    });
})();

/* Newsletter form */
(function () {
    var form = document.getElementById('hf-footer-form');
    var btn  = document.getElementById('hf-footer-btn');
    var email = document.getElementById('hf-footer-email');

    if (!form || !btn || !email) return;
    function isValidEmail(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var emailValue = email.value.trim();
         // ❌ Empty check
        if (!emailValue) {
            toastr.error('Please enter your email address');
            email.focus();
            return;
        }
        // ❌ Valid email check
        if (!isValidEmail(emailValue)) {
            toastr.error('Please enter a valid email address');
            email.focus();
            return;
        }

        var orig = btn.textContent;
        btn.textContent = 'Subscribed';
        btn.disabled = true;
        email.value = '';
        toastr.success('You have successfully subscribed to our newsletter.');
        
        setTimeout(function () {
            btn.textContent = orig;
            btn.disabled = false;
            form.reset();
        }, 3000);
    });
})();
</script>

</body>
</html>