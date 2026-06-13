<?php include __DIR__ . '/../inc/header.php'; ?>

<link rel="stylesheet" href="/frontend/css/yummy-details.css" />

<!-- ── MASTHEAD ─────────────────────────────────────────────── -->
<div class="masthead" style="background-image: url('<?php echo htmlspecialchars($restaurant['image_url']); ?>')">
    <div class="color-overlay">

        <div class="name-details">
            <h1 class="restaurant-name"><?php echo ($restaurant['title']); ?></h1>

            <div class="rating">
                <?php
                $fullStars = floor($restaurant['ratings']);
                $halfStar  = ($restaurant['ratings'] - $fullStars) >= 0.5;
                for ($i = 0; $i < $fullStars; $i++)         echo '&#9733;';
                if ($halfStar)                               echo '&#9733;';
                for ($i = $fullStars + $halfStar; $i < 5; $i++) echo '&#9734;';
                ?>
            </div>

            <ul class="feature-list">
                <?php foreach ($restaurant['features'] as $feature) : ?>
                    <li class="feature">
                        <img src="<?php echo htmlspecialchars($feature['image_url']); ?>"
                             alt="<?php echo htmlspecialchars($feature['name']); ?>" />
                        <p><?= ($feature['name']) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="open-days">
            <p class="text">Can't wait to see you on!</p>
            <h2 class="date"><?php echo 'Today is ' . date('l, F j, Y'); ?></h2>
        </div>

    </div>
</div>

<!-- ── STICKY NAVIGATION ────────────────────────────────────── -->
<nav class="section-navigation">
    <ul>
        <li><a href="#about">ABOUT</a></li>
        <li><a href="#food-costs">FOOD / COSTS</a></li>
        <li><a href="#gallery">GALLERY</a></li>
        <li><a href="#reservation">RESERVATION</a></li>
        <li><a href="#contact">CONTACT</a></li>
    </ul>
</nav>

<!-- ── MAIN ─────────────────────────────────────────────────── -->
<div class="main">

    <!-- ABOUT -->
    <div id="about" class="section">
        <h2>About</h2>
        <div class="red-line"></div>
        <p><?php echo html_entity_decode($restaurant['description']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($restaurant['location']); ?></p>
        <p><strong>Number of Seats:</strong> <?php echo htmlspecialchars($restaurant['number_of_seats']); ?></p>
    </div>

    <!-- FOOD / COSTS -->
    <div id="food-costs" class="section">
        <h2>Food / Costs</h2>
        <div class="red-line"></div>
        <div class="price-per-person">
            <div>
                <p><strong>Cuisines:</strong> <?= htmlspecialchars($restaurant['cuisines']) ?></p>
            </div>
            <div>
                👶 Child:
                <strong>€<?= number_format($restaurant['price_for_child'], 2) ?></strong>
            </div>
            <div>
                🧑 Adult:
                <strong>€<?= number_format($restaurant['price_for_adult'], 2) ?></strong>
            </div>
        </div>
    </div>

    <!-- GALLERY -->
    <div id="gallery" class="section">
        <h2>Gallery</h2>
        <div class="red-line"></div>
        <div class="gallery-container">
            <div class="gallery">
                <?php foreach (json_decode($restaurant['gallery_images']) as $image) : ?>
                    <img src="<?php echo $image; ?>" alt="Gallery Image" />
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- RESERVATION -->
    <div id="reservation" class="section">
        <h2>Reservation</h2>
        <div class="red-line"></div>

   
        <div class="reservation-container">
            <form class="reservation-form" action="/reservation/makeReservation" method="POST">
                <input type="hidden" name="restaurant_id" value="<?php echo htmlspecialchars($restaurant['restaurant_id']); ?>">

              
                <div class="form-group row">
                    <div class="form-group col">
                        <label for="adults" class="form-label">Persons (Adults) *</label>
                        <input type="number" class="form-control" min="0" max="1000" id="adults" name="total_adult"  />
                        <small class="input-error" id="adults-error"></small>

                    </div>
                    <div class="form-group col">
                        <label for="children" class="form-label">Persons (Children) *</label>
                        <input type="number" class="form-control" min="0" max="1000" id="children" name="total_children"  />
                        <small class="input-error" id="children-error"></small>

                    </div>
                </div>

                 <div class="form-group row">
                    <div class="form-group col">
                        <label for="phone" class="form-label">Phone *</label>
                        <input type="text" class="form-control" id="phone" name="phone" required />
                        <small class="input-error" id="phone-error"></small>

                    </div>
                </div>

                <div class="form-group row">
                    <div class="form-group col">
                        <label for="reservation_date" class="form-label">Reservation Date *</label>
                        <input type="date" class="form-control" id="reservation_date" name="reservation_date"
                               value="2026-07-27" min="2026-07-27" max="2026-07-31" required />
                            
                        <small class="input-error" id="reservation_date-error"></small>

                    </div>
                    <div class="form-group col">
                        <label for="session_id" class="form-label">Session *</label>
                        <select id="session_id" name="session_id" class="form-control" required>
                            <option value="">Select Session</option>
                            <?php foreach ($sessions as $session) : ?>
                                <?php
                                $start_time = new DateTime($session['start_time']);
                                $end_time   = clone $start_time;
                                $end_time->add(new DateInterval('PT' . ($session['duration'] * 60) . 'M'));
                                $session_time = $start_time->format('H:i') . ' - ' . $end_time->format('H:i');
                                ?>
                                <option value="<?php echo htmlspecialchars($session['session_id']); ?>">
                                    <?php echo htmlspecialchars($session_time); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <small class="input-error" id="session_id-error"></small>

                    </div>
                </div>

                <div class="form-group">
                    <label for="remarks" class="form-label">Special Request</label>
                    <textarea id="remarks" class="form-control" name="remarks" rows="4"></textarea>
                    <small class="input-error" id="remarks-error"></small>

                </div>

                <div class="form-group text-center">
                    <button type="submit" class="form-submit-btn">Make Reservation</button>
                </div>
            </form>

            <img src="/images/overview/rest-details.jpg" alt="Reservation" class="reservation-image" />
        </div>




    </div>

    <!-- CONTACT -->
    <div id="contact" class="section">
        <h2>Contact</h2>
        <div class="red-line"></div>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($restaurant['contact_email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($restaurant['contact_phone']); ?></p>
    </div>

    <div class="red-line"></div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href'))
                ?.scrollIntoView({
                    behavior: 'smooth'
                });
        });
    });

    // Active nav highlight
    const sections = document.querySelectorAll('.section[id]');
    const navLinks = document.querySelectorAll('.section-navigation a');

    const observer = new IntersectionObserver(entries => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {

                navLinks.forEach(link => {
                    link.style.borderBottomColor = 'transparent';
                    link.style.color = '';
                });

                const active = document.querySelector(
                    `.section-navigation a[href="#${entry.target.id}"]`
                );

                if (active) {
                    active.style.borderBottomColor = 'var(--accent, #18181b)';
                    active.style.color = 'var(--accent, #18181b)';
                }
            }
        });

    }, {
        rootMargin: '-30% 0px -60% 0px'
    });

    sections.forEach(s => observer.observe(s));



    // =========================================
    // FORM VALIDATION
    // =========================================

    const form = document.querySelector('.reservation-form');

    form.addEventListener('submit', function (e) {

        let hasError = false;

        clearErrors();

        const adults = document.getElementById('adults');
        const children = document.getElementById('children');
        const phone = document.getElementById('phone');
        const reservationDate = document.getElementById('reservation_date');
        const session = document.getElementById('session_id');

        const adultsValue = parseInt(adults.value) || 0;
        const childrenValue = parseInt(children.value) || 0;

        // Adults
        if (adultsValue < 0 || adultsValue > 10000) {
            showError(adults, 'adults-error', 'Adults must be between 0 and 10000.');
            hasError = true;
        }

        else if (childrenValue < 0 || childrenValue > 10000) {
            showError(children, 'children-error', 'Children must be between 0 and 10000.');
            hasError = true;
        }

        // Total persons
        if (adultsValue === 0 && childrenValue === 0 || (adults.value === '' && children.value === '')) {
            showError(adults, 'adults-error', 'Please enter at least one person.');
            showError(children, 'children-error', '');
            hasError = true;
        }

        // Phone
        if (phone.value.trim() === '') {
            showError(phone, 'phone-error', 'Phone is required.');
            hasError = true;
        }

        // Date
        if (reservationDate.value.trim() === '') {
            showError(
                reservationDate,
                'reservation_date-error',
                'Reservation date is required.'
            );

            hasError = true;
        }

        // Session
        if (session.value.trim() === '') {
            showError(session, 'session_id-error', 'Please select a session.');
            hasError = true;
        }

        // Restaurant seat validation
        const maxSeats = <?= (int) $restaurant['number_of_seats'] ?>;

        if ((adultsValue + childrenValue) > maxSeats) {

            showError(
                adults,
                'adults-error',
                `Maximum number of people is ${maxSeats}.`
            );
            showError(
                adults,
                'children-error',
                `Maximum number of people is ${maxSeats}.`
            );

            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
        }

    });




    // =========================================
    // HELPERS
    // =========================================

    function showError(input, errorId, message) {

        input.classList.add('error');

        document.getElementById(errorId).textContent = message;
    }

    function clearErrors() {

        document.querySelectorAll('.input-error')
            .forEach(el => el.textContent = '');

        document.querySelectorAll('.form-control')
            .forEach(el => el.classList.remove('error'));
    }

});
</script>