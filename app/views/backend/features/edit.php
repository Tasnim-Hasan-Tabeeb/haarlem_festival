<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1>Edit feature</h1>
    <div class="mt-4">
        <form action="/feature/update" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $feature['name'] ?>" required>
            </div>
            <div class="mb-5">
                <label for="image_url" class="form-label">Feature Image</label>
                <input type="file" class="form-control" id="image_url" name="image_url">
                <img src="<?= $feature['image_url'] ?>" class="mt-2" width="100" height="100" alt="Image">
            </div>
            <input type="hidden" name="id" value="<?= $feature['feature_id'] ?>">
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>