<?php include __DIR__ . '/../frontend/inc/header.php'; ?>

<link rel="stylesheet" href="/frontend/css/custom_page.css" />

<div class="white-space"></div>
<?php foreach ($sections as $section) : ?>
    <?php if ($section->getSectionType() === 'header') : ?>
        <div class="intro">
            <div class="text">
                <h1><?= $section->getSectionTitle() ?></h1>
                <p class=""><?= $section->getSubSectionTitle() ?></p>
                <?= $section->getContent() ?>
            </div>
            <div class="img-wrap">
                <img src="<?= $section->getImageUrl() ?>" />
            </div>
        </div>
    <?php elseif ($section->getSectionType() === 'tour_information') : ?>
        <div class="tour-information section">
            <h2><?= $section->getSectionTitle() ?></h2>
            <h3><?= $section->getSubSectionTitle() ?></h3>
            <div class="content">
                <?= $section->getContent() ?>
            </div>
            <?php if ($section->getImageUrl()) : ?>
                <div class="image">
                    <img src="<?= $section->getImageUrl() ?>" alt="<?= htmlspecialchars($section->getSectionTitle()) ?>">
                </div>
            <?php endif; ?>
        </div>
    <?php elseif ($section->getSectionType() === 'tour_route') : ?>
        <div class="tour-route section">
            <h2><?= $section->getSectionTitle() ?></h2>
            <h3><?= $section->getSubSectionTitle() ?></h3>
            <div class="content">
                <?= $section->getContent() ?>
            </div>
            <?php if ($section->getImageUrl()) : ?>
                <div class="image">
                    <img src="<?= $section->getImageUrl() ?>" alt="<?= htmlspecialchars($section->getSectionTitle()) ?>">
                </div>
            <?php endif; ?>
        </div>
    <?php elseif ($section->getSectionType() === 'available_timeslots') : ?>
        <div class="available-timeslots section">
            <h2><?= $section->getSectionTitle() ?></h2>
            <h3><?= $section->getSubSectionTitle() ?></h3>
            <div class="content">
                <?= $section->getContent() ?>
            </div>
            <?php if ($section->getImageUrl()) : ?>
                <div class="image">
                    <img src="<?= $section->getImageUrl() ?>" alt="<?= htmlspecialchars($section->getSectionTitle()) ?>">
                </div>
            <?php endif; ?>
        </div>
    <?php elseif ($section->getSectionType() === 'overview') : ?>
        <div class="overview section">
            <h2><?= $section->getSectionTitle() ?></h2>
            <h3><?= $section->getSubSectionTitle() ?></h3>
            <div class="content">
                <?= $section->getContent() ?>
            </div>
            <?php if ($section->getImageUrl()) : ?>
                <div class="image">
                    <img src="<?= $section->getImageUrl() ?>" alt="<?= htmlspecialchars($section->getSectionTitle()) ?>">
                </div>
            <?php endif; ?>
        </div>
    <?php elseif ($section->getSectionType() === 'location') : ?>
        <div class="location section">
            <h2><?= $section->getSectionTitle() ?></h2>
            <h3><?= $section->getSubSectionTitle() ?></h3>
            <div class="content">
                <?= $section->getContent() ?>
            </div>
            <?php if ($section->getMapUrl()) : ?>
                <div class="map">
                    <iframe src="<?= $section->getMapUrl() ?>" width="1500" height="550" allowfullscreen="" loading="lazy"></iframe>
                </div>
            <?php endif; ?>
        </div>
    <?php elseif ($section->getSectionType() === 'instruction') : ?>
        <div class="instruction section">
            <h2><?= $section->getSectionTitle() ?></h2>
            <h3><?= $section->getSubSectionTitle() ?></h3>
            <div class="content">
                <?= $section->getContent() ?>
            </div>
            <?php if ($section->getImageUrl()) : ?>
                <div class="image">
                    <img src="<?= $section->getImageUrl() ?>" alt="<?= htmlspecialchars($section->getSectionTitle()) ?>">
                </div>
            <?php endif; ?>
        </div>
    <?php elseif ($section->getSectionType() === 'bottom_section') : ?>
        <div class="bottom-section section">
            <h2><?= $section->getSectionTitle() ?></h2>
            <h3><?= $section->getSubSectionTitle() ?></h3>
            <div class="content">
                <?= $section->getContent() ?>
            </div>
            <?php if ($section->getImageUrl()) : ?>
                <div class="image">
                    <img src="<?= $section->getImageUrl() ?>" alt="<?= htmlspecialchars($section->getSectionTitle()) ?>">
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<?php include __DIR__ . '/../frontend/inc/footer.php'; ?>