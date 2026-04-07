<?php include __DIR__ . '/../inc/header.php'; ?>

<link rel="stylesheet" href="/frontend/css/yummy-details.css" />

<div class="masthead" style="background-image: url('<?php echo htmlspecialchars($restaurant['image_url']); ?>')">
    <div class="color-overlay">
        <div class="name-details">
            <h1 class="restaurant-name"><?php echo htmlspecialchars($restaurant['title']); ?></h1>
            <!-- &#9733 - filled star; &#9734 - hollow star -->
            <!-- <span class="stars">&#9733;&#9733;&#9733;&#9733;&#9734;</span> -->
            <div class="rating">
                <?php
                $fullStars = floor($restaurant['ratings']);
                $halfStar  = $restaurant['ratings'] - $fullStars >= 0.5;
                for ($i = 0; $i < $fullStars; $i++) {
                    echo '&#9733;'; // Filled star
                }
                if ($halfStar) {
                    echo '&#9733;'; // Half star (or use a specific half star icon if available)
                }
                for ($i = $fullStars + $halfStar; $i < 5; $i++) {
                    echo '&#9734;'; // Empty star
                }
                ?>
            </div>
            <ul class="feature-list">
                <?php foreach ($restaurant['features'] as $feature) : ?>
                    <li class="feature" style="color: white;">
                        <img src="<?php echo $feature['image_url']; ?>" alt="<?php echo $feature['name']; ?>" />
                        <p><?= htmlspecialchars($feature['name']) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="open-days">
            <p class="text">
                Can't wait to see you on!
            </p>
            <h2 class="date"> <?php echo 'Today is ' . date('l, F j, Y') ?></h2>
           
        </div>
    </div>
</div>

<!-- Navigation -->
<div class="section-navigation" style="color: white;">
    <ul>
        <li><a href="#about" style="color: white;">ABOUT</a></li>
        <li><a href="#food-costs" style="color: white;">FOOD/COSTS</a></li>
        <li><a href="#gallery" style="color: white;">GALLERY</a></li>
        <li><a href="#reservation" style="color: white;">RESERVATION</a></li>
        <li><a href="#contact" style="color: white;">CONTACT</a></li>
    </ul>
</div>

<div class="main" style="color: white;">
    <!-- About Section -->
    <div id="about" class="section">
        <h2>About</h2>
        <div class="red-line"></div>
        <p><?php echo html_entity_decode($restaurant['description']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($restaurant['location']); ?></p>
        <p><strong>Number of Seats:</strong> <?php echo htmlspecialchars($restaurant['number_of_seats']); ?></p>
    </div>

    <!-- Food/Costs Section -->
    <div id="food-costs" class="section">
        <h2>Food/Costs</h2>
        <div class="red-line"></div>
        
        <div class="price-per-person">
            <div>
                <p><strong>Cuisines:</strong> <?= htmlspecialchars($restaurant['cuisines']) ?></p>
            </div>
            <div>
                👶 Child: 
                <strong>
                    €<?= number_format($restaurant['price_for_child'], 2) ?>
                </strong>
            </div>
            <div>
                🧑 Adult: 
                <strong>
                    €<?= number_format($restaurant['price_for_adult'], 2) ?>
                </strong>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
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

    <!-- Reservation Section -->
    <div id="reservation" class="section">
        <h2>Reservation</h2>
        <?php include __DIR__ . '/../../backend/inc/message.php'; ?>
        <div class="red-line"></div>
        <div class="reservation-container">
            <form class="reservation-form" action="/reservation/create" method="POST">
                <input type="hidden" name="restaurant_id" value="<?php echo htmlspecialchars($restaurant['restaurant_id']); ?>">
                <div class="form-group">
                    <label for="name" class="form-label">Your Name *</label>
                    <input type="text" class="form-control" id="name" name="name" required />
                </div>
                <div class="form-group row">
                    <div class="form-group col">
                        <label for="adults" class="form-label">Persons (Adults) *</label>
                        <input type="number" class="form-control" min="0" id="adults" name="total_adult" required />
                    </div>
                    <div class="form-group col">
                        <label for="children" class="form-label">Persons (Children) *</label>
                        <input type="number" class="form-control" min="0" id="children" name="total_children" required />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group col">
                        <label for="phone" class="form-label">Phone *</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required />
                    </div>
                    <div class="form-group col">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo (isset($_SESSION['user'])) ? htmlspecialchars($_SESSION['user']['email']) : '' ?>" required />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group col">
                        <label for="reservation_date" class="form-label">Reservation Date *</label>
                        <input type="date" class="form-control" id="reservation_date" name="reservation_date" value="2024-07-27" min="2024-07-27" max="2024-07-31" required>
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
                    </div>
                </div>
                <div class="form-group">
                    <label for="remarks" class="form-label">Special Request</label>
                    <textarea id="remarks" class="form-control" name="remarks" rows="4"></textarea>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="form-submit-btn">Make Reservation</button>
                </div>
            </form>

                <img src="/images/reservation.png" alt="Reservation Image" class="reservation-image" />
        </div>
    </div>

    <!-- Contact Section -->
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
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });
</script>