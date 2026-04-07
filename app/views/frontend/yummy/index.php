<?php include __DIR__ . '/../inc/header.php' ?>
<link rel="stylesheet" href="/frontend/css/yummy.css" />

<div style="height: 50px;"></div> <!-- white-space -->

<?php foreach ($sections as $section) : ?>
    <?php if ($section->getSectionType() === 'header') : ?>
        <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; padding: 40px; background: #f8f8f8;">
            <div style="flex: 1; min-width: 300px; padding: 20px;">
                <h1 style="font-size: 2.5em; margin-bottom: 10px; color: #333;"><?= $section->getSectionTitle() ?></h1>
                <p style="font-size: 1.1em; color: #555; margin-bottom: 20px;"><?= $section->getSubSectionTitle() ?></p>
                <div style="font-size: 1em; color: #666; line-height: 1.6;"><?= $section->getContent() ?></div>
                <br>
                <a href="#restaurants-section" style="display:inline-block; margin-top:20px; padding:12px 25px; background:#ff6b6b; color:#fff; border-radius:5px; text-decoration:none; font-weight:bold; transition: background 0.3s;">Check out Restaurants</a>
            </div>
            <div style="flex: 1; min-width: 300px; text-align: center; padding: 20px;">
                <img src="<?= $section->getImageUrl() ?>" style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);" />
            </div>
        </div>
    <?php endif; ?>

    <div id="restaurants-section" style="padding: 50px 20px; background:#fff;">
        <div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap;">
            <h2 style="font-size: 2em; color:#333; margin:0;">Restaurants</h2>
        </div>

        <h3 style="font-size:1.5em; color:#444; margin-bottom: 10px;">Explore the Restaurants</h3>
        <p style="color:#666; line-height:1.7; max-width: 800px; margin-bottom: 40px;">
            Check out the awesome restaurants joining the fun below! From creative street food to refined culinary dishes, each restaurant brings its own unique flavors to the festival. Pick your favorites, discover new tastes, and get ready for a delicious adventure in the heart of Haarlem.
            <br><br>
            During the festival, talented chefs and popular local spots come together to serve bite-sized dishes, signature specialties, and exciting new creations for you to enjoy. It’s the perfect chance to sample dishes from multiple restaurants in one place and experience the vibrant food scene that makes Haarlem so special.
        </p>

        <div style="display: flex; flex-wrap: wrap; gap: 30px;">
            <?php foreach ($restaurants as $restaurant) : ?>
                <div style="flex: 1 1 300px; background:#fff; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.1); overflow:hidden; transition: transform 0.3s;">
                    <a href="/restaurant/details?id=<?= $restaurant['restaurant_id'] ?>" style="text-decoration:none; color: inherit;">
                        <div style="height: 200px; background-image: url('<?= $restaurant['image_url'] ?>'); background-size: cover; background-position: center;"></div>
                    </a>
                    <div style="padding:15px;">
                        <h4 style="font-size:1.2em; color:#333; margin:0 0 5px 0;"><?php echo htmlspecialchars($restaurant['title']); ?></h4>
                        <div style="color:#ffb400; margin-bottom:10px;">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <?php echo $i < $restaurant['ratings'] ? '★' : '☆'; ?>
                            <?php endfor; ?>
                        </div>
                        <p style="font-size:0.95em; color:#555; margin:5px 0;">Food Type: <?php echo htmlspecialchars($restaurant['cuisines']); ?></p>
                        <p style="font-size:0.95em; color:#555; margin:5px 0;">Available Seats: <?php echo $restaurant['number_of_seats']; ?></p>

                        <div style="display:flex; gap:10px; flex-wrap: wrap; margin:10px 0;">
                            <?php foreach ($restaurant['features'] as $feature) : ?>
                                <div style="display:flex; align-items:center; gap:5px; background:#f1f1f1; padding:5px 8px; border-radius:5px;">
                                    <img src="<?= $feature['image_url'] ?>" width="25" height="25" style="border-radius:3px;"/>
                                    <span style="font-size:0.85em; color:#333;"><?= $feature['name'] ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div style="border-top:1px solid #eee; padding-top:10px; margin-top:10px; display:flex; flex-direction: column; gap:5px;">
                            <p style="font-size:0.9em; color:#555;"><img src="/images/location-marker.png" style="height:16px; vertical-align:middle; margin-right:5px;"/> <?= htmlspecialchars($restaurant['location']); ?></p>
                            <p style="font-size:0.9em; color:#555;"><img src="/images/telephone.png" style="height:16px; vertical-align:middle; margin-right:5px;"/> <?= htmlspecialchars($restaurant['contact_phone']); ?></p>
                            <?php if (!empty($restaurant['sessions'])): ?>
                               <p style="font-size:0.9em; color:#555;">
                                    ⏰ <?= htmlspecialchars($restaurant['start_time']); ?> - <?= htmlspecialchars($restaurant['end_time']); ?>
                                </p>
                            <?php endif; ?>
                        </div>


                        <div style="
                            background: linear-gradient(135deg, #fff5f5, #ffecec);
                            border: 1px solid #ffd6d6;
                            border-radius: 8px;
                            padding: 10px 12px;
                            margin-top: 10px;
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                        ">
                            <div style="font-size: 0.9em; color:#333;">
                                👶 <strong>Child</strong><br>
                                <span style="color:#28a745; font-weight:bold;">
                                    €<?= number_format($restaurant['price_for_child'], 2) ?>
                                </span>
                            </div>

                            <div style="width:1px; height:35px; background:#ddd;"></div>

                            <div style="text-align:right; font-size: 0.9em; color:#333;">
                                🧑 <strong>Adult</strong><br>
                                <span style="color:#007bff; font-weight:bold;">
                                    €<?= number_format($restaurant['price_for_adult'], 2) ?>
                                </span>
                            </div>
                        </div>

                        <a href="/restaurant/details?id=<?= $restaurant['restaurant_id'] ?>" style="display:block; margin-top:15px; text-align:center; padding:10px 0; background:#ff6b6b; color:#fff; font-weight:bold; border-radius:5px; text-decoration:none; transition: background 0.3s;">Book Now</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>

<?php include __DIR__ . '/../inc/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({ behavior: 'smooth' });
        });
    });

    // hover effect for cards
    document.querySelectorAll('.restaurants-list > div').forEach(card => {
        card.addEventListener('mouseenter', () => card.style.transform = 'translateY(-5px)');
        card.addEventListener('mouseleave', () => card.style.transform = 'translateY(0)');
    });
});
</script>