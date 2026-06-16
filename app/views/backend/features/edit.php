<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1>Edit Feature</h1>

    <div class="mt-4">
        <form action="/feature/update" method="post" autocomplete="off" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="name" class="form-label">
                    Name <span class="text-danger">*</span>
                </label>

                <input type="text"
                       class="form-control"
                       id="name"
                       name="name"
                       placeholder="Enter feature name"
                       value="<?= htmlspecialchars($feature['name']) ?>"
                       required>
            </div>

            <div class="mb-3">
                <label for="image_url" class="form-label">Feature Image</label>

                <input type="file"
                       class="form-control"
                       id="image_url"
                       name="image_url">

                <?php if (!empty($feature['image_url'])) : ?>
                    <img src="<?= htmlspecialchars($feature['image_url']) ?>"
                         class="mt-2 img-thumbnail"
                         width="100"
                         height="100"
                         alt="Feature Image">
                <?php endif; ?>
            </div>

            <input type="hidden" name="id" value="<?= $feature['feature_id'] ?>">

            <button type="submit" class="btn btn-primary">
                Update
            </button>

        </form>
    </div>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>